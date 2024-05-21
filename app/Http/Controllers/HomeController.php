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

            //una funcion dentro de una funcion?
            function calcularPorcentaje($modelo, $fecha, $planta = null) {
                $query = $modelo::whereDate('created_at', $fecha);
            
                if ($planta) {
                    $query->where('planta', $planta);
                }
            
                $data = $query->selectRaw('SUM(cantidad_auditada) as cantidad_auditada, SUM(cantidad_rechazada) as cantidad_rechazada')
                              ->first();
            
                return $data->cantidad_auditada != 0 ? number_format(($data->cantidad_rechazada / $data->cantidad_auditada) * 100, 2) : 0;
            }
            
            // Información General
            $generalProceso = calcularPorcentaje(AseguramientoCalidad::class, $fechaActual);
            $generalAQL = calcularPorcentaje(AuditoriaAQL::class, $fechaActual);
            
            // Planta 1 Ixtlahuaca
            $generalProcesoPlanta1 = calcularPorcentaje(AseguramientoCalidad::class, $fechaActual, 'Intimark1');
            $generalAQLPlanta1 = calcularPorcentaje(AuditoriaAQL::class, $fechaActual, 'Intimark1');
            
            // Planta 2 San Bartolo
            $generalProcesoPlanta2 = calcularPorcentaje(AseguramientoCalidad::class, $fechaActual, 'Intimark2');
            $generalAQLPlanta2 = calcularPorcentaje(AuditoriaAQL::class, $fechaActual, 'Intimark2');

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

            $dataAQL = [];
            foreach ($gerentesProduccionAQL as $gerente) {
                $modulosUnicosAQL = AuditoriaAQL::where('team_leader', $gerente)
                    ->whereDate('created_at', $fechaActual)
                    ->select('modulo')
                    ->distinct()
                    ->get()
                    ->pluck('modulo');
        
                $modulosUnicos = $modulosUnicosAQL->count();
        
                $sumaAuditadaAQL = AuditoriaAQL::where('team_leader', $gerente)
                    ->whereDate('created_at', $fechaActual)
                    ->sum('cantidad_auditada');
        
                $sumaRechazadaAQL = AuditoriaAQL::where('team_leader', $gerente)
                    ->whereDate('created_at', $fechaActual)
                    ->sum('cantidad_rechazada');
        
                $porcentajeErrorAQL = ($sumaAuditadaAQL != 0) ? ($sumaRechazadaAQL / $sumaAuditadaAQL) * 100 : 0;

                $conteoOperario = AuditoriaAQL::where('team_leader', $gerente)
                    ->whereDate('created_at', $fechaActual)
                    ->distinct('nombre')
                    ->count('nombre');

                $conteoMinutos = AuditoriaAQL::where('team_leader', $gerente)
                    ->whereDate('created_at', $fechaActual)
                    ->count('minutos_paro');
        
                $conteParoModular = AuditoriaAQL::where('team_leader', $gerente)
                    ->whereDate('created_at', $fechaActual)
                    ->count('minutos_paro_modular');

                $sumaMinutos = AuditoriaAQL::where('team_leader', $gerente)
                    ->whereDate('created_at', $fechaActual)
                    ->sum('minutos_paro');
        
                $promedioMinutos = $conteoMinutos != 0 ? $sumaMinutos / $conteoMinutos : 0;
                $promedioMinutosEntero = ceil($promedioMinutos);
        
                $dataAQL[] = [
                    'team_leader' => $gerente,
                    'modulos_unicos' => $modulosUnicos,
                    'porcentaje_error_aql' => $porcentajeErrorAQL,
                    'conteoOperario' => $conteoOperario,
                    'conteoMinutos' => $conteoMinutos,
                    'sumaMinutos' => $sumaMinutos,
                    'promedioMinutosEntero' => $promedioMinutosEntero,
                    'conteParoModular' => $conteParoModular,
                ];
            }

            $gerentesProduccionProceso = AseguramientoCalidad::where('jefe_produccion', 1)
                ->whereDate('created_at', $fechaActual)
                ->select('team_leader')
                ->distinct()
                ->pluck('team_leader')
                ->all();

            $dataProceso = [];
            foreach ($gerentesProduccionProceso as $gerente) {
                $modulosUnicosProceso = AseguramientoCalidad::where('team_leader', $gerente)
                    ->whereDate('created_at', $fechaActual)
                    ->select('modulo')
                    ->distinct()
                    ->get()
                    ->pluck('modulo');
        
                $modulosUnicos = $modulosUnicosProceso->count();
        
                $sumaAuditadaProceso = AseguramientoCalidad::where('team_leader', $gerente)
                    ->whereDate('created_at', $fechaActual)
                    ->sum('cantidad_auditada');
        
                $sumaRechazadaProceso = AseguramientoCalidad::where('team_leader', $gerente)
                    ->whereDate('created_at', $fechaActual)
                    ->sum('cantidad_rechazada');
        
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
        
                $dataProceso[] = [
                    'team_leader' => $gerente,
                    'modulos_unicos' => $modulosUnicos,
                    'porcentaje_error_proceso' => $porcentajeErrorProceso,
                    'conteoOperario' => $conteoOperario,
                    'conteoUtility' => $conteoUtility,
                    'conteoMinutos' => $conteoMinutos,
                    'sumaMinutos' => $sumaMinutos,
                    'promedioMinutosEntero' => $promedioMinutosEntero,
                ];
            }


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
            return view('dashboard', compact('title', 'porcentajesErrorGerenteProduccion', 'modulosPorGerenteProduccion',
                                    'porcentajesErrorGerenteProduccionProceso', 'modulosPorGerenteProduccionProceso',
                                    'data', 'dataGerentesTotales',
                                    'dataClientePlanta1', 'totalPorcentajeErrorAQL', 'totalPorcentajeErrorProceso',
                                    'dataAQL', 'dataProceso',
                                    'generalProceso', 'generalAQL', 'generalAQLPlanta1', 'generalAQLPlanta2','generalProcesoPlanta1', 'generalProcesoPlanta2'));
        } else {
            // Si el usuario no tiene esos roles, redirige a listaFormularios
            return redirect()->route('viewlistaFormularios');
        }
    }

}
