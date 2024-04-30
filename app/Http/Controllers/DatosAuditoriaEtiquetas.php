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

        $status = [];

        foreach ($estilos as $key => $estilo) {
            // Obtener el estado de la auditoría para este estilo
            $auditoriaEstado = $this->obtenerEstadoAuditoria($orden, $estilo->Estilos);
            $status[$key] = $auditoriaEstado;
        }

        return response()->json(['estilos' => $estilos, 'status' => $status]);
    }

    private function obtenerEstadoAuditoria($orden, $estilo)
    {
        // Obtener todos los registros relacionados con la orden y el estilo
        $registros = ModelsDatosAuditoriaEtiquetas::where('OrdenCompra', $orden)
            ->where('Estilos', $estilo)
            ->get();

        // Verificar los diferentes estados de auditoría
        $todosNulos = true;
        $todosIniciados = true;
        $alMenosUnoEnProceso = false;
        $todosFinalizados = true;

        foreach ($registros as $registro) {
            if ($registro->status !== null) {
                $todosNulos = false;
            }

            if ($registro->status !== 'Iniciado' && $registro->status !== null) {
                $todosIniciados = false;
            }

            if ($registro->status === 'Guardado' || $registro->status === 'Update' || $registro->status === 'Iniciado') {
                $alMenosUnoEnProceso = true;
            }

            if ($registro->status !== 'Aprobado' && $registro->status !== 'Aprobado Condicionalmente' && $registro->status !== 'Rechazado') {
                $todosFinalizados = false;
            }
        }

        // Determinar el estado de la auditoría
        if ($todosNulos) {
            return 'No iniciada';
        } elseif ($todosIniciados) {
            return 'Auditoría Iniciada';
        } elseif ($alMenosUnoEnProceso) {
            return 'En Proceso de auditoría';
        } elseif ($todosFinalizados) {
            return 'Auditoría Finalizada';
        }
    }

    public function buscarDatosAuditoriaPorEstilo(Request $request)
    {
        $estilo = $request->input('estilo');
        $orden = $request->input('orden');

        // Buscar datos relacionados con el estilo especificado y la orden de compra
        $datos = ModelsDatosAuditoriaEtiquetas::where('Estilos', $estilo)
        ->where('OrdenCompra', $orden)
        ->where(function ($query) {
            $query->whereNull('status')
                ->orWhereIn('status', ['Iniciado', 'Guardado']);
        })
        ->select('id', 'OrdenCompra', 'Estilos', 'Cantidad', 'Talla', 'Color')
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

            $contador = count($datos);
            $rowId = $request->input('rowId');

            // Iterar sobre los datos recibidos
            for ($i = 0; $i < $contador; $i++) {
                // Obtener el ID de la fila seleccionada


                $registroExistente = ReporteAuditoriaEtiqueta::where('id', $rowId)->first();
                if ($registroExistente) {
                    if ($datos[$i]['id'] == $rowId) {
                        ReporteAuditoriaEtiqueta::WHERE('id', $rowId)
                            ->update([
                                'Status' => $status,
                                'Defectos' => $datos[$i]['defectos'] ?? 'N/A',
                                'Tipo_Defectos' => $datos[$i]['tipoDefecto'] ?? 'N/A'
                            ]);
                    }
                } else {
                    // Si no existe, crear un nuevo registro en ReporteAuditoriaEtiqueta
                    $registroExistente = new ReporteAuditoriaEtiqueta();
                    $registroExistente->id = $rowId;
                    $registroExistente->Orden = $datos[$i]['orden'] ?? 'N/A';
                    $registroExistente->Estilos = $datos[$i]['estilo'] ?? 'N/A';
                    $registroExistente->Cantidad = $datos[$i]['cantidad'] ?? 'N/A';
                    $registroExistente->Muestreo = $datos[$i]['muestreo'] ?? 'N/A';
                    $registroExistente->Defectos = $datos[$i]['defectos'] ?? 'N/A';
                    $registroExistente->Tipo_Defectos = $datos[$i]['tipoDefecto'] ?? 'N/A';
                    $registroExistente->Talla = $datos[$i]['talla'] ?? 'N/A';
                    $registroExistente->Color = $datos[$i]['color'] ?? 'N/A';
                    $registroExistente->Status = $status;
                    $registroExistente->save();
                }

                // Buscar si existe un registro con el ID de la fila seleccionada en ModelsDatosAuditoriaEtiquetas
                $statusupdate = ModelsDatosAuditoriaEtiquetas::find($rowId);
                if ($statusupdate) {
                    // Si existe un registro en ModelsDatosAuditoriaEtiquetas, actualizar solo su atributo 'status'
                    $statusupdate->update([
                        'status' => $status
                    ]);
                }
            }

            // Retornar una respuesta JSON indicando el éxito
            return response()->json(['mensaje' => 'Los datos han sido actualizados correctamente'], 200);
        } catch (\Exception $e) {
            // Retornar una respuesta JSON con el mensaje de error
            return response()->json(['error' => 'Error al actualizar los datos: ' . $e->getMessage()], 500);
        }
    }
}
