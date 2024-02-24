<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccionCorrectScreen;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\DatosAX;
use App\Models\Horno_Banda;
use App\Models\OpcionesDefectosScreen;
use App\Models\InspeccionEstampadoDHorno;
use App\Models\Tecnicos;
use App\Models\Tipo_Fibra;
use App\Models\Tipo_Tecnica;

class InspeccionEstampadoHorno extends Controller
{
    public function InsEstamHorno(Request $request)
    {

        $mesesEnEspanol = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];

        return view('ScreenPlanta2.InsEstamHorno', compact('mesesEnEspanol'));
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
    public function viewTableIns()
{
    // Obtener la fecha actual
    $today = Carbon::today();

    // Filtrar registros con la fecha actual
    $screen = InspeccionEstampadoDHorno::whereDate('created_at', $today)->get();

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
            'Tipo_Maquina' => $item->Tipo_Maquina,
            'LeyendaSprint' => $item->LeyendaSprint,
            'Tecnica' => $item->Tecnica,
            'Fibras' => $item->Fibras,
            'Porcen_Fibra' => $item->Porcen_Fibra,
            'Hora' => $item->Hora,
            'Bulto' => $item->Bulto,
            'Talla' => $item->Talla,
            'Tipo_Problema' => $tipoProblema,
            'Ac_Correctiva' => $acCorrectiva,
            'Status' => $item->Status,
        ];
    }

    // Agregar logs para verificar los valores
    Log::info('Datos de /viewTable:', $responseData);

    return response()->json($responseData);
}

    public function SendInspeccionEstampadoHornot(Request $request)
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
    $tipomaquina = $request->input('Tipo_Maquina');
    $leyendasprint = $request->input('LeyendaSPrint');
    $tecnica = $request->input('Tecnica');
    $fibras = $request->input('Fibras');
    $porcentajeFibra = $request->input('Porcen_Fibra');
    $hora = $request->input('Hora');
    $bulto = $request->input('Bulto');
    $talla = $request->input('Talla');
    $tipoProblema = $request->input('Tipo_Problema');
    $acCorrectiva = $request->input('Ac_Correctiva');
    // Log de los datos
    Log::info('Datos recibidos en SendInspeccionEstampadoHornot:', [
        'Auditor' => $auditor,
        'Cliente' => $cliente,
        'Estilo' => $estilo,
        'OP_Defec' => $opDefec,
        'Tecnico' => $tecnico,
        'Color' => $color,
        'Num_Grafico' => $numGrafico,
        'Tipo_Maquina' => $tipomaquina,
        'LeyendaSprint' => $leyendasprint,
        'Tecnica' => $tecnica,
        'Fibras' => $fibras,
        'Porcen_Fibra' => $porcentajeFibra,
        'Hora' => $hora,
        'Bulto' => $bulto,
        'Talla' => $talla,
        'Tipo_Problema' => $tipoProblema,
        'Ac_Correctiva' => $acCorrectiva,
        'addRowClicked' => $addRowClicked,
    ]);

    // Crear un nuevo registro con 'Nuevo' como valor para la columna 'Status' si ambos botones fueron presionados
    if ($addRowClicked) {
        $screenPrint = InspeccionEstampadoDHorno::create([
            'Auditor' => $auditor,
            'Cliente' => $cliente,
            'Estilo' => $estilo,
            'OP_Defec' => $opDefec,
            'Tecnico' => $tecnico,
            'Color' => $color,
            'Num_Grafico' => $numGrafico,
            'Tipo_Maquina' => $tipomaquina,
            'LeyendaSprint' => $leyendasprint,
            'Tecnica' => $tecnica,
            'Fibras' => $fibras,
            'Porcen_Fibra' => $porcentajeFibra,
            'Hora' => $hora,
            'Bulto' => $bulto,
            'Talla' => $talla,
            'Tipo_Problema' => $tipoProblema,
            'Ac_Correctiva' => $acCorrectiva,
            'Status' => 'Nuevo', // Cambiado de 'Guardado' a 'Nuevo'
        ]);

        // Puedes realizar acciones adicionales si es necesario después de crear el nuevo registro

        return response()->json(['mensaje' => 'Datos guardados exitosamente', 'screenPrint' => $screenPrint]);
    }
   }

   public function UpdateIsnpec(Request $request, $id)
   {
       // Verificar si el registro existe
       $screenPrint = InspeccionEstampadoDHorno::find($id);

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
           'Tipo_Maquina' => $request->input('Tipo_Maquina', $screenPrint->Tipo_Maquina),
           'LeyendaSprint' => $request->input('LeyendaSprint', $screenPrint->LeyendaSprint),
           'Tecnica' => $request->input('Tecnica', $screenPrint->Tecnica),
           'Fibras' => $request->input('Fibras', $screenPrint->Fibras),
           'Hora' => $request->input('Hora', $screenPrint->Hora),
           'Bulto' => $request->input('Bulto', $screenPrint->Bulto),
           'Talla' => $request->input('Talla', $screenPrint->Talla),
           'Porcen_Fibra' => $request->input('Porcen_Fibra', $screenPrint->Porcen_Fibra),
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
       $screenPrint = InspeccionEstampadoDHorno::find($id);

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
public function PorcenTotalDefec()
{
    try {
        // Obtener la fecha actual
        $today = Carbon::today();

        // Obtener la cantidad total de registros para el día actual
        $totalRegistros = InspeccionEstampadoDHorno::whereDate('created_at', $today)->count();

        // Obtener la cantidad de registros con Tipo_Problema diferente de 'N/A'
        $defectos = InspeccionEstampadoDHorno::whereDate('created_at', $today)
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