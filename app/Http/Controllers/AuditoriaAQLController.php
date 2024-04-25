<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AuditoriaProceso;  
use App\Models\AseguramientoCalidad;  
use App\Models\CategoriaTeamLeader;  
use App\Models\CategoriaTipoProblema; 
use App\Models\CategoriaAccionCorrectiva;  
use App\Models\AuditoriaAQL;  
use App\Models\DatoAX;
use App\Models\DatosAX;
use App\Models\EvaluacionCorte;
use Carbon\Carbon; // Asegúrate de importar la clase Carbon

class AuditoriaAQLController extends Controller
{

    // Método privado para cargar las categorías
    private function cargarCategorias() {
        $fechaActual = Carbon::now()->toDateString();
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
            'procesoActualAQL' => AuditoriaAQL::where('estatus', NULL)
                ->where('area', 'AUDITORIA AQL')
                ->whereDate('created_at', $fechaActual)
                ->select('area','modulo','op', 'team_leader', 'turno', 'auditor', 'estilo', 'cliente')
                ->distinct()
                ->get(),
            'procesoFinalAQL' => AuditoriaAQL::where('estatus', 1)
                ->where('area', 'AUDITORIA AQL')
                ->whereDate('created_at', $fechaActual)
                ->select('area','modulo','op', 'team_leader', 'turno', 'auditor', 'estilo', 'cliente')
                ->distinct()
                ->get(),
            'playeraActualAQL' => AuditoriaAQL::where('estatus', NULL)
                ->where('area', 'AUDITORIA AQL PLAYERA')
                ->whereDate('created_at', $fechaActual)
                ->select('area','modulo','op', 'team_leader', 'turno', 'auditor', 'estilo', 'cliente')
                ->distinct()
                ->get(),
            'playeraFinalAQL' => AuditoriaAQL::where('estatus', 1)
                ->where('area', 'AUDITORIA AQL PLAYERA')
                ->whereDate('created_at', $fechaActual)
                ->select('area','modulo','op', 'team_leader', 'turno', 'auditor', 'estilo', 'cliente')
                ->distinct()
                ->get(),
            'ordenOPs' => DatoAX::select('op')
                ->distinct()
                ->get(),

        ];
    }



    public function altaAQL(Request $request)
    {
        $activePage ='';
        $categorias = $this->cargarCategorias();


        //dd($registroEvaluacionCorte->all()); 
        $mesesEnEspanol = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];

        
        return view('auditoriaAQL.altaAQL', array_merge($categorias, [
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

    public function auditoriaAQL(Request $request)
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

        $datoOP = DatosAX::whereIn('op', (array) $data['op'])
        ->get();
        $datoUnicoOP = DatosAX::where('op', $data['op'])
        ->first();



        $fechaActual = Carbon::now()->toDateString();

        $mostrarRegistro = AuditoriaAQL::whereDate('created_at', $fechaActual)
            ->where('modulo', $data['modulo'])
            ->where('area', $data['area'])
            ->get();
        $estatusFinalizar = AuditoriaAQL::whereDate('created_at', $fechaActual)
        ->where('modulo', $data['modulo'])
        ->where('area', $data['area'])
        ->where('estatus', 1)
        ->exists();

        $registros = AuditoriaAQL::whereDate('created_at', $fechaActual)
            ->where('modulo', $data['modulo'])
            ->where('area', $data['area'])
            ->selectRaw('COALESCE(SUM(cantidad_auditada), 0) as total_auditada, COALESCE(SUM(cantidad_rechazada), 0) as total_rechazada')
            ->first();
        $total_auditada = $registros->total_auditada ?? 0;
        $total_rechazada = $registros->total_rechazada ?? 0;
        $total_porcentaje = $total_auditada != 0 ? ($total_rechazada / $total_auditada) * 100 : 0;


        $registrosIndividual = AuditoriaAQL::whereDate('created_at', $fechaActual)
            ->where('modulo', $data['modulo'])
            ->where('area', $data['area'])
            ->selectRaw('SUM(cantidad_auditada) as total_auditada, SUM(cantidad_rechazada) as total_rechazada')
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

        

        
        return view('auditoriaAQL.auditoriaAQL', array_merge($categorias, [
            'mesesEnEspanol' => $mesesEnEspanol, 
            'activePage' => $activePage,
            'datoOP' => $datoOP, 
            'datoUnicoOP' => $datoUnicoOP, 
            'data' => $data, 
            'total_auditada' => $total_auditada, 
            'total_rechazada' => $total_rechazada,
            'total_porcentaje' => $total_porcentaje,
            'registrosIndividual' => $registrosIndividual,
            'total_auditadaIndividual' => $total_auditadaIndividual, 
            'total_rechazadaIndividual' => $total_rechazadaIndividual,
            'total_porcentajeIndividual' => $total_porcentajeIndividual,
            'estatusFinalizar' => $estatusFinalizar,
            'mostrarRegistro' => $mostrarRegistro]));
    }



    public function formAltaProcesoAQL(Request $request) 
    {
        $activePage ='';

        $data = [
            'area' => $request->area,
            'modulo' => $request->modulo,
            'estilo' => $request->estilo,
            'op' => $request->op,
            'cliente' => $request->cliente,
            'auditor' => $request->auditor,
            'turno' => $request->turno, 
            'team_leader' => $request->team_leader,
        ];
        //dd($data);
        return redirect()->route('auditoriaAQL.auditoriaAQL', $data)->with('cambio-estatus', 'Iniciando en modulo: '. $data['modulo'])->with('activePage', $activePage);
    }

    public function formRegistroAuditoriaProceso(Request $request)
    {
        $activePage ='';
        // Obtener el ID seleccionado desde el formulario
        //dd($request->all());
        $nuevoRegistro = new AuditoriaAQL();
        $nuevoRegistro->area = $request->area;
        $nuevoRegistro->modulo = $request->modulo;
        $nuevoRegistro->op = $request->op;
        $nuevoRegistro->cliente = $request->cliente;
        $nuevoRegistro->team_leader = $request->team_leader;
        $nuevoRegistro->auditor = $request->auditor;
        $nuevoRegistro->turno = $request->turno;

        $nuevoRegistro->estilo = $request->estilo;
        $nuevoRegistro->color = $request->color; 
        $nuevoRegistro->talla = $request->talla; 
        $nuevoRegistro->bulto = $request->bulto; 
        $nuevoRegistro->cantidad_auditada = $request->cantidad_auditada;
        $nuevoRegistro->cantidad_rechazada = $request->cantidad_rechazada;
        $nuevoRegistro->tp = $request->tp;
        $nuevoRegistro->save();

        return back()->with('success', 'Datos guardados correctamente.')->with('activePage', $activePage);
    }

    
    public function formUpdateDeleteProceso(Request $request){
        $activePage ='';
        $action = $request->input('action');

        $id = $request->input('id');
        //dd($request->all());
        if($action == 'update'){
            $actualizarRegistro = AuditoriaAQL::where('id', $id)->first();
            $actualizarRegistro->talla = $request->talla;
            $actualizarRegistro->bulto = $request->bulto;
            $actualizarRegistro->cantidad_auditada = $request->cantidad_auditada;
            $actualizarRegistro->cantidad_rechazada = $request->cantidad_rechazada;
            $actualizarRegistro->tp = $request->tp;
            $actualizarRegistro->save();

            //dd($request->all(), $actualizarRegistro, $id);
            return back()->with('sobre-escribir', 'Registro actualizado correctamente.')->with('activePage', $activePage);

            // Lógica para actualizar el registro
        } elseif ($action == 'delete'){
            // Lógica para eliminar el registro
            AuditoriaAQL::where('id', $id)->delete();
            return back()->with('error', 'Registro eliminado.')->with('activePage', $activePage);
        }

        //dd($request->all(), $request->input('descripcion_parte1'), $id);
        return back()->with('cambio-estatus', 'Datos guardados correctamente.')->with('activePage', $activePage);
    }

    public function formFinalizarProceso(Request $request)
    {
        $activePage ='';
        // Obtener el ID seleccionado desde el formulario
        $area = $request->input('area');
        $modulo = $request->input('modulo');
        $observacion = $request->input('observacion');
        $estatus=1;
        //dd($request->all(), $area);
        // Asegurarse de que la variable $data esté definida
        $data = $data ?? [];
        $fechaActual = Carbon::now()->toDateString();

        // Actualizar todos los registros que cumplan con las condiciones
        AuditoriaAQL::whereDate('created_at', $fechaActual)
        ->where('modulo', $modulo)
        ->where('area', $area)
        ->update(['observacion' => $observacion, 'estatus' => $estatus]);
        

        return back()->with('success', 'Finalizacion aplicada correctamente.')->with('activePage', $activePage);
    }

}
