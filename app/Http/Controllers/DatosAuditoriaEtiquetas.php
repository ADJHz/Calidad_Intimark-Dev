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
    public function buscarDatosAuditoria(Request $request)
    {
        $orden = $request->input('orden');
        // Buscar datos relacionados con la orden seleccionada
        $datos = ModelsDatosAuditoriaEtiquetas::where('OrdenCompra', $orden)
        ->select('OrdenCompra', 'Estilos','Cantidad','Talla','Color')

        ->get();
        return response()->json($datos);
    }
    public function buscarDatosAuditoriaModal(Request $request)
    {
        $orden = $request->input('orden');
        $estilo = $request->input('estilo'); // Obtener el estilo de la fila seleccionada

        // Buscar datos relacionados con la orden y el estilo seleccionados, y obtener columnas específicas
        $datos = ModelsDatosAuditoriaEtiquetas::select('Estilos', 'Talla', 'Color', 'Cantidad', 'Lotes')
            ->where('OrdenCompra', $orden)
            ->where('Estilos', $estilo) // Agregar la condición para el estilo
            ->distinct('Lotes')
            ->get();

        return response()->json($datos);
    }

}
