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


            //apartado para mostrar daots de gerente de prodduccion, en este caso por dia
            $gerentesProduccionAQL = AuditoriaAQL::where('jefe_produccion', 1)
                ->whereDate('created_at', $fechaActual)
                ->select('team_leader')
                ->distinct()
                ->get();

            $gerentesProduccionAseguramiento = AseguramientoCalidad::where('jefe_produccion', 1)
                ->whereDate('created_at', $fechaActual)
                ->select('team_leader')
                ->distinct()
                ->get();

            $gerentesProduccion = $gerentesProduccionAQL->merge($gerentesProduccionAseguramiento)->unique();

            $porcentajesErrorGerenteProduccion = [];
            $modulosPorGerenteProduccion = [];

            foreach ($gerentesProduccion as $teamLeader) {
                $teamLeaderName = $teamLeader->team_leader;

                $modulosUnicosAuditoria = AuditoriaAQL::where('team_leader', $teamLeaderName)
                    ->where('jefe_produccion', 1)
                    ->whereDate('created_at', $fechaActual)
                    ->select('modulo')
                    ->distinct()
                    ->count();

                $modulosUnicosAseguramiento = AseguramientoCalidad::where('team_leader', $teamLeaderName)
                    ->where('jefe_produccion', 1)
                    ->whereDate('created_at', $fechaActual)
                    ->select('modulo')
                    ->distinct()
                    ->count();

                // Calcula la suma total de módulos únicos
                $totalModulosUnicos = $modulosUnicosAuditoria + $modulosUnicosAseguramiento;

                // Guarda la suma total en el array de módulos por gerente
                $modulosPorGerenteProduccion[$teamLeaderName] = $totalModulosUnicos;

                $sumaAuditadaGerenteProduccion = AuditoriaAQL::where('team_leader', $teamLeader)
                    ->whereDate('created_at', $fechaActual)
                    ->sum('cantidad_auditada');

                $sumaRechazadaGerenteProduccion = AuditoriaAQL::where('team_leader', $teamLeader)
                    ->whereDate('created_at', $fechaActual)
                    ->sum('cantidad_rechazada');

                // Calcula el porcentaje de error considerando la suma total de módulos únicos
                $porcentajeErrorGerenteProduccion = ($totalModulosUnicos != 0 && $sumaAuditadaGerenteProduccion != 0) ? ($sumaRechazadaGerenteProduccion / $sumaAuditadaGerenteProduccion) * 100 : 0;

                // Guarda el porcentaje de error
                $porcentajesErrorGerenteProduccion[$teamLeaderName] = $porcentajeErrorGerenteProduccion;
            }

            arsort($porcentajesErrorGerenteProduccion);

            return view('dashboard', compact('title', 'concentradoTotalAprobado', 'concentradoTotalRechazado', 'concentradoTotalPorcentaje',
                                    'conteoBultosDia', 'conteoPiezaConRechazoDia', 'conteoPiezaAceptadoDia',
                                    'conteoBultosDiaPlanta1', 'conteoPiezaConRechazoDiaPlanta1', 'conteoPiezaAceptadoDiaPlanta1',
                                    'conteoBultosDiaPlanta2', 'conteoPiezaConRechazoDiaPlanta2', 'conteoPiezaAceptadoDiaPlanta2',
                                    'porcentajeTotalCorte', 'corteAprobados', 'corteRechazados', 
                                    'totalPorcentajeProceso', 'procesoAprobados', 'procesoRechazados',
                                    'totalPorcentajePlayera', 'playeraAprobados', 'playeraRechazados',
                                    'totalPorcentajeAQL', 'aQLAprobados', 'aQLRechazados', 
                                    'porcentajesErrorGerenteProduccion', 'modulosPorGerenteProduccion'));
        } else {
            // Si el usuario no tiene esos roles, redirige a listaFormularios
            return redirect()->route('viewlistaFormularios');
        }
    }

}
