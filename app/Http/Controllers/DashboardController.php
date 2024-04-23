<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\EncabezadoAuditoriaCorte;
use App\Models\Lectra; 
use App\Models\AuditoriaProcesoCorte; 
use App\Models\AseguramientoCalidad;  
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

}
