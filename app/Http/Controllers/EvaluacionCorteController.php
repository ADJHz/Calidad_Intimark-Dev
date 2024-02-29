<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CategoriaAuditor;
use App\Models\CategoriaTecnico;
use App\Models\CategoriaCliente;
use App\Models\CategoriaColor;
use App\Models\CategoriaEstilo;
use App\Models\CategoriaNoRecibo;
use App\Models\CategoriaTallaCantidad;
use App\Models\CategoriaTamañoMuestra;
use App\Models\CategoriaDefecto;
use App\Models\CategoriaTipoDefecto;
use App\Models\CategoriaMaterialRelajado;
use App\Models\CategoriaDefectoCorte;
use App\Models\EncabezadoAuditoriaCorte;
use App\Models\AuditoriaMarcada;
use App\Models\AuditoriaTendido;
use App\Models\Lectra;
use App\Models\AuditoriaBulto;
use App\Models\AuditoriaFinal;

use App\Exports\DatosExport;
use App\Models\DatoAX;
use App\Models\EvaluacionCorte;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon; // Asegúrate de importar la clase Carbon

class EvaluacionCorteController extends Controller
{

    // Método privado para cargar las categorías
    private function cargarCategorias() {
        return [ 
            'CategoriaCliente' => CategoriaCliente::where('estado', 1)->get(),
            'CategoriaColor' => CategoriaColor::where('estado', 1)->get(),
            'CategoriaEstilo' => CategoriaEstilo::where('estado', 1)->get(),
            'CategoriaNoRecibo' => CategoriaNoRecibo::where('estado', 1)->get(),
            'CategoriaTallaCantidad' => CategoriaTallaCantidad::where('estado', 1)->get(),
            'CategoriaTamañoMuestra' => CategoriaTamañoMuestra::where('estado', 1)->get(),
            'CategoriaMaterialRelajado' => CategoriaMaterialRelajado::where('estado', 1)->get(),
            'CategoriaDefecto' => CategoriaDefecto::where('estado', 1)->get(),
            'CategoriaTipoDefecto' => CategoriaTipoDefecto::where('estado', 1)->get(),
            'CategoriaAuditor' => CategoriaAuditor::where('estado', 1)->get(),
            'CategoriaTecnico' => CategoriaTecnico::where('estado', 1)->get(),
            'CategoriaDefectoCorte' => CategoriaDefectoCorte::where('estado', 1)->get(),
            'DatoAX' => DatoAX::where(function($query) {
                $query->whereNull('estatus')
                      ->orWhere('estatus', '');
            })->get(),
            'DatoAXNoIniciado' => DatoAX::whereNotIn('estatus', ['fin'])
                           ->where(function ($query) {
                               $query->whereNull('estatus')
                                     ->orWhere('estatus', '');
                           })
                           ->get(),
            'DatoAXProceso' => DatoAX::whereNotIn('estatus', ['fin'])
                           ->whereNotNull('estatus')
                           ->whereNotIn('estatus', [''])
                           ->with('auditoriasMarcadas')
                           ->get(),
            'DatoAXFin' => DatoAX::where('estatus', 'fin')->get(),
            'EncabezadoAuditoriaCorte' => EncabezadoAuditoriaCorte::all(),
            'auditoriasMarcadas' => AuditoriaMarcada::all(),
        ];
    }

    public function obtenerEstilo(Request $request) 
    {
        $orden = $request->input('orden_id');
        $encabezado = EncabezadoAuditoriaCorte::where('orden_id', $orden)->first();

        if (!$encabezado) {
            return response()->json(['error' => 'No se encontró el encabezado para la orden especificada']);
        }

        $datos = [
            'estilo' => $encabezado->estilo_id,
            'evento' => $encabezado->evento
        ];

        return response()->json($datos);
    } 

    public function inicioEvaluacionCorte()
    {
        $activePage ='';
        $categorias = $this->cargarCategorias();


        $mesesEnEspanol = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];

        return view('evaluacionCorte.inicioEvaluacionCorte', array_merge($categorias, ['mesesEnEspanol' => $mesesEnEspanol, 'activePage' => $activePage]));
    }

    public function evaluaciondeCorte($ordenId, $eventoId)
    {
        $activePage ='';
        $categorias = $this->cargarCategorias();
        $auditorDato = Auth::user()->name;
        //dd($userName);
        $encabezadoAuditoriaCorte = EncabezadoAuditoriaCorte::where('orden_id', $ordenId)
            ->where('evento', $eventoId)
            ->first();
        //dd($encabezadoAuditoriaCorte);
        $mesesEnEspanol = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];

        
        return view('evaluacionCorte.evaluaciondeCorte', array_merge($categorias, [
            'mesesEnEspanol' => $mesesEnEspanol, 
            'activePage' => $activePage, 
            'encabezadoAuditoriaCorte' => $encabezadoAuditoriaCorte,
            'auditorDato' => $auditorDato]));
    }


    public function formRegistro(Request $request)
    {
        $activePage ='';
        // Obtener el ID seleccionado desde el formulario
        $ordenId = $request->input('orden');
        $eventoId = $request->input('evento');
        $estilo = $request->input('estilo');
        //dd($ordenId, $eventoId, $estilo, $request->all());
        
        //dd($estilo, $request->all());
        $encabezadoAuditoriaCorte = EncabezadoAuditoriaCorte::where('orden_id', $ordenId)
            ->where('evento', $eventoId)
            ->first();
        //dd($encabezadoAuditoriaCorte);

        $evaluacionCorte = new EvaluacionCorte();
        $evaluacionCorte->orden_id = $ordenId;
        $evaluacionCorte->evento = $eventoId;
        $evaluacionCorte->estilo_id = $estilo;
        $evaluacionCorte->descripcion_parte = $request->input('descripcion_parte');
        $evaluacionCorte->izquierda_x = $request->input('izquierda_x');
        $evaluacionCorte->izquierda_y = $request->input('izquierda_y');
        $evaluacionCorte->derecha_x = $request->input('derecha_x');
        $evaluacionCorte->derecha_y = $request->input('derecha_y');
        
        $evaluacionCorte->save();

        return back()->with('success', 'Datos guardados correctamente.')->with('activePage', $activePage);
    }

}
