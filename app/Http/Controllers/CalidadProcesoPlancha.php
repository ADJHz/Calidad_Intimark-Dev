<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccionCorrectScreen;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\DatosAX;
use App\Models\OpcionesDefectosScreen;
use App\Models\ProcesoPlancha;
use App\Models\Tecnicos;
class CalidadProcesoPlancha extends Controller
{
    public function ProcesoPlancha(Request $request)
    {

        $mesesEnEspanol = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];

        return view('ScreenPlanta2.CalidadProcesoPlancha', compact('mesesEnEspanol'));
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
public function OpcionesACCorrectiva()
    {
        $data = AccionCorrectScreen::pluck('AccionCorrectiva');

        return response()->json($data);
    }

    public function OpcionesTipoProblema()
    {
     $data = OpcionesDefectosScreen::pluck('Defecto');

     return response()->json($data);
    }
    public function viewTablePlancha()
{
    // Obtener la fecha actual
    $today = Carbon::today();

    // Filtrar registros con la fecha actual
    $screen = ProcesoPlancha::whereDate('created_at', $today)->get();

    // Crear un array asociativo con los datos a retornar
    $responseData = [];

    foreach ($screen as $item) {
        // Verificar y asignar el valor de Tipo_Problema si está definido, de lo contrario, establecer como nulo
        $tipoProblema = isset($item->Tipo_Problema) ? $item->Tipo_Problema : null;

        // Verificar y asignar el valor de Ac_Correctiva si está definido, de lo contrario, establecer como nulo
        $acCorrectiva = isset($item->Ac_Correctiva) ? $item->Ac_Correctiva : null;

        $responseData[] = [
            'id' => $item->id,
            'Auditor' => $item->Auditor,
            'Cliente' => $item->Cliente,
            'Estilo' => $item->Estilo,
            'OP_Defec' => $item->OP_Defec,
            'Tecnico' => $item->Tecnico,
            'Color' => $item->Color,
            'Num_Grafico' => $item->Num_Grafico,
            'Tipo_Problema' => $tipoProblema,
            'Ac_Correctiva' => $acCorrectiva,
            'Status' => $item->Status,
        ];
    }

    // Agregar logs para verificar los valores
    Log::info('Datos de /viewTable:', $responseData);

    return response()->json($responseData);
}

    public function SendPlancha(Request $request)
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
    $tipoProblema = $request->input('Tipo_Problema');
    $acCorrectiva = $request->input('Ac_Correctiva');
    // Crear un nuevo registro con 'Nuevo' como valor para la columna 'Status' si ambos botones fueron presionados
    if ($addRowClicked) {
        $screenPrint = ProcesoPlancha::create([
            'Auditor' => $auditor,
            'Cliente' => $cliente,
            'Estilo' => $estilo,
            'OP_Defec' => $opDefec,
            'Tecnico' => $tecnico,
            'Color' => $color,
            'Num_Grafico' => $numGrafico,
            'Tipo_Problema' => $tipoProblema,
            'Ac_Correctiva' => $acCorrectiva,
            'Status' => 'Nuevo', // Cambiado de 'Guardado' a 'Nuevo'
        ]);

        // Puedes realizar acciones adicionales si es necesario después de crear el nuevo registro

        return response()->json(['mensaje' => 'Datos guardados exitosamente', 'screenPrint' => $screenPrint]);
    }
   }

   public function UpdatePlancha(Request $request, $id)
   {
       // Verificar si el registro existe
       $screenPrint = ProcesoPlancha::find($id);

       if (!$screenPrint) {
           return response()->json(['mensaje' => 'Registro no encontrado'], 404);
       }

       // Obtener los valores actuales de 'Tipo_Problema' y 'Ac_Correctiva'
       $tipoProblemaActual = $screenPrint->Tipo_Problema;
       $acCorrectivaActual = $screenPrint->Ac_Correctiva;

       // Obtener los nuevos valores del request
       $tipoProblemaNuevo = $request->input('Tipo_Problema');
       $acCorrectivaNuevo = $request->input('Ac_Correctiva');

       // Validar que los nuevos valores no sean indefinidos o vacíos, y no sean 'Seleccione Tipo de Problema' o 'Seleccione Acción Correctiva'
       if ($tipoProblemaNuevo !== null && $tipoProblemaNuevo !== '' && $tipoProblemaNuevo !== 'Seleccione Tipo de Problema') {
           $tipoProblema = $tipoProblemaNuevo;
       } else {
           $tipoProblema = $tipoProblemaActual;
       }

       if ($acCorrectivaNuevo !== null && $acCorrectivaNuevo !== '' && $acCorrectivaNuevo !== 'Seleccione Acción Correctiva') {
           $acCorrectiva = $acCorrectivaNuevo;
       } else {
           $acCorrectiva = $acCorrectivaActual;
       }

       // Actualizar los campos necesarios (ajusta según tu lógica)
       $screenPrint->update([
           'Cliente' => $request->input('Cliente', $screenPrint->Cliente),
           'Estilo' => $request->input('Estilo', $screenPrint->Estilo),
           'Tecnico' => $request->input('Tecnico', $screenPrint->Tecnico),
           'Color' => $request->input('Color', $screenPrint->Color),
           'Num_Grafico' => $request->input('Num_Grafico', $screenPrint->Num_Grafico),
           'Tipo_Problema' => $tipoProblema,
           'Ac_Correctiva' => $acCorrectiva,
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
   public function actualizarEstado($id, Request $request)
   {
       // Buscar el registro por id
       $screenPrint = ProcesoPlancha::find($id);

       // Verificar si el registro existe
       if ($screenPrint) {
           // Actualizar el estado
           $screenPrint->Status = $request->input('status');

           // Guardar los cambios
           $screenPrint->save();

           // Devolver una respuesta exitosa
           return response()->json(['message' => 'Estado actualizado con éxito'], 200);
       } else {
           // Devolver una respuesta de error
           return response()->json(['message' => 'Registro no encontrado'], 404);
       }
   }
public function PorcenTotalDefecPlancha()
{
    try {
        // Obtener la fecha actual
        $today = Carbon::today();

        // Obtener la cantidad total de registros para el día actual
        $totalRegistros = ProcesoPlancha::whereDate('created_at', $today)->count();

        // Obtener la cantidad de registros con Tipo_Problema diferente de 'N/A'
        $defectos = ProcesoPlancha::whereDate('created_at', $today)
            ->where('Tipo_Problema', '<>', 'N/A')
            ->count();

        // Calcular el porcentaje
        $porcentaje = ($defectos / $totalRegistros) * 100;

        // Puedes devolver la respuesta JSON con los datos adicionales
        $data = [
            'success' => true,
            'totalRegistros' => $totalRegistros,
            'totalDefectos' => $defectos,
            'porcentaje' => $porcentaje,
            'message' => 'Datos calculados correctamente.',
        ];

        return response()->json($data);
    } catch (\Exception $e) {
        // Log de errores
        Log::error('Error en PorcenTotalDefec: ' . $e->getMessage());

        // Manejar el error y devolver una respuesta JSON
        $data = [
            'success' => false,
            'message' => 'Error al calcular los datos.',
        ];

        return response()->json($data, 500);
    }
}

}
