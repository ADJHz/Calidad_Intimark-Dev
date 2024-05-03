<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\EncabezadoAuditoriaCorte;
use App\Models\Lectra; 
use App\Models\AuditoriaProcesoCorte; 
use App\Models\AseguramientoCalidad;   
use App\Models\AuditoriaAQL;   
use Illuminate\Http\Request;
use Carbon\Carbon;


class DashboardController extends Controller
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
    public function dashboarAProceso()
    {
        $title = "";

        $clientes = AuditoriaProcesoCorte::whereNotNull('cliente')
            ->orderBy('cliente')
            ->pluck('cliente')
            ->unique();
        $porcentajesError = [];

        foreach ($clientes as $cliente) {
            $sumaAuditada = AuditoriaProcesoCorte::where('cliente', $cliente)->sum('cantidad_auditada');
            $sumaRechazada = AuditoriaProcesoCorte::where('cliente', $cliente)->sum('cantidad_rechazada');

            if ($sumaAuditada != 0) {
                $porcentajeError = ($sumaRechazada / $sumaAuditada) * 100;
            } else {
                $porcentajeError = 0;
            }

            $porcentajesError[$cliente] = $porcentajeError;
        }
        
        return view('dashboar.dashboarAProceso', compact('title', 'clientes', 'porcentajesError'));
    }

    public function dashboarAProcesoPlayera()
    {
        $title = "";

        $clientes = AseguramientoCalidad::whereNotNull('cliente')
            ->orderBy('cliente')
            ->pluck('cliente')
            ->unique();
        $porcentajesError = [];

        foreach ($clientes as $cliente) {
            $sumaAuditada = AseguramientoCalidad::where('cliente', $cliente)->sum('cantidad_auditada');
            $sumaRechazada = AseguramientoCalidad::where('cliente', $cliente)->sum('cantidad_rechazada');

            if ($sumaAuditada != 0) {
                $porcentajeError = ($sumaRechazada / $sumaAuditada) * 100;
            } else {
                $porcentajeError = 0;
            }

            $porcentajesError[$cliente] = $porcentajeError;
        }
        // Ordenar los cleintes por el porcentaje de error de mayor a menor
        arsort($porcentajesError);


        // apartado para operarios de maquina
        $nombres = AseguramientoCalidad::whereNotNull('nombre')
            ->orderBy('nombre')
            ->pluck('nombre')
            ->unique();
        $porcentajesErrorNombre = [];

        foreach ($nombres as $nombre) {
            $sumaAuditadaNombre = AseguramientoCalidad::where('nombre', $nombre)->sum('cantidad_auditada');
            $sumaRechazadaNombre = AseguramientoCalidad::where('nombre', $nombre)->sum('cantidad_rechazada');

            if ($sumaAuditadaNombre != 0) {
                $porcentajeErrorNombre = ($sumaRechazadaNombre / $sumaAuditadaNombre) * 100;
            } else {
                $porcentajeErrorNombre = 0;
            }

            $porcentajesErrorNombre[$nombre] = $porcentajeErrorNombre;

            // Obtener la operación correspondiente al operario de máquina
            $operacion = AseguramientoCalidad::where('nombre', $nombre)->value('operacion');
            $operacionesPorNombre[$nombre] = $operacion;
            // Obtener la operación correspondiente al team leader vinculado al operario de máquina
            $teamleader = AseguramientoCalidad::where('nombre', $nombre)->value('team_leader');
            $teamLeaderPorNombre[$nombre] = $teamleader;
            // Obtener la modulo correspondiente al operario de máquina
            $modulo = AseguramientoCalidad::where('nombre', $nombre)->value('modulo');
            $moduloPorNombre[$nombre] = $modulo;
            
        }
        // Ordenar los operarios de maquina por el porcentaje de error de mayor a menor
        arsort($porcentajesErrorNombre);

        //apartado para team leader
        $teamLeaders = AseguramientoCalidad::whereNotNull('team_leader')
            ->orderBy('team_leader')
            ->pluck('team_leader')
            ->unique();
        $porcentajesErrorTeamLeader = [];

        foreach ($teamLeaders as $teamLeader) {
            $sumaAuditadaTeamLeader = AseguramientoCalidad::where('team_leader', $teamLeader)->sum('cantidad_auditada');
            $sumaRechazadaTeamLeader = AseguramientoCalidad::where('team_leader', $teamLeader)->sum('cantidad_rechazada');

            if ($sumaAuditadaTeamLeader != 0) {
                $porcentajeErrorTeamLeader = ($sumaRechazadaTeamLeader / $sumaAuditadaTeamLeader) * 100;
            } else {
                $porcentajeErrorTeamLeader = 0;
            }

            $porcentajesErrorTeamLeader[$teamLeader] = $porcentajeErrorTeamLeader;
        }
        // Ordenar los team leaders por el porcentaje de error de mayor a menor
        arsort($porcentajesErrorTeamLeader);
        
        return view('dashboar.dashboarAProcesoPlayera', compact('title', 'clientes', 'porcentajesError', 
                'nombres', 'porcentajesErrorNombre', 'operacionesPorNombre', 'teamLeaderPorNombre', 'moduloPorNombre',
                'teamLeaders', 'porcentajesErrorTeamLeader'));
    }

    public function dashboarAProcesoAQL(Request $request)
    {
        $title = "";

        $fechaInicio = $request->input('fecha_inicio' . ' 00:00:00', Carbon::now()->format('Y-m-d') . ' 00:00:00');
        $fechaFin = $request->input('fecha_fin' . ' 23:59:59', Carbon::now()->format('Y-m-d') . ' 23:59:59');

        // Obtener clientes y porcentajes de error por cliente
        $clientes = AuditoriaAQL::whereNotNull('cliente')
            ->whereBetween('created_at', [$fechaInicio, $fechaFin])
            ->orderBy('cliente')
            ->pluck('cliente')
            ->unique();
        $porcentajesError = [];

        foreach ($clientes as $cliente) {
            $sumaAuditada = AuditoriaAQL::where('cliente', $cliente)
                ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                ->sum('cantidad_auditada');
            $sumaRechazada = AuditoriaAQL::where('cliente', $cliente)
                ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                ->sum('cantidad_rechazada');

            $porcentajeError = ($sumaAuditada != 0) ? ($sumaRechazada / $sumaAuditada) * 100 : 0;

            $porcentajesError[$cliente] = $porcentajeError;
        }
        arsort($porcentajesError);

        // Obtener operarios de máquina, porcentajes de error por operario y otras relaciones por operario
        $nombres = AuditoriaAQL::whereNotNull('modulo')
            ->whereBetween('created_at', [$fechaInicio, $fechaFin])
            ->orderBy('modulo')
            ->pluck('modulo')
            ->unique();
        $porcentajesErrorNombre = [];
        $operacionesPorNombre = [];
        $teamLeaderPorNombre = [];
        $moduloPorNombre = [];

        foreach ($nombres as $nombre) {
            $sumaAuditadaNombre = AuditoriaAQL::where('modulo', $nombre)
                ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                ->sum('cantidad_auditada');
            $sumaRechazadaNombre = AuditoriaAQL::where('modulo', $nombre)
                ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                ->sum('cantidad_rechazada');

            $porcentajeErrorNombre = ($sumaAuditadaNombre != 0) ? ($sumaRechazadaNombre / $sumaAuditadaNombre) * 100 : 0;

            $porcentajesErrorNombre[$nombre] = $porcentajeErrorNombre;

            // Obtener la operación, el team leader y el módulo correspondientes al operario de máquina
            $operacion = AuditoriaAQL::where('modulo', $nombre)
                ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                ->value('op');
            $operacionesPorNombre[$nombre] = $operacion;

            $teamleader = AuditoriaAQL::where('modulo', $nombre)
                ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                ->value('team_leader');
            $teamLeaderPorNombre[$nombre] = $teamleader;

            $moduloPorNombre[$nombre] = $nombre;
        }
        arsort($porcentajesErrorNombre);

        // Obtener team leaders y porcentajes de error por team leader
        $teamLeaders = AuditoriaAQL::whereNotNull('team_leader')
            ->whereNull('jefe_produccion')
            ->whereBetween('created_at', [$fechaInicio, $fechaFin])
            ->orderBy('team_leader')
            ->pluck('team_leader')
            ->unique();
        $porcentajesErrorTeamLeader = [];

        foreach ($teamLeaders as $teamLeader) {
            $sumaAuditadaTeamLeader = AuditoriaAQL::where('team_leader', $teamLeader)
                ->whereNull('jefe_produccion')
                ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                ->sum('cantidad_auditada');
            $sumaRechazadaTeamLeader = AuditoriaAQL::where('team_leader', $teamLeader)
                ->whereNull('jefe_produccion')
                ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                ->sum('cantidad_rechazada');

            $porcentajeErrorTeamLeader = ($sumaAuditadaTeamLeader != 0) ? ($sumaRechazadaTeamLeader / $sumaAuditadaTeamLeader) * 100 : 0;

            $porcentajesErrorTeamLeader[$teamLeader] = $porcentajeErrorTeamLeader;
        }
        arsort($porcentajesErrorTeamLeader);

        //para jefes de produccion
        // Obtener team leaders y porcentajes de error por team leader
        $jefesProduccion = AuditoriaAQL::whereNotNull('team_leader')
            ->where('jefe_produccion', 1)
            ->whereBetween('created_at', [$fechaInicio, $fechaFin])
            ->orderBy('team_leader')
            ->pluck('team_leader')
            ->unique();
        $porcentajesErrorJefeProduccion = [];

        foreach ($jefesProduccion as $jefeProduccion) {
            $sumaAuditadaJefeProduccion = AuditoriaAQL::where('team_leader', $jefeProduccion)
                ->where('jefe_produccion', 1)
                ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                ->sum('cantidad_auditada');
            $sumaRechazadaJefeProduccion = AuditoriaAQL::where('team_leader', $jefeProduccion)
                ->where('jefe_produccion', 1)
                ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                ->sum('cantidad_rechazada');

            $porcentajeErrorJefeProduccion = ($sumaAuditadaJefeProduccion != 0) ? ($sumaRechazadaJefeProduccion / $sumaAuditadaJefeProduccion) * 100 : 0;

            $porcentajesErrorJefeProduccion[$jefeProduccion] = $porcentajeErrorJefeProduccion;
        }
        arsort($porcentajesErrorJefeProduccion);

        return view('dashboar.dashboarAProcesoAQL', compact('title', 'clientes', 'porcentajesError',
            'nombres', 'porcentajesErrorNombre', 'operacionesPorNombre', 'teamLeaderPorNombre', 'moduloPorNombre',
            'teamLeaders', 'porcentajesErrorTeamLeader',
            'jefesProduccion', 'porcentajesErrorJefeProduccion'));
    }


}
