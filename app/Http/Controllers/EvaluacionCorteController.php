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

    public function formAltaEvaluacionCortes(Request $request)
    {
        $activePage ='';
        // Validar los datos del formulario si es necesario
        $activePage ='';
        // Validar los datos del formulario si es necesario
        // Obtener el ID seleccionado desde el formulario
        $idSeleccionado = $request->input('id');
        $idEncabezadoAuditoriaCorte = $request->input('idEncabezadoAuditoriaCorte');
        $orden = $request->input('orden');
        $estilo = $request->input('estilo');
        //dd($estilo, $request->all());
        $encabezadoAuditoriaCorte = EncabezadoAuditoriaCorte::where('id', $idEncabezadoAuditoriaCorte)->first();
        //dd($encabezadoAuditoriaCorte);
        // Verificar si ya existen datos para el dato_ax_id especificado
        if ($encabezadoAuditoriaCorte) {
            //dd($request->all());
            $encabezadoAuditoriaCorte->pieza = $request->input('pieza');
            $encabezadoAuditoriaCorte->lienzo = $request->input('lienzo');
            $encabezadoAuditoriaCorte->estatus = 'estatusAuditoriaMarcada';
            $encabezadoAuditoriaCorte->save();

            return back()->with('sobre-escribir', 'Ya existen datos para este registro.');
        }

        
        $datoAX = DatoAX::findOrFail($idSeleccionado);
        // Actualizar el valor de la columna deseada
        $datoAX->estatus = 'estatusAuditoriaMarcada';
        $datoAX->evento = $request->input('evento');
        $datoAX->save();
        //dd($datoAX->op);


        // Generar múltiples registros en auditoria_marcadas según el valor de evento
        for ($i = 0; $i < $request->input('evento'); $i++) {

            // Realizar la actualización en la base de datos
            $auditoria= new EncabezadoAuditoriaCorte();
            $auditoria->dato_ax_id = $idSeleccionado;
            $auditoria->orden_id = $orden;
            $auditoria->estilo_id = $estilo;
            $auditoria->cliente = $request->input('cliente');
            $auditoria->material = $request->input('material');
            $auditoria->color = $request->input('color');
            $auditoria->pieza = $request->input('pieza');
            $auditoria->trazo = $request->input('trazo');
            $auditoria->lienzo = $request->input('lienzo');
            $auditoria->evento = $i+1;
            // Establecer fecha_inicio con la fecha y hora actual
            $auditoria->fecha_inicio = Carbon::now()->format('Y-m-d H:i:s');
            if ($i === 0) {
                $auditoria->estatus = "estatusAuditoriaMarcada"; // Cambiar estatus solo para el primer registro
            } else {
                $auditoria->estatus = "proceso"; // Mantener el valor "proceso" para los demás registros
            }
            $auditoria->save();


            $auditoriaMarcada = new AuditoriaMarcada();
            $auditoriaMarcada->dato_ax_id = $idSeleccionado;
            $auditoriaMarcada->orden_id = $orden;
            if ($i === 0) {
                $auditoriaMarcada->estatus = "estatusAuditoriaMarcada"; // Cambiar estatus solo para el primer registro
            } else {
                $auditoriaMarcada->estatus = "proceso"; // Mantener el valor "proceso" para los demás registros
            }
            $auditoriaMarcada->evento = $i+1;
            // Otros campos que necesites para cada registro...
            
            $auditoriaMarcada->save();
            if ($i === 0) {
                $idEvento1 = $auditoriaMarcada->id;
            }

            $auditoriaTendido = new AuditoriaTendido();
            $auditoriaTendido->dato_ax_id = $idSeleccionado;
            $auditoriaTendido->orden_id = $orden;
            $auditoriaTendido->estatus = "proceso";
            $auditoriaTendido->evento = $i+1;
            $auditoriaTendido->save();

            $lectra = new Lectra();
            $lectra->dato_ax_id = $idSeleccionado;
            $lectra->orden_id = $orden;
            $lectra->estatus = "proceso";
            $lectra->evento = $i+1;
            $lectra->save();

            $auditoriaBulto = new AuditoriaBulto();
            $auditoriaBulto->dato_ax_id = $idSeleccionado;
            $auditoriaBulto->orden_id = $orden;
            $auditoriaBulto->estatus = "proceso";
            $auditoriaBulto->evento = $i+1;
            $auditoriaBulto->save();

            $auditoriaFinal = new AuditoriaFinal();
            $auditoriaFinal->dato_ax_id = $idSeleccionado;
            $auditoriaFinal->orden_id = $orden;
            $auditoriaFinal->estatus = "proceso";
            $auditoriaFinal->evento = $i+1;
            $auditoriaFinal->save();

        }

        return redirect()->route('auditoriaCorte.auditoriaCorte', ['id' => $idEvento1, 'orden' => $orden])->with('success', 'Datos guardados correctamente.')->with('activePage', $activePage);
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
