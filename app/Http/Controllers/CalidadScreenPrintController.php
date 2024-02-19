<?php

namespace App\Http\Controllers;

use App\Models\AccionCorrectScreen;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\DatosAX;
use App\Models\OpcionesDefectosScreen;
use App\Models\ScreenPrint;
use App\Models\Tecnicos;
use App\Models\Tipo_Fibra;
use App\Models\Tipo_Tecnica;

class CalidadScreenPrintController extends Controller
{
    public function ScreenPrint(Request $request)
    {

        $mesesEnEspanol = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];

        return view('ScreenPlanta2.ScreenPrint', compact('mesesEnEspanol'));
    }
    public function Clientes()
    {
        $clientes = DatosAX::select('cliente')->distinct()->get();

        return response()->json($clientes);
    }

    public function Estilos($cliente)
    {
        $estilos = DatosAX::select('estilo')
            ->where('cliente', $cliente) // Asegúrate de que estás usando el nombre correcto del campo
            ->distinct()
            ->get();

        return response()->json($estilos);
    }
    public function Ordenes($estilos)
    {
        $ordenes = DatosAX::select('orden')
            ->where('estilo', $estilos) // Asegúrate de que estás usando el nombre correcto del campo
            ->distinct()
            ->get();

        return response()->json($ordenes);
    }
    public function Tecnicos()
    {
        $tecnicos = Tecnicos::all();
        return response()->json($tecnicos);
    }
    public function TipoTecnica()
    {
        $tipo_tecnica = Tipo_Tecnica::all();

        return response()->json($tipo_tecnica);
    }
    public function TipoFibra()
    {
        $tipo_fibra = Tipo_Fibra::all();

        return response()->json($tipo_fibra);
    }
    public function AgregarTecnica(Request $request)
    {


        $nuevaTecnica = $request->input('nuevaTecnica');

        // Crear una nueva instancia de Tipo_Tecnica
        $addTecnica = new Tipo_Tecnica;

        $addTecnica->Tipo_tecnica = $nuevaTecnica;

        // Guardar la nueva técnica en la base de datos
        $addTecnica->save();

        return response()->json($addTecnica);
    }

    public function AgregarFibra(Request $request)
    {

        $nuevaFibra = $request->input('nuevafibra');

        // Crear una nueva instancia de Tipo_Tecnica
        $addFibra = new Tipo_Fibra;
        $addFibra->Tipo_Fibra = $nuevaFibra;

        // Guardar la nueva técnica en la base de datos
        $addFibra->save();

        return response()->json($addFibra);
    }
    public function viewTable()
    {
        // Obtener la fecha actual
        $today = Carbon::today();

        // Filtrar registros con la fecha actual
        $screen = ScreenPrint::whereDate('created_at', $today)->get();

        // Obtener opciones predeterminadas
        $defaultTipoProblema = "OpciónPredeterminadaTipoProblema";
        $defaultAcCorrectiva = "OpciónPredeterminadaAcCorrectiva";

        // Añadir opciones predeterminadas a cada registro
        foreach ($screen as &$item) {
            // Verificar y asignar el valor predeterminado si Tipo_Problema no está definido
            $item['Tipo_Problema'] = isset($item['Tipo_Problema']) ? $item['Tipo_Problema'] : $defaultTipoProblema;

            // Verificar y asignar el valor predeterminado si Ac_Correctiva no está definido
            $item['Ac_Correctiva'] = isset($item['Ac_Correctiva']) ? $item['Ac_Correctiva'] : $defaultAcCorrectiva;
        }

        // Crear un array asociativo con los datos a retornar
        return response()->json($screen);
    }



    public function SendScreenPrint(Request $request)
{
    // Obtener la marca addRowClicked del formulario
    $addRowClicked = $request->input('addRowClicked');

    // Obtener los datos del formulario
    $auditor = $request->input('Auditor');
    $cliente = $request->input('Cliente');
    $estilo = $request->input('Estilo');
    $opDefec = $request->input('OP_Defec');
    $tecnico = $request->input('Tecnico');
    $color = $request->input('Color');
    $numGrafico = $request->input('Num_Grafico');
    $tecnica = $request->input('Tecnica');
    $fibras = $request->input('Fibras');
    $porcentajeFibra = $request->input('Porcen_Fibra');
    $tipoProblema = $request->input('Tipo_Problema');
    $acCorrectiva = $request->input('Ac_Correctiva');

    // Crear un nuevo registro con 'Nuevo' como valor para la columna 'Status' si ambos botones fueron presionados
    if ($addRowClicked) {
        $screenPrint = ScreenPrint::create([
            'Auditor' => $auditor,
            'Cliente' => $cliente,
            'Estilo' => $estilo,
            'OP_Defec' => $opDefec,
            'Tecnico' => $tecnico,
            'Color' => $color,
            'Num_Grafico' => $numGrafico,
            'Tecnica' => $tecnica,
            'Fibras' => $fibras,
            'Porcen_Fibra' => $porcentajeFibra,
            'Tipo_Problema' => $tipoProblema,
            'Ac_Correctiva' => $acCorrectiva,
            'Status' => 'Nuevo', // Cambiado de 'Guardado' a 'Nuevo'
        ]);

        // Puedes realizar acciones adicionales si es necesario después de crear el nuevo registro

        return response()->json(['mensaje' => 'Datos guardados exitosamente', 'screenPrint' => $screenPrint]);
    }
   }



   public function UpdateScreenPrint(Request $request, $id)
   {
       // Verificar si el registro existe
       $screenPrint = ScreenPrint::find($id);

       if (!$screenPrint) {
           return response()->json(['mensaje' => 'Registro no encontrado'], 404);
       }

       // Actualizar los campos necesarios (ajusta según tu lógica)
       $screenPrint->update([
           'Cliente' => $request->input('Cliente'),
           'Estilo' => $request->input('Estilo'),
           'Tecnico' => $request->input('Tecnico'),
           'Color' => $request->input('Color'),
           'Num_Grafico' => $request->input('Num_Grafico'),
           'Tecnica' => $request->input('Tecnica'),
           'Fibras' => $request->input('Fibras'),
           'Porcen_Fibra' => $request->input('Porcen_Fibra'),
           'Tipo_Problema' => $request->input('Tipo_Problema'),
           'Ac_Correctiva' => $request->input('Ac_Correctiva'),
           'Status' => 'Update', // Puedes ajustar este campo según tus necesidades
       ]);

       // Puedes realizar acciones adicionales si es necesario después de actualizar el registro

       return response()->json(['mensaje' => 'Datos actualizados exitosamente']);
   }
   public function obtenerOpcionesACCorrectiva()
   {
       $data = AccionCorrectScreen::pluck('AccionCorrectiva');

       return response()->json($data);
   }

   public function obtenerOpcionesTipoProblema()
   {
    $data = OpcionesDefectosScreen::pluck('Defecto');

    return response()->json($data);
   }

}

