<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\EncabezadoAuditoriaCorte;
use App\Models\Lectra; 
use App\Models\AuditoriaProcesoCorte; 
use App\Models\AseguramientoCalidad;  
use App\Models\AuditoriaAQL;  
use Carbon\Carbon; // Asegúrate de importar la clase Carbon

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $title = "";
        $fechaActual = Carbon::now()->toDateString();


        // Verifica si el usuario tiene los roles 'Administrador' o 'Gerente de Calidad'
        if (Auth::check() && (Auth::user()->hasRole('Administrador') || Auth::user()->hasRole('Gerente de Calidad'))) {

            // Obtener la suma total de la columna 'porcentaje' de Lectra
            $sumaPorcentaje = Lectra::whereNotNull('porcentaje')->sum('porcentaje');
            // Obtener el número total de registros en la tabla Lectra
            $totalRegistros = Lectra::whereNotNull('porcentaje')->count();
            // Calcular el porcentaje total
            $porcentajeTotalCorte = $totalRegistros > 0 ? number_format(($totalRegistros / $sumaPorcentaje) * 100, 2) : 0;
            // Obtener el número total de registros en la tabla Lectra sin valores nulos y "0"
            $corteRechazados = Lectra::whereNotNull('porcentaje')->where('porcentaje', '!=', 0)->count();
            // Obtener el número total de registros en la tabla Lectra con valores "0"
            $corteAprobados = Lectra::where('porcentaje', 0)->count();

            // Obtener los datos de cantidad_auditada y cantidad_rechazada de AuditoriaProcesoCorte
            $cantidadAuditada = AuditoriaProcesoCorte::sum('cantidad_auditada');
            $cantidadRechazada = AuditoriaProcesoCorte::sum('cantidad_rechazada');
            // Calcular el porcentaje total de los registros actuales
            $totalPorcentajeProceso = $cantidadAuditada != 0 ? number_format(($cantidadRechazada / $cantidadAuditada) * 100, 2) : 0;
            // Obtener el número total de registros en la tabla AuditoriaProcesoCorte sin valores nulos y "0"
            $procesoRechazados = AuditoriaProcesoCorte::whereNotNull('cantidad_rechazada')->where('cantidad_rechazada', '!=', 0)->count();
            // Obtener el número total de registros en la tabla AuditoriaProcesoCorte con valores "0"
            $procesoAprobados = AuditoriaProcesoCorte::where('cantidad_rechazada', 0)->count();

            // Obtener los datos de cantidad_auditada y cantidad_rechazada de AseguramientoCalidad
            $cantidadAuditadaPlayera = AseguramientoCalidad::sum('cantidad_auditada');
            $cantidadRechazadaPlayera = AseguramientoCalidad::sum('cantidad_rechazada');
            // Calcular el porcentaje total de los registros actuales
            $totalPorcentajePlayera = $cantidadAuditadaPlayera != 0 ? number_format(($cantidadRechazadaPlayera / $cantidadAuditadaPlayera) * 100, 2) : 0;
            // Obtener el número total de registros en la tabla AseguramientoCalidad sin valores nulos y "0"
            $playeraRechazados = AseguramientoCalidad::whereNotNull('cantidad_rechazada')->where('cantidad_rechazada', '!=', 0)->count();
            // Obtener el número total de registros en la tabla AseguramientoCalidad con valores "0"
            $playeraAprobados = AseguramientoCalidad::where('cantidad_rechazada', 0)->count();

            // Obtener los datos de cantidad_auditada y cantidad_rechazada de AuditoriaAQL
            $cantidadAuditadaAQL = AuditoriaAQL::sum('cantidad_auditada');
            $cantidadRechazadaAQL = AuditoriaAQL::sum('cantidad_rechazada');
            // Calcular el porcentaje total de los registros actuales
            $totalPorcentajeAQL = $cantidadAuditadaAQL != 0 ? number_format(($cantidadRechazadaAQL / $cantidadAuditadaAQL) * 100, 2) : 0;
            // Obtener el número total de registros en la tabla AuditoriaAQL sin valores nulos y "0"
            $aQLRechazados = AuditoriaAQL::whereNotNull('cantidad_rechazada')->where('cantidad_rechazada', '!=', 0)->count();
            // Obtener el número total de registros en la tabla AuditoriaAQL con valores "0"
            $aQLAprobados = AuditoriaAQL::where('cantidad_rechazada', 0)->count();
            //dd($aQLRechazados, $aQLAprobados);

            $concentradoTotalSuma = $sumaPorcentaje + $cantidadAuditada + $cantidadAuditadaPlayera + $cantidadAuditadaAQL;
            $concentradoTotalRechazo = $totalRegistros + $cantidadRechazada + $cantidadRechazadaPlayera + $cantidadRechazadaAQL;
            $concentradoTotalPorcentaje = $concentradoTotalSuma != 0 ? number_format(($concentradoTotalRechazo / $concentradoTotalSuma) * 100, 2) : 0;

            $concentradoTotalAprobado = $corteAprobados + $procesoAprobados + $playeraAprobados + $aQLAprobados;
            $concentradoTotalRechazado = $corteRechazados + $procesoRechazados + $playeraRechazados +$aQLRechazados;

            //conteo de registros de plantas AQL por dia 
            $conteoBultosDia = AuditoriaAQL::whereDate('created_at', $fechaActual)
                ->count();
            //conteo de registros del dia respecto a los rechazos
            $conteoPiezaConRechazoDia = AuditoriaAQL::whereDate('created_at', $fechaActual)
                ->where('cantidad_rechazada', '>', 0)
                ->count('pieza');
            $conteoPiezaAceptadoDia = $conteoBultosDia - $conteoPiezaConRechazoDia;

            //conteo de registros de plantas AQL por dia y separado por plantas, primero planta 1
            $conteoBultosDiaPlanta1 = AuditoriaAQL::whereDate('created_at', $fechaActual)
                ->where('planta', 'Intimark1')
                ->count();
            //conteo de registros del dia respecto a los rechazos
            $conteoPiezaConRechazoDiaPlanta1 = AuditoriaAQL::whereDate('created_at', $fechaActual)
                ->where('planta', 'Intimark1')
                ->where('cantidad_rechazada', '>', 0)
                ->count('pieza');
            $conteoPiezaAceptadoDiaPlanta1 = $conteoBultosDiaPlanta1 - $conteoPiezaConRechazoDiaPlanta1;

            //conteo de registros de plantas AQL por dia y separado por plantas, primero planta 2
            $conteoBultosDiaPlanta2 = AuditoriaAQL::whereDate('created_at', $fechaActual)
                ->where('planta', 'Intimark2')
                ->count();
            //conteo de registros del dia respecto a los rechazos
            $conteoPiezaConRechazoDiaPlanta2 = AuditoriaAQL::whereDate('created_at', $fechaActual)
                ->where('planta', 'Intimark2')
                ->where('cantidad_rechazada', '>', 0)
                ->count('pieza');
            $conteoPiezaAceptadoDiaPlanta2 = $conteoBultosDiaPlanta2 - $conteoPiezaConRechazoDiaPlanta2;


            //apartado para mostrar datos de gerente de prodduccion, en este caso por dia  AuditoriaAQL
            $gerentesProduccion = AuditoriaAQL::where('jefe_produccion', 1)
                ->whereDate('created_at', $fechaActual)
                ->select('team_leader')
                ->distinct()
                ->get();

            $porcentajesErrorGerenteProduccion = [];
            $modulosPorGerenteProduccion = [];

            foreach ($gerentesProduccion as $gerenteProduccion) {
                $teamLeader = $gerenteProduccion->team_leader;

                $modulosUnicos = AuditoriaAQL::where('team_leader', $teamLeader)
                    ->whereDate('created_at', $fechaActual)
                    ->select('modulo')
                    ->distinct()
                    ->count('modulo');

                $modulosPorGerenteProduccion[$teamLeader] = $modulosUnicos;

                $sumaAuditadaGerenteProduccion = AuditoriaAQL::where('team_leader', $teamLeader)
                    ->whereDate('created_at', $fechaActual)
                    ->sum('cantidad_auditada');

                $sumaRechazadaGerenteProduccion = AuditoriaAQL::where('team_leader', $teamLeader)
                    ->whereDate('created_at', $fechaActual)
                    ->sum('cantidad_rechazada');

                $porcentajeErrorGerenteProduccion = ($sumaAuditadaGerenteProduccion != 0) ? ($sumaRechazadaGerenteProduccion / $sumaAuditadaGerenteProduccion) * 100 : 0;

                $porcentajesErrorGerenteProduccion[$teamLeader] = $porcentajeErrorGerenteProduccion;
            }

            arsort($porcentajesErrorGerenteProduccion);


            //apartado para mostrar datos de gerente de prodduccion, en este caso por dia AseguramientoCalidad  
            $gerentesProduccionProceso = AseguramientoCalidad::where('jefe_produccion', 1)
                ->whereDate('created_at', $fechaActual)
                ->select('team_leader')
                ->distinct()
                ->get();

            $porcentajesErrorGerenteProduccionProceso = [];
            $modulosPorGerenteProduccionProceso = [];

            foreach ($gerentesProduccionProceso as $gerenteProduccion) {
                $teamLeader = $gerenteProduccion->team_leader;

                $modulosUnicos = AseguramientoCalidad::where('team_leader', $teamLeader)
                    ->whereDate('created_at', $fechaActual)
                    ->select('modulo')
                    ->distinct()
                    ->count('modulo');

                $modulosPorGerenteProduccionProceso[$teamLeader] = $modulosUnicos;

                $sumaAuditadaGerenteProduccion = AseguramientoCalidad::where('team_leader', $teamLeader)
                    ->whereDate('created_at', $fechaActual)
                    ->sum('cantidad_auditada');

                $sumaRechazadaGerenteProduccion = AseguramientoCalidad::where('team_leader', $teamLeader)
                    ->whereDate('created_at', $fechaActual)
                    ->sum('cantidad_rechazada');

                $porcentajeErrorGerenteProduccion = ($sumaAuditadaGerenteProduccion != 0) ? ($sumaRechazadaGerenteProduccion / $sumaAuditadaGerenteProduccion) * 100 : 0;

                $porcentajesErrorGerenteProduccionProceso[$teamLeader] = $porcentajeErrorGerenteProduccion;
            }

            arsort($porcentajesErrorGerenteProduccionProceso);

            //apartado para mostrar datos de gerente de prodduccion, en este caso por dia AseguramientoCalidad y AuditoriaAQL
            $gerentesProduccionAQL = AuditoriaAQL::where('jefe_produccion', 1)
                ->whereDate('created_at', $fechaActual)
                ->select('team_leader')
                ->distinct()
                ->pluck('team_leader')
                ->all();

            $gerentesProduccionProceso = AseguramientoCalidad::where('jefe_produccion', 1)
                ->whereDate('created_at', $fechaActual)
                ->select('team_leader')
                ->distinct()
                ->pluck('team_leader')
                ->all();

            $gerentesProduccion = array_unique(array_merge($gerentesProduccionAQL, $gerentesProduccionProceso));

            
            $data = [];
            $dataGerentesTotales = collect();
            //dd($gerentesProduccionAQL, $gerentesProduccionProceso, $gerentesProduccion);
            foreach ($gerentesProduccion as $gerente) {
                $modulosUnicosAQL = AuditoriaAQL::where('team_leader', $gerente)
                    ->whereDate('created_at', $fechaActual)
                    ->select('modulo')
                    ->distinct()
                    ->get()
                    ->pluck('modulo');
            
                $modulosUnicosProceso = AseguramientoCalidad::where('team_leader', $gerente)
                    ->whereDate('created_at', $fechaActual)
                    ->select('modulo')
                    ->distinct()
                    ->get()
                    ->pluck('modulo');
            
                $modulosUnicos = count(array_unique(array_merge($modulosUnicosAQL->toArray(), $modulosUnicosProceso->toArray())));
            
                $sumaAuditadaAQL = AuditoriaAQL::where('team_leader', $gerente)
                    ->whereDate('created_at', $fechaActual)
                    ->sum('cantidad_auditada');
            
                $sumaRechazadaAQL = AuditoriaAQL::where('team_leader', $gerente)
                    ->whereDate('created_at', $fechaActual)
                    ->sum('cantidad_rechazada');
            
                $sumaAuditadaProceso = AseguramientoCalidad::where('team_leader', $gerente)
                    ->whereDate('created_at', $fechaActual)
                    ->sum('cantidad_auditada');
            
                $sumaRechazadaProceso = AseguramientoCalidad::where('team_leader', $gerente)
                    ->whereDate('created_at', $fechaActual)
                    ->sum('cantidad_rechazada');
            
                $porcentajeErrorAQL = ($sumaAuditadaAQL != 0) ? ($sumaRechazadaAQL / $sumaAuditadaAQL) * 100 : 0;
                $porcentajeErrorProceso = ($sumaAuditadaProceso != 0) ? ($sumaRechazadaProceso / $sumaAuditadaProceso) * 100 : 0;

                $conteoOperario = AseguramientoCalidad::where('team_leader', $gerente)
                    ->where('utility', null)
                    ->whereDate('created_at', $fechaActual)
                    ->distinct('nombre')
                    ->count('nombre');
                $conteoUtility = AseguramientoCalidad::where('team_leader', $gerente)
                    ->where('utility', 1)
                    ->whereDate('created_at', $fechaActual)
                    ->distinct('nombre')
                    ->count('nombre');
                $conteoMinutos = AseguramientoCalidad::where('team_leader', $gerente)
                    ->whereDate('created_at', $fechaActual)
                    ->count('minutos_paro');

                $sumaMinutos = AseguramientoCalidad::where('team_leader', $gerente)
                    ->whereDate('created_at', $fechaActual)
                    ->sum('minutos_paro');

                $promedioMinutos = $conteoMinutos != 0 ? $sumaMinutos / $conteoMinutos : 0;
                $promedioMinutosEntero = ceil($promedioMinutos);
                $data[] = [
                    'team_leader' => $gerente,
                    'modulos_unicos' => $modulosUnicos,
                    'porcentaje_error_aql' => $porcentajeErrorAQL,
                    'porcentaje_error_proceso' => $porcentajeErrorProceso,
                    'conteoOperario' => $conteoOperario,
                    'conteoUtility' => $conteoUtility,
                    'conteoMinutos' => $conteoMinutos,
                    'sumaMinutos' => $sumaMinutos,
                    'promedioMinutosEntero' => $promedioMinutosEntero,
                ];

                $dataGerentesTotales = collect($data);
            }
            

            // Obtener clientesPlanta1 y porcentajes de error por cliente
            //apartado para mostrar datos de clientes de prodduccion, en este caso por dia AseguramientoCalidad y AuditoriaAQL
            $clientesAQLPlanta1 = AuditoriaAQL::whereNotNull('cliente')
                ->whereDate('created_at', $fechaActual)
                ->where('planta', 'Intimark1')
                ->pluck('cliente');

            $clientesProcesoPlanta1 = AseguramientoCalidad::whereNotNull('cliente')
                ->whereDate('created_at', $fechaActual)
                ->where('planta', 'Intimark1')
                ->pluck('cliente');

            $clientesPlanta1 = $clientesAQLPlanta1->merge($clientesProcesoPlanta1)->unique();

            
            $dataClientePlanta1 = [];
            $totalPorcentajeErrorAQL = 0;
            $totalPorcentajeErrorProceso =0;
            //dd($clientesAQLPlanta1, $clientesProcesoPlanta1, $clientesPlanta1);
            foreach ($clientesPlanta1 as $cliente) {
                $sumaAuditadaAQL = AuditoriaAQL::where('cliente', $cliente)
                    ->whereDate('created_at', $fechaActual)
                    ->where('planta', 'Intimark1')
                    ->sum('cantidad_auditada');
                $sumaRechazadaAQL = AuditoriaAQL::where('cliente', $cliente)
                    ->whereDate('created_at', $fechaActual)
                    ->where('planta', 'Intimark1')
                    ->sum('cantidad_rechazada');
            
                $porcentajeErrorAQL = ($sumaAuditadaAQL != 0) ? ($sumaRechazadaAQL / $sumaAuditadaAQL) * 100 : 0;
            
                $sumaAuditadaProceso = AseguramientoCalidad::where('cliente', $cliente)
                    ->whereDate('created_at', $fechaActual)
                    ->where('planta', 'Intimark1')
                    ->sum('cantidad_auditada');
                $sumaRechazadaProceso = AseguramientoCalidad::where('cliente', $cliente)
                    ->whereDate('created_at', $fechaActual)
                    ->where('planta', 'Intimark1')
                    ->sum('cantidad_rechazada');
            
                $porcentajeErrorProceso = ($sumaAuditadaProceso != 0) ? ($sumaRechazadaProceso / $sumaAuditadaProceso) * 100 : 0;


                $totalAuditadaAQL = $clientesAQLPlanta1->sum(function ($cliente) use ($fechaActual) {
                    return AuditoriaAQL::where('cliente', $cliente)
                        ->whereDate('created_at', $fechaActual)
                        ->where('planta', 'Intimark1')
                        ->sum('cantidad_auditada');
                });
                
                $totalRechazadaAQL = $clientesAQLPlanta1->sum(function ($cliente) use ($fechaActual) {
                    return AuditoriaAQL::where('cliente', $cliente)
                        ->whereDate('created_at', $fechaActual)
                        ->where('planta', 'Intimark1')
                        ->sum('cantidad_rechazada');
                });
                
                $totalAuditadaProceso = $clientesProcesoPlanta1->sum(function ($cliente) use ($fechaActual) {
                    return AseguramientoCalidad::where('cliente', $cliente)
                        ->whereDate('created_at', $fechaActual)
                        ->where('planta', 'Intimark1')
                        ->sum('cantidad_auditada');
                });
                
                $totalRechazadaProceso = $clientesProcesoPlanta1->sum(function ($cliente) use ($fechaActual) {
                    return AseguramientoCalidad::where('cliente', $cliente)
                        ->whereDate('created_at', $fechaActual)
                        ->where('planta', 'Intimark1')
                        ->sum('cantidad_rechazada');
                });
                
                $totalPorcentajeErrorAQL = ($totalAuditadaAQL != 0) ? ($totalRechazadaAQL / $totalAuditadaAQL) * 100 : 0;
                $totalPorcentajeErrorProceso = ($totalAuditadaProceso != 0) ? ($totalRechazadaProceso / $totalAuditadaProceso) * 100 : 0;
                

                $dataClientePlanta1[] = [
                    'cliente' => $cliente,
                    'porcentajeErrorProceso' => $porcentajeErrorProceso,
                    'porcentajeErrorAQL' => $porcentajeErrorAQL,
                ];

            }

            //dd($gerentesProduccionAQL, $gerentesProduccionProceso, $gerentesProduccion, $data);
            return view('dashboard', compact('title', 'concentradoTotalAprobado', 'concentradoTotalRechazado', 'concentradoTotalPorcentaje',
                                    'conteoBultosDia', 'conteoPiezaConRechazoDia', 'conteoPiezaAceptadoDia',
                                    'conteoBultosDiaPlanta1', 'conteoPiezaConRechazoDiaPlanta1', 'conteoPiezaAceptadoDiaPlanta1',
                                    'conteoBultosDiaPlanta2', 'conteoPiezaConRechazoDiaPlanta2', 'conteoPiezaAceptadoDiaPlanta2',
                                    'porcentajeTotalCorte', 'corteAprobados', 'corteRechazados', 
                                    'totalPorcentajeProceso', 'procesoAprobados', 'procesoRechazados',
                                    'totalPorcentajePlayera', 'playeraAprobados', 'playeraRechazados',
                                    'totalPorcentajeAQL', 'aQLAprobados', 'aQLRechazados', 
                                    'porcentajesErrorGerenteProduccion', 'modulosPorGerenteProduccion',
                                    'porcentajesErrorGerenteProduccionProceso', 'modulosPorGerenteProduccionProceso',
                                    'data', 'dataGerentesTotales',
                                    'dataClientePlanta1', 'totalPorcentajeErrorAQL', 'totalPorcentajeErrorProceso'));
        } else {
            // Si el usuario no tiene esos roles, redirige a listaFormularios
            return redirect()->route('viewlistaFormularios');
        }
    }

}
