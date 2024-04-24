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
        ->select('id','OrdenCompra', 'Estilos', 'Cantidad', 'Talla', 'Color')
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

public function guardarInformacion(Request $request)
{
    // Obtener los datos enviados desde el frontend
    $datos = $request->input('datos');

    $contador = count($datos);

    try {
        // Iterar sobre los datos recibidos
        for ($i = 0; $i < $contador; $i++) {
            // Buscar si existe un registro con el mismo ID en ReporteAuditoriaEtiqueta
            $registroExistente = ReporteAuditoriaEtiqueta::find($datos[$i]['id']);
            if ($registroExistente) {
                // Si existe un registro en ReporteAuditoriaEtiqueta, actualizar sus atributos
                $registroExistente->Status = 'Update';
                $registroExistente->Defectos = $datos[$i]['defectos'] ?? 'N/A';
                $registroExistente->Tipo_Defectos = $datos[$i]['tipoDefecto'] ?? 'N/A';
                $registroExistente->save();
            } else {
                // Si no existe, crear un nuevo registro en ReporteAuditoriaEtiqueta
                $reporte = new ReporteAuditoriaEtiqueta();
                $reporte->id = $datos[$i]['id'] ?? 'N/A';
                $reporte->Orden = $datos[$i]['orden'] ?? 'N/A';
                $reporte->Estilos = $datos[$i]['estilo'] ?? 'N/A';
                $reporte->Cantidad = $datos[$i]['cantidad'] ?? 'N/A';
                $reporte->Muestreo = $datos[$i]['muestreo'] ?? 'N/A';
                $reporte->Defectos = $datos[$i]['defectos'] ?? 'N/A';
                $reporte->Tipo_Defectos = $datos[$i]['tipoDefecto'] ?? 'N/A';
                $reporte->Talla = $datos[$i]['talla'] ?? 'N/A';
                $reporte->Color = $datos[$i]['color'] ?? 'N/A';
                $reporte->Status = 'Guardado';
                $reporte->save();
            }

            // Buscar si existe un registro con el mismo ID en ModelsDatosAuditoriaEtiquetas
            $registroExistenteModel = ModelsDatosAuditoriaEtiquetas::find($datos[$i]['id']);
            if ($registroExistenteModel) {
                // Si existe un registro en ModelsDatosAuditoriaEtiquetas, actualizar solo su atributo 'status'
                $registroExistenteModel->status = 'Iniciado';
                $registroExistenteModel->save();
            }
        }

        // Retornar una respuesta JSON indicando el éxito
        return response()->json(['mensaje' => 'Los datos han sido actualizados correctamente'], 200);
    } catch (\Exception $e) {
        // Retornar una respuesta JSON con el mensaje de error
        return response()->json(['error' => 'Error al actualizar los datos: ' . $e->getMessage()], 500);
    }
}


public function actualizarStatus(Request $request)
{
    try {
        // Obtener los datos enviados desde el frontend
        $datos = $request->input('datos');
        // Obtener el status del dropdown
        $status = $request->input('status');
        // Obtener el ID de la fila seleccionada
        $rowId = $request->input('rowId');

        // Buscar si existe un registro con el ID de la fila seleccionada en ReporteAuditoriaEtiqueta
        $registroExistente = ReporteAuditoriaEtiqueta::find($rowId);
        if ($registroExistente) {
            // Actualizar el status, Defectos y Tipo_Defectos del registro existente en ReporteAuditoriaEtiqueta
            $registroExistente->update([
                'Status' => $status,
                'Defectos' => $datos[0]['defectos'] ?? 'N/A',
                'Tipo_Defectos' => $datos[0]['tipoDefecto'] ?? 'N/A'
            ]);
        } else {
            // Crear un nuevo registro si no existe en ReporteAuditoriaEtiqueta
            $registroExistente = new ReporteAuditoriaEtiqueta();
            $registroExistente->id = $rowId;
            $registroExistente->Orden = $datos[0]['orden'] ?? 'N/A';
            $registroExistente->Estilos = $datos[0]['estilo'] ?? 'N/A';
            $registroExistente->Cantidad = $datos[0]['cantidad'] ?? 'N/A';
            $registroExistente->Muestreo = $datos[0]['muestreo'] ?? 'N/A';
            $registroExistente->Defectos = $datos[0]['defectos'] ?? 'N/A';
            $registroExistente->Tipo_Defectos = $datos[0]['tipoDefecto'] ?? 'N/A';
            $registroExistente->Talla = $datos[0]['talla'] ?? 'N/A';
            $registroExistente->Color = $datos[0]['color'] ?? 'N/A';
            $registroExistente->Status = $status;
            $registroExistente->save();
        }

        // Buscar si existe un registro con el ID de la fila seleccionada en ModelsDatosAuditoriaEtiquetas
        $statusupdate = ModelsDatosAuditoriaEtiquetas::find($rowId);
        if ($statusupdate) {
            // Actualizar solo el status del registro existente en ModelsDatosAuditoriaEtiquetas
            $statusupdate->update([
                'status' => $status
            ]);
        }

        // Retornar una respuesta JSON indicando el éxito
        return response()->json(['mensaje' => 'Los datos han sido actualizados correctamente'], 200);
    } catch (\Exception $e) {
        // Retornar una respuesta JSON con el mensaje de error
        return response()->json(['error' => 'Error al actualizar los datos: ' . $e->getMessage()], 500);
    }
}
















}
