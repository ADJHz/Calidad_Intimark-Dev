<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\User;

use App\Models\EncabezadoAuditoriaCorte;
use App\Models\AuditoriaProcesoCorte; 
use App\Models\AuditoriaProceso;  
use App\Models\AseguramientoCalidad;  
use App\Models\CategoriaTeamLeader;  
use App\Models\CategoriaTipoProblema; 
use App\Models\CategoriaAccionCorrectiva; 

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
            'categoriaTPProceso' => CategoriaTipoProblema::where('area', 'proceso')->get(),
            'categoriaTPPlayera' => CategoriaTipoProblema::where('area', 'playera')->get(),
            'categoriaTPEmpaque' => CategoriaTipoProblema::where('area', 'empaque')->get(),
            'categoriaACProceso' => CategoriaAccionCorrectiva::where('area', 'proceso')->get(),
            'categoriaACPlayera' => CategoriaAccionCorrectiva::where('area', 'playera')->get(),
            'categoriaACEmpaque' => CategoriaAccionCorrectiva::where('area', 'empaque')->get(),
            'teamLeaderPlanta1' => CategoriaTeamLeader::where('planta', 'Intimark1')->get(),
            'teamLeaderPlanta2' => CategoriaTeamLeader::where('planta', 'Intimark2')->get(),
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

        //dd($request->all(), $data);
        $nombresPlanta1= AuditoriaProceso::where('prodpoolid', 'Intimark1')
            ->where('moduleid', $data['modulo'])
            ->get();
        $nombresPlanta2= AuditoriaProceso::where('prodpoolid', 'Intimark2')
            ->where('moduleid', $data['modulo'])
            ->get();



        $fechaActual = Carbon::now()->toDateString();

        $mostrarRegistro = AseguramientoCalidad::whereDate('created_at', $fechaActual)
            ->where('modulo', $data['modulo'])
            ->where('area', $data['area'])
            ->get();

        $registros = AseguramientoCalidad::whereDate('created_at', $fechaActual)
            ->where('modulo', $data['modulo'])
            ->where('area', $data['area'])
            ->selectRaw('COALESCE(SUM(cantidad_auditada), 0) as total_auditada, COALESCE(SUM(cantidad_rechazada), 0) as total_rechazada')
            ->first();
        $total_auditada = $registros->total_auditada ?? 0;
        $total_rechazada = $registros->total_rechazada ?? 0;
        $total_porcentaje = $total_auditada != 0 ? ($total_rechazada / $total_auditada) * 100 : 0;


        $registrosIndividual = AseguramientoCalidad::whereDate('created_at', $fechaActual)
            ->where('modulo', $data['modulo'])
            ->where('area', $data['area'])
            ->selectRaw('nombre, SUM(cantidad_auditada) as total_auditada, SUM(cantidad_rechazada) as total_rechazada')
            ->groupBy('nombre')
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
            'nombresPlanta1' => $nombresPlanta1, 
            'nombresPlanta2' => $nombresPlanta2, 
            'total_auditada' => $total_auditada, 
            'total_rechazada' => $total_rechazada,
            'total_porcentaje' => $total_porcentaje,
            'registrosIndividual' => $registrosIndividual,
            'total_auditadaIndividual' => $total_auditadaIndividual, 
            'total_rechazadaIndividual' => $total_rechazadaIndividual,
            'total_porcentajeIndividual' => $total_porcentajeIndividual,
            'mostrarRegistro' => $mostrarRegistro]));
    }



    public function formAltaProceso(Request $request) 
    {
        $activePage ='';

        $data = [
            'area' => $request->area,
            'modulo' => $request->modulo,
            'estilo' => $request->estilo,
            'team_leader' => $request->team_leader,
            'auditor' => $request->auditor,
            'turno' => $request->turno,
        ];
        //dd($data);
        return redirect()->route('aseguramientoCalidad.auditoriaProceso', $data)->with('cambio-estatus', 'Iniciando en modulo: '. $data['modulo'])->with('activePage', $activePage);
    }

    public function formRegistroAuditoriaProceso(Request $request)
    {
        $activePage ='';
        // Obtener el ID seleccionado desde el formulario
        //dd($request->all());
        $nuevoRegistro = new AseguramientoCalidad();
        $nuevoRegistro->area = $request->area;
        $nuevoRegistro->modulo = $request->modulo;
        $nuevoRegistro->estilo = $request->estilo;
        $nuevoRegistro->team_leader = $request->team_leader;
        $nuevoRegistro->auditor = $request->auditor;
        $nuevoRegistro->turno = $request->turno;
        $nuevoRegistro->nombre = $request->nombre;
        $nuevoRegistro->operacion = $request->operacion;
        $nuevoRegistro->cantidad_auditada = $request->cantidad_auditada;
        $nuevoRegistro->cantidad_rechazada = $request->cantidad_rechazada;
        $nuevoRegistro->tp = $request->tp;
        $nuevoRegistro->ac = $request->ac;

        $nuevoRegistro->save();

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
