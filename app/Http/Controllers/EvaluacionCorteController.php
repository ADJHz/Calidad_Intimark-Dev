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
        $estilo = EncabezadoAuditoriaCorte::where('orden_id', $orden)->value('estilo_id');

        return response()->json($estilo);
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

    public function evaluaciondeCorte()
    {
        $activePage ='';
        $categorias = $this->cargarCategorias();
        $auditorDato = Auth::user()->name;
        //dd($userName);

        //dd($datoAX);
        $mesesEnEspanol = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];

        
        return view('evaluacionCorte.evaluaciondeCorte', array_merge($categorias, [
            'mesesEnEspanol' => $mesesEnEspanol, 
            'activePage' => $activePage, 
            'auditorDato' => $auditorDato]));
    }

    public function altaAuditoriaCorte($id, $orden)
    {
        $activePage ='';
        $categorias = $this->cargarCategorias();
        $auditorDato = Auth::user()->name;
        //dd($userName);
        // Obtener el dato con el id seleccionado y el valor de la columna "orden"
        $datoAX = DatoAX::where('op', $orden)->first();
        //dd($datoAX);
        $mesesEnEspanol = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];
        // Obtener el registro correspondiente en la tabla AuditoriaMarcada si existe
        $encabezadoAuditoriaCorte = EncabezadoAuditoriaCorte::where('id', $id)->first();
        $auditoriaMarcada = AuditoriaMarcada::where('id', $id)->first();
        $auditoriaTendido = AuditoriaTendido::where('id', $id)->first();
        $Lectra = Lectra::where('id', $id)->first();
        $auditoriaBulto = AuditoriaBulto::where('id', $id)->first();
        $auditoriaFinal = AuditoriaFinal::where('id', $id)->first();
        // apartado para validar los checbox

        $mostrarFinalizarMarcada = $auditoriaMarcada ? session('estatus_checked_AuditoriaMarcada') : false;
        
        // Verifica si los campos específicos son NULL
        if ($auditoriaMarcada && is_null($auditoriaMarcada->yarda_orden_estatus) &&
            is_null($auditoriaMarcada->yarda_marcada_estatus) &&
            is_null($auditoriaMarcada->yarda_tendido_estatus)) {
            $mostrarFinalizarMarcada = false;
        }
        
        //dd($auditoriaMarcada, $mostrarFinalizarMarcada);
        $mostrarFinalizarTendido = $auditoriaTendido ? session('estatus_checked_AuditoriaTendido') : false;
        $mostrarFinalizarLectra = $Lectra ? session('estatus_checked_Lectra') : false;
        $mostrarFinalizarBulto = $auditoriaBulto ? session('estatus_checked_AuditoriaBulto') : false;
        $mostrarFinalizarFinal = $auditoriaFinal ? session('estatus_checked_AuditoriaFinal') : false;
        return view('auditoriaCorte.altaAuditoriaCorte', array_merge($categorias, [
            'mesesEnEspanol' => $mesesEnEspanol, 
            'activePage' => $activePage, 
            'datoAX' => $datoAX, 
            'auditoriaMarcada' => $auditoriaMarcada,
            'auditoriaTendido' => $auditoriaTendido,
            'Lectra' => $Lectra, 
            'auditoriaBulto' => $auditoriaBulto, 
            'auditoriaFinal' => $auditoriaFinal,
            'mostrarFinalizarMarcada' => $mostrarFinalizarMarcada,
            'mostrarFinalizarTendido' => $mostrarFinalizarTendido,
            'mostrarFinalizarLectra' => $mostrarFinalizarLectra,
            'mostrarFinalizarBulto' => $mostrarFinalizarBulto,
            'mostrarFinalizarFinal' => $mostrarFinalizarFinal,
            'encabezadoAuditoriaCorte' => $encabezadoAuditoriaCorte,
            'auditorDato' => $auditorDato]));
    }


}
