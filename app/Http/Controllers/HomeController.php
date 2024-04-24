<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\EncabezadoAuditoriaCorte;
use App\Models\Lectra; 
use App\Models\AuditoriaProcesoCorte; 
use App\Models\AseguramientoCalidad;  
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

            $concentradoTotalSuma = $sumaPorcentaje + $cantidadAuditada + $cantidadAuditadaPlayera;
            $concentradoTotalRechazo = $totalRegistros + $cantidadRechazada + $cantidadRechazadaPlayera;
            $concentradoTotalPorcentaje = $concentradoTotalSuma != 0 ? number_format(($concentradoTotalRechazo / $concentradoTotalSuma) * 100, 2) : 0;

            $concentradoTotalAprobado = $corteAprobados + $procesoAprobados + $playeraAprobados;
            $concentradoTotalRechazado = $corteRechazados + $procesoRechazados + $playeraRechazados;

            return view('dashboard', compact('title', 'concentradoTotalAprobado', 'concentradoTotalRechazado', 'concentradoTotalPorcentaje',
                                    'porcentajeTotalCorte', 'corteAprobados', 'corteRechazados', 
                                    'totalPorcentajeProceso', 'procesoAprobados', 'procesoRechazados',
                                    'totalPorcentajePlayera', 'playeraAprobados', 'playeraRechazados' ));
        } else {
            // Si el usuario no tiene esos roles, redirige a listaFormularios
            return redirect()->route('viewlistaFormularios');
        }
    }

}
