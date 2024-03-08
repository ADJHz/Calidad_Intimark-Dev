<?php

namespace App\Http\Controllers;

use App\Models\DatosAuditoriaEtiquetas as ModelsDatosAuditoriaEtiquetas;
use Illuminate\Http\Request;

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

        $ordenes = ModelsDatosAuditoriaEtiquetas::select('purchid')
            ->distinct()
            ->get();

        return response()->json($ordenes);
    }
    public function ClientesProv($ordenes)
    {
        $clientes = ModelsDatosAuditoriaEtiquetas::select('purchname')
            ->where('purchid', $ordenes)
            ->distinct()
            ->get();

        return response()->json($clientes);
    }

    public function Estilositem($ordenes)
    {
        $estilos = ModelsDatosAuditoriaEtiquetas::select('itemid')
            ->where('purchid', $ordenes)
            ->distinct()
            ->get();

        return response()->json($estilos);
    }
    public function Colores($estilos)
    {
        $colores = ModelsDatosAuditoriaEtiquetas::select('inventcolorid')
            ->where('itemid', $estilos)
            ->distinct()
            ->get();
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
