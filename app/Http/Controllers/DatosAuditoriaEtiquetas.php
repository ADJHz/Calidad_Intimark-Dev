<?php

namespace App\Http\Controllers;

use App\Models\DatosAuditoriaEtiquetas as ModelsDatosAuditoriaEtiquetas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DatosAuditoriaEtiquetas extends Controller
{
    public function auditoriaEtiquetas()
    {
        $mesesEnEspanol = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];

        return view('formulariosCalidad.auditoriaEtiquetas', compact('mesesEnEspanol'));
    }
    public function NoOrdenes()
    {

        $ordenes = ModelsDatosAuditoriaEtiquetas::select('OrdenCompra')
            ->distinct()
            ->get();

        return response()->json($ordenes);
    }
    public function ClientesProv($ordenes)
    {
        $clientes = ModelsDatosAuditoriaEtiquetas::select('Proveedor')
            ->where('OrdenCompra', $ordenes)
            ->distinct()
            ->get();

        return response()->json($clientes);
    }

    public function Estilositem($ordenes)
    {
        $estilos = ModelsDatosAuditoriaEtiquetas::select('Estilos')
            ->where('OrdenCompra', $ordenes)
            ->distinct()
            ->get();

        return response()->json($estilos);
    }
    public function Colores($ordenes)
{
    Log::info("Estilo seleccionado: " . $ordenes);

    $colores = ModelsDatosAuditoriaEtiquetas::select('Color')
        ->where('OrdenCompra', $ordenes)
        ->distinct()
        ->get();

    // Verificar si la consulta devuelve datos vacíos
    if ($colores->isEmpty()) {
        // Si es así, devuelve la respuesta como JSON con 'N/A'
        return response()->json(['Color' => 'N/A']);
    }

    Log::info($colores);

    // Si la consulta tiene datos, devuélvelos normalmente
    return response()->json($colores);
}

    public function Tecnicos()
    {
        $tecnicos = ModelsDatosAuditoriaEtiquetas::all();
        return response()->json($tecnicos);
    }
    public function TipoTecnica()
    {
        $tipo_tecnica = ModelsDatosAuditoriaEtiquetas::all();

        return response()->json($tipo_tecnica);
    }
    public function TipoFibra()
    {
        $tipo_fibra = ModelsDatosAuditoriaEtiquetas::all();

        return response()->json($tipo_fibra);
    }

}
