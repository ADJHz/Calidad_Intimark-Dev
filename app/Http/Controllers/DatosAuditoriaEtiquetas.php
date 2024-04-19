<?php

namespace App\Http\Controllers;

use App\Models\DatosAuditoriaEtiquetas as ModelsDatosAuditoriaEtiquetas;
use App\Models\Cat_DefEtiquetas;
use App\Models\ReporteAuditoriaEtiqueta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DatosAuditoriaEtiquetas extends Controller
{
    public function auditoriaEtiquetas()
    {
        $mesesEnEspanol = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];
        $Proveedor = ModelsDatosAuditoriaEtiquetas::select('Proveedor')
        ->distinct()
        ->get();
        return view('formulariosCalidad.auditoriaEtiquetas', compact('mesesEnEspanol'));
    }
    public function NoOrdenes()
    {

        $ordenes = ModelsDatosAuditoriaEtiquetas::select('OrdenCompra')
            ->distinct()
            ->get();

        return response()->json($ordenes);
    }
    public function buscarEstilos(Request $request)
    {
        $orden = $request->input('orden');
        // Buscar datos relacionados con la orden seleccionada
        $estilos = ModelsDatosAuditoriaEtiquetas::where('OrdenCompra', $orden)
            ->select('Estilos')
            ->distinct()
            ->get();

        return response()->json($estilos);
    }
    public function buscarDatosAuditoriaPorEstilo(Request $request)
{
    $estilo = $request->input('estilo');
    $orden = $request->input('orden');

    // Buscar datos relacionados con el estilo especificado y la orden de compra
    $datos = ModelsDatosAuditoriaEtiquetas::where('Estilos', $estilo)
        ->where('OrdenCompra', $orden)
        ->select('OrdenCompra', 'Estilos', 'Cantidad', 'Talla', 'Color')
        ->get();

    // Iterar sobre los datos y determinar el tamaño de muestra
    foreach ($datos as $dato) {
        $cantidad = $dato->Cantidad;
        $tamaño_muestra = '';

        // Determinar el rango de cantidad y asignar el tamaño de muestra correspondiente
        if ($cantidad >= 2 && $cantidad <= 8) {
            $tamaño_muestra = '2';
        } elseif ($cantidad >= 9 && $cantidad <= 15) {
            $tamaño_muestra = '3';
        } elseif ($cantidad >= 16 && $cantidad <= 25) {
            $tamaño_muestra = '5';
        } elseif ($cantidad >= 26 && $cantidad <= 50) {
            $tamaño_muestra = '8';
        } elseif ($cantidad >= 51 && $cantidad <= 90) {
            $tamaño_muestra = '13';
        } elseif ($cantidad >= 91 && $cantidad <= 150) {
            $tamaño_muestra = '20';
        } elseif ($cantidad >= 151 && $cantidad <= 280) {
            $tamaño_muestra = '32';
        } elseif ($cantidad >= 281 && $cantidad <= 500) {
            $tamaño_muestra = '50';
        } elseif ($cantidad >= 501 && $cantidad <= 1200) {
            $tamaño_muestra = '80';
        } elseif ($cantidad >= 1201 && $cantidad <= 3200) {
            $tamaño_muestra = '125';
        } elseif ($cantidad >= 3201 && $cantidad <= 10000) {
            $tamaño_muestra = '200';
        } elseif ($cantidad >= 10001 && $cantidad <= 35000) {
            $tamaño_muestra = '315';
        } elseif ($cantidad >= 35001 && $cantidad <= 150000) {
            $tamaño_muestra = '500';
        } elseif ($cantidad >= 150001 && $cantidad <= 5000000) {
            $tamaño_muestra = '800';
        } elseif ($cantidad > 5000000) {
            $tamaño_muestra = '2000';
        }

        // Asignar el tamaño de muestra al modelo
        $dato->tamaño_muestra = $tamaño_muestra;
    }

    return response()->json($datos);
}


    public function obtenerTiposDefectos()
    {
        $tiposDefectos = Cat_DefEtiquetas::all();

        return response()->json($tiposDefectos);
    }

    public function guardarInformacion(Request $request) {
        // Obtener los datos enviados desde el frontend
        $datos = $request->input('datos');

        // Registrar los datos recibidos en el log
        Log::info('Datos recibidos para guardar:', $datos);

        try {
            // Iterar sobre los datos recibidos
            foreach ($datos as $dato) {
                // Crear una nueva instancia del modelo ReporteAuditoriaEtiqueta
                $reporte = new ReporteAuditoriaEtiqueta();

                // Asignar los valores a los atributos del modelo
                $reporte->Orden = $dato['orden'] ?? 'N/A'; // Si el valor es null, asigna 'N/A'
                $reporte->Estilos = $dato['estilo'] ?? 'N/A'; // Si el valor es null, asigna 'N/A'
                $reporte->Cantidad = $dato['cantidad'] ?? 'N/A'; // Si el valor es null, asigna 'N/A'
                $reporte->Muestreo = $dato['muestreo'] ?? 'N/A'; // Si el valor es null, asigna 'N/A'
                $reporte->Defectos = $dato['defectos'] ?? 'N/A'; // Si el valor es null, asigna 'N/A'
                $reporte->Tipo_Defectos = $dato['tipoDefecto'] ?? 'N/A'; // Si el valor es null, asigna 'N/A'
                $reporte->Talla = $dato['talla'] ?? 'N/A'; // Si el valor es null, asigna 'N/A'
                $reporte->Color = $dato['color'] ?? 'N/A'; // Si el valor es null, asigna 'N/A'
                $reporte->Status = 'Guardado';

                // Guardar el registro en la base de datos
                $reporte->save();
            }

            // Retornar una respuesta JSON indicando el éxito del guardado
            return response()->json(['mensaje' => 'Los datos han sido guardados correctamente'], 200);
        } catch (\Exception $e) {
            // Registrar el error en el log
            Log::error('Error al guardar los datos: ' . $e->getMessage());

            // Retornar una respuesta JSON con el mensaje de error
            return response()->json(['error' => 'Error al guardar los datos: ' . $e->getMessage()], 500);
        }
    }









}
