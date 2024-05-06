<?php

namespace App\Http\Controllers;

use App\Models\DatosAuditoriaEtiquetas as ModelsDatosAuditoriaEtiquetas;
use App\Models\Cat_DefEtiquetas;
use App\Models\DatoAX;
use App\Models\DatosAX;
use App\Models\ReporteAuditoriaEtiqueta;
use App\Models\ReporteAuditoriaEtiquetasOP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DatosAuditoriaEtiquetasOP extends Controller
{
    public function auditoriaEtiquetasOP()
    {
        $mesesEnEspanol = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];
        return view('formulariosCalidad.auditoriaEtiquetasOP', compact('mesesEnEspanol'));
    }
    public function NoOrdenesOP()
    {
        $ordenes = DatosAX::select('op', 'cpo', 'salesid')
            ->distinct()
            ->get();

        return response()->json($ordenes);
    }

    public function buscarEstilosOP(Request $request)
    {
        $orden = $request->input('orden');

        // Buscar datos relacionados con la orden seleccionada
        $estilos = DatosAX::where('op', $orden)
            ->orWhere('cpo', $orden)
            ->orWhere('salesid', $orden)
            ->select('estilo')
            ->distinct()
            ->get();

        $status = [];

        foreach ($estilos as $key => $estilo) {
            // Obtener el estado de la auditoría para este estilo
            $auditoriaEstado = $this->obtenerEstadoAuditoriaOP($orden, $estilo->estilo);
            $status[$key] = $auditoriaEstado;
        }

        return response()->json(['estilo' => $estilos, 'statusOP' => $status]);
    }

    private function obtenerEstadoAuditoriaOP($orden, $estilo)
    {
        // Obtener todos los registros relacionados con la orden y el estilo
        $registros = DatosAX::where('op', $orden)
            ->orWhere('cpo', $orden)
            ->orWhere('salesid', $orden)
            ->where('estilo', $estilo)
            ->get();

        // Verificar los diferentes estados de auditoría
        $todosNulos = true;
        $todosIniciados = true;
        $alMenosUnoEnProceso = false;
        $todosFinalizados = true;

        foreach ($registros as $registro) {
            if ($registro->statusOP !== null) {
                $todosNulos = false;
            }

            if ($registro->statusOP !== 'Iniciado' && $registro->statusOP !== null) {
                $todosIniciados = false;
            }

            if ($registro->statusOP === 'Guardado' || $registro->statusOP === 'Update' || $registro->statusOP === 'Iniciado') {
                $alMenosUnoEnProceso = true;
            }

            if ($registro->statusOP !== 'Aprobado' && $registro->statusOP !== 'Aprobado Condicionalmente' && $registro->statusOP !== 'Rechazado') {
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

    public function buscarDatosAuditoriaPorEstiloOP(Request $request)
    {
        $estilo = $request->input('estilo');
        $orden = $request->input('orden');


        // Seleccionar la columna adecuada basada en $orden
        $columnaOrden = substr($orden,0,2) === 'OP' ? 'op' : (substr($orden,0,2) === 'OV' ? 'salesid' : 'cpo');
 // Log para registrar los datos del request


        // Buscar datos relacionados con el estilo especificado y la orden de compra
        $datos = DatosAX::where('estilo', $estilo)
        ->where($columnaOrden, $orden) // Cambio realizado aquí
        ->where(function ($query) {
            $query->whereNull('statusOP')
                ->orWhereIn('statusOP', ['Iniciado', 'Guardado']);
        })
        ->select('id', $columnaOrden, 'estilo', 'qty', 'sizename', 'inventcolorid')
        ->get();


        // Iterar sobre los datos y determinar el tamaño de muestra
        foreach ($datos as $dato) {
            $cantidad = $dato->qty;
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


    public function obtenerTiposDefectosOP()
    {
        $tiposDefectos = Cat_DefEtiquetas::all();

        return response()->json($tiposDefectos);
    }

    public function guardarInformacionOP(Request $request)
    {
        // Obtener los datos enviados desde el frontend
        $datos = $request->input('datos');

        $contador = count($datos);

        try {
            // Iterar sobre los datos recibidos
            for ($i = 0; $i < $contador; $i++) {
                // Buscar si existe un registro con el mismo ID en ReporteAuditoriaEtiqueta
                $registroExistente = ReporteAuditoriaEtiquetasOP::find($datos[$i]['id']);
                if ($registroExistente) {
                    // Si existe un registro en ReporteAuditoriaEtiqueta, actualizar sus atributos
                    $registroExistente->Status = 'Update';
                    $registroExistente->Defectos = $datos[$i]['defectos'] ?? 'N/A';
                    $registroExistente->Tipo_Defectos = $datos[$i]['tipoDefecto'] ?? 'N/A';
                    $registroExistente->save();
                } else {
                    // Si no existe, crear un nuevo registro en ReporteAuditoriaEtiqueta
                    $reporte = new ReporteAuditoriaEtiquetasOP();
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
                $registroExistenteModel = DatosAX::find($datos[$i]['id']);
                if ($registroExistenteModel) {
                    // Si existe un registro en ModelsDatosAuditoriaEtiquetas, actualizar solo su atributo 'status'
                    $registroExistenteModel->statusOP = 'Iniciado';
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

    public function actualizarStatusOP(Request $request)
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


                $registroExistente = ReporteAuditoriaEtiquetasOP::where('id', $rowId)->first();
                if ($registroExistente) {
                    if ($datos[$i]['id'] == $rowId) {
                        ReporteAuditoriaEtiquetasOP::WHERE('id', $rowId)
                            ->update([
                                'Status' => $status,
                                'Defectos' => $datos[$i]['defectos'] ?? 'N/A',
                                'Tipo_Defectos' => $datos[$i]['tipoDefecto'] ?? 'N/A'
                            ]);
                    }
                } else {
                    // Si no existe, crear un nuevo registro en ReporteAuditoriaEtiqueta
                    $registroExistente = new ReporteAuditoriaEtiquetasOP();
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
                $statusupdate = DatosAX::find($rowId);
                if ($statusupdate) {
                    // Si existe un registro en ModelsDatosAuditoriaEtiquetas, actualizar solo su atributo 'status'
                    $statusupdate->update([
                        'statusOP' => $status
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
