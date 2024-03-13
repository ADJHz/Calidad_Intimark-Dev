<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\User;

use App\Models\EncabezadoAuditoriaCorte;
use App\Models\AuditoriaProcesoCorte; 
use App\Models\AuditoriaProceso; 

use App\Models\EvaluacionCorte;
use Carbon\Carbon; // Asegúrate de importar la clase Carbon

class AuditoriaProcesoController extends Controller
{

    // Método privado para cargar las categorías
    private function cargarCategorias() {
        return [
            'auditorDato' => Auth::user()->name,
            'auditorPlanta' => Auth::user()->Planta,
            'AuditoriaProceso' => AuditoriaProceso::all(),
            'auditoriaProcesoIntimark1' =>  AuditoriaProceso::where('prodpoolid', 'Intimark1')
                ->select('moduleid', 'itemid')
                ->distinct()
                ->get(),
            'auditoriaProcesoIntimark2' => AuditoriaProceso::where('prodpoolid', 'Intimark2')
                ->select('moduleid', 'itemid')
                ->distinct()
                ->get(), 

        ];
    }



    public function altaProceso(Request $request)
    {
        $activePage ='';
        $categorias = $this->cargarCategorias();


        //dd($registroEvaluacionCorte->all()); 
        $mesesEnEspanol = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];

        
        return view('aseguramientoCalidad.altaProceso', array_merge($categorias, [
            'mesesEnEspanol' => $mesesEnEspanol, 
            'activePage' => $activePage]));
    }

    public function obtenerItemId(Request $request)
    {
        $moduleid = $request->input('moduleid');
        $auditoriaProceso = AuditoriaProceso::where('moduleid', $moduleid)->first();
        $itemid = $auditoriaProceso ? $auditoriaProceso->itemid : '';
        
        return response()->json(['itemid' => $itemid]);
    }

    public function auditoriaProceso(Request $request)
    {
        
        $activePage ='';
        $mesesEnEspanol = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];
        $categorias = $this->cargarCategorias();
        // Obtener los datos de la solicitud
        $data = $request->all();
        // Asegurarse de que la variable $data esté definida
        $data = $data ?? [];

        dd($request->input('modulo'),$request->all(), $data);

        $fechaActual = Carbon::now()->toDateString();

        $mostrarRegistro = AuditoriaProcesoCorte::whereDate('created_at', $fechaActual)
            ->where('area', $data['area'])
            ->get();

        $registros = AuditoriaProcesoCorte::whereDate('created_at', $fechaActual)
            ->where('area', $data['area'])
            ->selectRaw('COALESCE(SUM(cantidad_auditada), 0) as total_auditada, COALESCE(SUM(cantidad_rechazada), 0) as total_rechazada')
            ->first();
        $total_auditada = $registros->total_auditada ?? 0;
        $total_rechazada = $registros->total_rechazada ?? 0;
        $total_porcentaje = $total_auditada != 0 ? ($total_rechazada / $total_auditada) * 100 : 0;


        $registrosIndividual = AuditoriaProcesoCorte::whereDate('created_at', $fechaActual)
            ->where('area', $data['area'])
            ->selectRaw('nombre_1, nombre_2, SUM(cantidad_auditada) as total_auditada, SUM(cantidad_rechazada) as total_rechazada')
            ->groupBy('nombre_1', 'nombre_2')
            ->get();

        // Inicializa las variables para evitar errores
        $total_auditadaIndividual = 0;
        $total_rechazadaIndividual = 0;

        // Calcula la suma total solo si hay registros individuales
        if ($registrosIndividual->isNotEmpty()) {
            $total_auditadaIndividual = $registrosIndividual->sum('total_auditada');
            $total_rechazadaIndividual = $registrosIndividual->sum('total_rechazada');
        }
        //dd($registros, $fechaActual);
        // Calcula el porcentaje total
        $total_porcentajeIndividual = $total_auditadaIndividual != 0 ? ($total_rechazadaIndividual / $total_auditadaIndividual) * 100 : 0;

        

        
        return view('aseguramientoCalidad.auditoriaProceso', array_merge($categorias, [
            'mesesEnEspanol' => $mesesEnEspanol, 
            'activePage' => $activePage,
            'data' => $data, 
            'total_auditada' => $total_auditada, 
            'total_rechazada' => $total_rechazada,
            'total_porcentaje' => $total_porcentaje,
            'registrosIndividual' => $registrosIndividual,
            'total_auditadaIndividual' => $total_auditadaIndividual, 
            'total_rechazadaIndividual' => $total_rechazadaIndividual,
            'total_porcentajeIndividual' => $total_porcentajeIndividual,
            'mostrarRegistro' => $mostrarRegistro]));
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


    public function formAltaProceso(Request $request) 
    {
        $activePage ='';

        $data = [
            'area' => $request->area,
            'estilo' => $request->estilo,
            'supervisor' => $request->supervisor,
            'auditor' => $request->auditor,
            'turno' => $request->turno,
        ];
        //dd($data);
        return redirect()->route('aseguramientoCalidad.auditoriaProceso', $data)->with('success', 'Datos guardados correctamente.')->with('activePage', $activePage);
    }

    public function formRegistroAuditoriaProceso(Request $request)
    {
        $activePage ='';
        // Obtener el ID seleccionado desde el formulario
        //dd($request->all());
        $procesoCorte = new AuditoriaProcesoCorte();
        $procesoCorte->area = $request->area;
        $procesoCorte->estilo = $request->estilo;
        $procesoCorte->orden_id = $request->orden_id;
        $procesoCorte->estilo_id = $request->estilo_id;
        $procesoCorte->supervisor_corte = $request->supervisor_corte;
        $procesoCorte->auditor = $request->auditor;
        $procesoCorte->turno = $request->turno;
        $procesoCorte->nombre_1 = $request->nombre_1;
        $procesoCorte->nombre_2 = $request->nombre_2;
        $procesoCorte->operacion = $request->operacion;
        $procesoCorte->mesa = $request->mesa;
        $procesoCorte->cantidad_auditada = $request->cantidad_auditada;
        $procesoCorte->cantidad_rechazada = $request->cantidad_rechazada;
        $procesoCorte->tp = $request->tp;
        $procesoCorte->ac = $request->ac;

        $procesoCorte->save();

        return back()->with('success', 'Datos guardados correctamente.')->with('activePage', $activePage);
    }

    
    public function formFinalizar(Request $request)
    {
        $activePage ='';
        // Obtener el ID seleccionado desde el formulario
        $ordenId = $request->input('orden');
        $eventoId = $request->input('evento');
        //dd($ordenId, $eventoId, $estilo, $request->all());
        
        //dd($estilo, $request->all());
        $evaluacionCorte = EncabezadoAuditoriaCorte::where('orden_id', $ordenId)
            ->where('evento', $eventoId)
            ->first();
        $evaluacionCorte->estatus_evaluacion_corte = 1;
        $evaluacionCorte->save();
        //dd($evaluacionCorte, $ordenId, $eventoId);

        return back()->with('success', 'Datos guardados correctamente.')->with('activePage', $activePage);
    }

}
