<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TimeZoneMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        date_default_timezone_set('America/Mexico_City');

        $fecha = (localtime(time(), true));

        if ($fecha["tm_isdst"] == 1) {
            $hora_aux = $fecha["tm_hour"] - 1;
            $dia_aux = $fecha["tm_year"] . '-' . $fecha["tm_mon"] . '-' . $fecha["tm_mday"];
            $hora_aux = $hora_aux . ':' . $fecha["tm_min"] . ':' . $fecha["tm_sec"];
        } else {
            $dia_aux = $fecha["tm_year"] . '-' . $fecha["tm_mon"] . '-' . $fecha["tm_mday"];
            $hora_aux = $fecha["tm_hour"] . ':' . $fecha["tm_min"] . ':' . $fecha["tm_sec"];
        }
        // Establecer la fecha y hora actual en el objeto Carbon global
        Carbon::setTestNow(Carbon::createFromFormat('H:i:s', $hora_aux));

        return $next($request);
    }
}
