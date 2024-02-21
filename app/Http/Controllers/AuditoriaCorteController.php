<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoriaAuditor;
use App\Models\CategoriaCliente;
use App\Models\CategoriaColor;
use App\Models\CategoriaEstilo;
use App\Models\CategoriaNoRecibo;
use App\Models\CategoriaTallaCantidad;
use App\Models\CategoriaTamañoMuestra;
use App\Models\CategoriaDefecto;
use App\Models\CategoriaTipoDefecto;
use App\Models\EncabezadoAuditoriaCorte;
use App\Models\AuditoriaMarcada;
use App\Models\AuditoriaTendido;
use App\Models\Lectra;
use App\Models\AuditoriaBulto;
use App\Models\AuditoriaFinal;

use App\Exports\DatosExport;
use App\Models\DatoAX;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon; // Asegúrate de importar la clase Carbon

class AuditoriaCorteController extends Controller
{

    // Método privado para cargar las categorías
    private function cargarCategorias() {
        return [
            'CategoriaCliente' => CategoriaCliente::where('estado', 1)->get(),
            'CategoriaColor' => CategoriaColor::where('estado', 1)->get(),
            'CategoriaEstilo' => CategoriaEstilo::where('estado', 1)->get(),
            'CategoriaNoRecibo' => CategoriaNoRecibo::where('estado', 1)->get(),
            'CategoriaTallaCantidad' => CategoriaTallaCantidad::where('estado', 1)->get(),
            'CategoriaTamañoMuestra' => CategoriaTamañoMuestra::where('estado', 1)->get(),
            'CategoriaDefecto' => CategoriaDefecto::where('estado', 1)->get(),
            'CategoriaTipoDefecto' => CategoriaTipoDefecto::where('estado', 1)->get(),
            'CategoriaAuditor' => CategoriaAuditor::where('estado', 1)->get(),
            'DatoAX' => DatoAX::where(function($query) {
                $query->whereNull('estatus')
                      ->orWhere('estatus', '');
            })->get(),
            'DatoAXNoIniciado' => DatoAX::whereNotIn('estatus', ['fin'])
                           ->where(function ($query) {
                               $query->whereNull('estatus')
                                     ->orWhere('estatus', '');
                           })
                           ->get(),
            'DatoAXProceso' => DatoAX::whereNotIn('estatus', ['fin'])
                           ->whereNotNull('estatus')
                           ->whereNotIn('estatus', [''])
                           ->with('auditoriasMarcadas')
                           ->get(),
            'DatoAXFin' => DatoAX::where('estatus', 'fin')->get(),
            'EncabezadoAuditoriaCorte' => EncabezadoAuditoriaCorte::all(),
            'auditoriasMarcadas' => AuditoriaMarcada::all(),
        ];
    }

    public function inicioAuditoriaCorte()
    {
        $activePage ='';
        $categorias = $this->cargarCategorias();


        $mesesEnEspanol = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];

        return view('auditoriaCorte.inicioAuditoriaCorte', array_merge($categorias, ['mesesEnEspanol' => $mesesEnEspanol, 'activePage' => $activePage]));
    }

    public function auditoriaCorte($id, $orden)
    {
        $activePage ='';
        $categorias = $this->cargarCategorias();
        // Obtener el dato con el id seleccionado y el valor de la columna "orden"
        $datoAX = DatoAX::where('op', $orden)->first();
        //dd($datoAX);
        $mesesEnEspanol = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];
        // Obtener el registro correspondiente en la tabla AuditoriaMarcada si existe
        $encabezadoAuditoriaCorte = EncabezadoAuditoriaCorte::where('orden_id', $orden)->first();
        $auditoriaMarcada = AuditoriaMarcada::where('id', $id)->first();
        $auditoriaTendido = AuditoriaTendido::where('id', $id)->first();
        $Lectra = Lectra::where('id', $id)->first();
        $auditoriaBulto = AuditoriaBulto::where('id', $id)->first();
        $auditoriaFinal = AuditoriaFinal::where('id', $id)->first();
        // apartado para validar los checbox

        $mostrarFinalizarMarcada = $auditoriaMarcada ? session('estatus_checked_AuditoriaMarcada') : false;
        
        // Verifica si los campos específicos son NULL
        if ($auditoriaMarcada && is_null($auditoriaMarcada->yarda_orden_estatus) &&
            is_null($auditoriaMarcada->yarda_marcada_estatus) &&
            is_null($auditoriaMarcada->yarda_tendido_estatus)) {
            $mostrarFinalizarMarcada = false;
        }
        
        //dd($auditoriaMarcada, $mostrarFinalizarMarcada);
        $mostrarFinalizarTendido = $auditoriaTendido ? session('estatus_checked_AuditoriaTendido') : false;
        $mostrarFinalizarLectra = $Lectra ? session('estatus_checked_Lectra') : false;
        $mostrarFinalizarBulto = $auditoriaBulto ? session('estatus_checked_AuditoriaBulto') : false;
        $mostrarFinalizarFinal = $auditoriaFinal ? session('estatus_checked_AuditoriaFinal') : false;
        return view('auditoriaCorte.auditoriaCorte', array_merge($categorias, [
            'mesesEnEspanol' => $mesesEnEspanol, 
            'activePage' => $activePage, 
            'datoAX' => $datoAX, 
            'auditoriaMarcada' => $auditoriaMarcada,
            'auditoriaTendido' => $auditoriaTendido,
            'Lectra' => $Lectra, 
            'auditoriaBulto' => $auditoriaBulto, 
            'auditoriaFinal' => $auditoriaFinal,
            'mostrarFinalizarMarcada' => $mostrarFinalizarMarcada,
            'mostrarFinalizarTendido' => $mostrarFinalizarTendido,
            'mostrarFinalizarLectra' => $mostrarFinalizarLectra,
            'mostrarFinalizarBulto' => $mostrarFinalizarBulto,
            'mostrarFinalizarFinal' => $mostrarFinalizarFinal,
            'encabezadoAuditoriaCorte' => $encabezadoAuditoriaCorte]));
    }


    
    public function formEncabezadoAuditoriaCorte(Request $request)
    {
        $activePage ='';
        // Validar los datos del formulario si es necesario
        $activePage ='';
        // Validar los datos del formulario si es necesario
        // Obtener el ID seleccionado desde el formulario
        $idSeleccionado = $request->input('id');
        $orden = $request->input('orden');
        // Verificar si ya existen datos para el dato_ax_id especificado
        if (EncabezadoAuditoriaCorte::where('dato_ax_id', $idSeleccionado)->exists()) {
            //dd($request->all());
            return back()->with('sobre-escribir', 'Ya existen datos para este registro.');
        }

        // Realizar la actualización en la base de datos
        $auditoria= new EncabezadoAuditoriaCorte();
        $auditoria->dato_ax_id = $idSeleccionado;
        $auditoria->orden_id = $orden;
        $auditoria->cliente = $request->input('cliente');
        $auditoria->material = $request->input('material');
        $auditoria->color = $request->input('color');
        $auditoria->pieza = $request->input('pieza');
        $auditoria->trazo = $request->input('trazo');
        $auditoria->lienzo = $request->input('lienzo');
        $auditoria->evento = $request->input('evento');
        // Establecer fecha_inicio con la fecha y hora actual
        $auditoria->fecha_inicio = Carbon::now()->format('Y-m-d H:i:s');
        $auditoria->estatus = "estatusAuditoriaMarcada";
        $auditoria->save();

        $datoAX = DatoAX::findOrFail($idSeleccionado);
        // Actualizar el valor de la columna deseada
        $datoAX->estatus = 'estatusAuditoriaMarcada';
        $datoAX->evento = $request->input('evento');
        $datoAX->save();


        // Generar múltiples registros en auditoria_marcadas según el valor de evento
        for ($i = 0; $i < $request->input('evento'); $i++) {
            $auditoriaMarcada = new AuditoriaMarcada();
            $auditoriaMarcada->dato_ax_id = $idSeleccionado;
            $auditoriaMarcada->orden_id = $orden;
            $auditoriaMarcada->estatus = "proceso";
            $auditoriaMarcada->evento = $i+1;
            // Otros campos que necesites para cada registro...
            
            $auditoriaMarcada->save();
            if ($i === 0) {
                $idEvento1 = $auditoriaMarcada->id;
            }

            $auditoriaTendido = new AuditoriaTendido();
            $auditoriaTendido->dato_ax_id = $idSeleccionado;
            $auditoriaTendido->orden_id = $orden;
            $auditoriaTendido->estatus = "proceso";
            $auditoriaTendido->evento = $i+1;
            $auditoriaTendido->save();

            $lectra = new Lectra();
            $lectra->dato_ax_id = $idSeleccionado;
            $lectra->orden_id = $orden;
            $lectra->estatus = "proceso";
            $lectra->evento = $i+1;
            $lectra->save();

            $auditoriaBulto = new AuditoriaBulto();
            $auditoriaBulto->dato_ax_id = $idSeleccionado;
            $auditoriaBulto->orden_id = $orden;
            $auditoriaBulto->estatus = "proceso";
            $auditoriaBulto->evento = $i+1;
            $auditoriaBulto->save();

            $auditoriaFinal = new AuditoriaFinal();
            $auditoriaFinal->dato_ax_id = $idSeleccionado;
            $auditoriaFinal->orden_id = $orden;
            $auditoriaFinal->estatus = "proceso";
            $auditoriaFinal->evento = $i+1;
            $auditoriaFinal->save();

        }
        //dd($idEvento1);

        return redirect()->route('auditoriaCorte.auditoriaCorte', ['id' => $idEvento1, 'orden' => $orden])->with('success', 'Datos guardados correctamente.')->with('activePage', $activePage);
    }

    

    public function formAuditoriaMarcada(Request $request)
    {
        $activePage ='';
        // Validar los datos del formulario si es necesario
        // Obtener el ID seleccionado desde el formulario
        $idSeleccionado = $request->input('id');
        $idAuditoriaMarcada = $request->input('idAuditoriaMarcada');
        //dd($idSeleccionado, $idAuditoriaMarcada);
        $orden = $request->input('orden');
        $accion = $request->input('accion'); // Obtener el valor del campo 'accion'
        // Verificar la acción y actualizar el campo 'estatus' solo si se hizo clic en el botón "Finalizar"
        //dd($accion);
        if ($accion === 'finalizar') {
            // Buscar la fila en la base de datos utilizando el modelo AuditoriaMarcada
            $auditoria = DatoAX::findOrFail($idSeleccionado);

            // Actualizar el valor de la columna deseada
            $auditoria->estatus = 'estatusAuditoriaTendido';
            $auditoria->save();
            $auditoriaMarcadaEstatus = AuditoriaMarcada::where('id', $idAuditoriaMarcada)->first();
            $auditoriaMarcadaEstatus->estatus = 'estatusAuditoriaTendido';
            // Asegúrate de llamar a save() en la variable actualizada
            $auditoriaMarcadaEstatus->save();
            return back()->with('cambio-estatus', 'Se Cambio a estatus: AUDITORIA DE TENDIDO.')->with('activePage', $activePage);
        }

        $allChecked = trim($request->input('yarda_orden_estatus')) === "1" &&
              trim($request->input('yarda_marcada_estatus')) === "1" &&
              trim($request->input('yarda_tendido_estatus')) === "1";

        $request->session()->put('estatus_checked_AuditoriaMarcada', $allChecked);
        // Verificar si ya existe un registro con el mismo valor de orden_id
        $existeOrden = AuditoriaMarcada::where('id', $idAuditoriaMarcada)->first();

        // Si ya existe un registro con el mismo valor de orden_id, puedes mostrar un mensaje de error o tomar alguna otra acción
        if ($existeOrden) {
            $existeOrden->yarda_orden = $request->input('yarda_orden');
            $existeOrden->yarda_orden_estatus = $request->input('yarda_orden_estatus');
            $existeOrden->yarda_marcada = $request->input('yarda_marcada');
            $existeOrden->yarda_marcada_estatus = $request->input('yarda_marcada_estatus');
            $existeOrden->yarda_tendido = $request->input('yarda_tendido');
            $existeOrden->yarda_tendido_estatus = $request->input('yarda_tendido_estatus');
            $existeOrden->talla1 = $request->input('talla1');
            $existeOrden->talla2 = $request->input('talla2');
            $existeOrden->talla3 = $request->input('talla3');
            $existeOrden->talla4 = $request->input('talla4');
            $existeOrden->talla5 = $request->input('talla5');
            $existeOrden->talla6 = $request->input('talla6');
            $existeOrden->talla7 = $request->input('talla7');
            $existeOrden->talla8 = $request->input('talla8');
            $existeOrden->talla9 = $request->input('talla9');
            $existeOrden->talla10 = $request->input('talla10');
            $existeOrden->bulto1 = $request->input('bulto1');
            $existeOrden->bulto2 = $request->input('bulto2');
            $existeOrden->bulto3 = $request->input('bulto3');
            $existeOrden->bulto4 = $request->input('bulto4');
            $existeOrden->bulto5 = $request->input('bulto5');
            $existeOrden->bulto6 = $request->input('bulto6');
            $existeOrden->bulto7 = $request->input('bulto7');
            $existeOrden->bulto8 = $request->input('bulto8');
            $existeOrden->bulto9 = $request->input('bulto9');
            $existeOrden->bulto10 = $request->input('bulto10');
            $existeOrden->total_pieza1 = $request->input('total_pieza1');
            $existeOrden->total_pieza2 = $request->input('total_pieza2');
            $existeOrden->total_pieza3 = $request->input('total_pieza3');
            $existeOrden->total_pieza4 = $request->input('total_pieza4');
            $existeOrden->total_pieza5 = $request->input('total_pieza5');
            $existeOrden->total_pieza6 = $request->input('total_pieza6');
            $existeOrden->total_pieza7 = $request->input('total_pieza7');
            $existeOrden->total_pieza8 = $request->input('total_pieza8');
            $existeOrden->total_pieza9 = $request->input('total_pieza9');
            $existeOrden->total_pieza10 = $request->input('total_pieza10');
            $existeOrden->largo_trazo =  $request->input('largo_trazo');
            $existeOrden->ancho_trazo = $request->input('ancho_trazo');
            $existeOrden->save();
            
            return back()->with('sobre-escribir', 'Actualilzacion realizada con exito');
        }

        return back()->with('success', 'Datos guardados correctamente.')->with('activePage', $activePage);
    }

    public function formAuditoriaTendido(Request $request)
    {
        $activePage ='';
        // Validar los datos del formulario si es necesario
        // Obtener el ID seleccionado desde el formulario
        $idSeleccionado = $request->input('id');
        $idAuditoriaTendido = $request->input('idAuditoriaTendido');
        $orden = $request->input('orden');
        $accion = $request->input('accion'); // Obtener el valor del campo 'accion'
        //dd($accion);
        
        if ($accion === 'finalizar') {
            // Buscar la fila en la base de datos utilizando el modelo AuditoriaMarcada
            $auditoria = DatoAX::findOrFail($idSeleccionado);

            // Actualizar el valor de la columna deseada
            $auditoria->estatus = 'estatusLectra';
            $auditoria->save();

            $auditoriaTendido = AuditoriaTendido::where('id', $idAuditoriaTendido)->first();
            $auditoriaTendido->estatus = 'estatusLectra';
            // Asegúrate de llamar a save() en la variable actualizada
            $auditoriaTendido->save();
            return back()->with('cambio-estatus', 'Se Cambio a estatus: LECTRA.')->with('activePage', $activePage);
        }

        $allChecked = trim($request->input('codigo_material_estatus')) === "1" &&
              trim($request->input('codigo_color_estatus')) === "1" &&
              trim($request->input('informacion_trazo_estatus')) === "1" &&
              trim($request->input('cantidad_lienzo_estatus')) === "1" &&
              trim($request->input('longitud_tendido_estatus')) === "1" &&
              trim($request->input('ancho_tendido_estatus')) === "1" &&
              trim($request->input('material_relajado_estatus')) === "1" &&
              trim($request->input('empalme_estatus')) === "1" &&
              trim($request->input('cara_material_estatus')) === "1" &&
              trim($request->input('tono_estatus')) === "1" &&
              trim($request->input('alineacion_tendido_estatus')) === "1" &&
              trim($request->input('arruga_tendido_estatus')) === "1" &&
              trim($request->input('defecto_material_estatus')) === "1";

        $request->session()->put('estatus_checked_AuditoriaTendido', $allChecked);
        // Verificar si ya existe un registro con el mismo valor de orden_id
        $existeOrden = AuditoriaTendido::where('id', $idAuditoriaTendido)->first();
        //dd($existeOrden);

        // Si ya existe un registro con el mismo valor de orden_id, puedes mostrar un mensaje de error o tomar alguna otra acción
        if ($existeOrden) {
            $existeOrden->nombre = $request->input('nombre');
            $existeOrden->mesa = $request->input('mesa');
            $existeOrden->auditor = $request->input('auditor');
            $existeOrden->codigo_material = $request->input('codigo_material');
            $existeOrden->codigo_material_estatus = $request->input('codigo_material_estatus');
            $existeOrden->codigo_color = $request->input('codigo_color');
            $existeOrden->codigo_color_estatus = $request->input('codigo_color_estatus');
            $existeOrden->informacion_trazo = $request->input('informacion_trazo');
            $existeOrden->informacion_trazo_estatus = $request->input('informacion_trazo_estatus');
            $existeOrden->cantidad_lienzo = $request->input('cantidad_lienzo');
            $existeOrden->cantidad_lienzo_estatus = $request->input('cantidad_lienzo_estatus');
            $existeOrden->longitud_tendido = $request->input('longitud_tendido');
            $existeOrden->longitud_tendido_estatus = $request->input('longitud_tendido_estatus');
            $existeOrden->ancho_tendido = $request->input('ancho_tendido');
            $existeOrden->ancho_tendido_estatus = $request->input('ancho_tendido_estatus');
            $existeOrden->material_relajado = $request->input('material_relajado');
            $existeOrden->material_relajado_estatus = $request->input('material_relajado_estatus');
            $existeOrden->empalme = $request->input('empalme');
            $existeOrden->empalme_estatus = $request->input('empalme_estatus');
            $existeOrden->cara_material = $request->input('cara_material');
            $existeOrden->cara_material_estatus = $request->input('cara_material_estatus');
            $existeOrden->tono = $request->input('tono');
            $existeOrden->tono_estatus = $request->input('tono_estatus');
            $existeOrden->alineacion_tendido = $request->input('alineacion_tendido');
            $existeOrden->alineacion_tendido_estatus = $request->input('alineacion_tendido_estatus');
            $existeOrden->arruga_tendido = $request->input('arruga_tendido');
            $existeOrden->arruga_tendido_estatus = $request->input('arruga_tendido_estatus');
            $existeOrden->defecto_material = $request->input('defecto_material');
            $existeOrden->defecto_material_estatus = $request->input('defecto_material_estatus');
            $existeOrden->accion_correctiva = $request->input('accion_correctiva');
            //$existeOrden->libera_tendido = $request->input('libera_tendido');

            $existeOrden->save();
            //dd($existeOrden);
            return back()->with('sobre-escribir', 'Actualilzacion realizada con exito');
        }

        return back()->with('success', 'Datos guardados correctamente.')->with('activePage', $activePage);
    }

    public function formLectra(Request $request)
    {
        $activePage ='';
        // Validar los datos del formulario si es necesario
        // Obtener el ID seleccionado desde el formulario
        $idSeleccionado = $request->input('id');
        $idLectra = $request->input('idLectra');
        $orden = $request->input('orden');
        $accion = $request->input('accion'); // Obtener el valor del campo 'accion'

        if ($accion === 'finalizar') {
            // Buscar la fila en la base de datos utilizando el modelo AuditoriaMarcada
            $auditoria = DatoAX::findOrFail($idSeleccionado);

            // Actualizar el valor de la columna deseada
            $auditoria->estatus = 'estatusAuditoriaBulto';
            $auditoria->save();

            $lectra = Lectra::where('id', $idLectra)->first();
            $lectra->estatus = 'estatusAuditoriaBulto';
            // Asegúrate de llamar a save() en la variable actualizada
            $lectra->save();
            return back()->with('cambio-estatus', 'Se Cambio a estatus: AUDITORIA EN BULTOS.')->with('activePage', $activePage);
        }

        $allChecked = trim($request->input('simetria_pieza_estatus')) === "1" &&
              trim($request->input('pieza_completa_estatus')) === "1" &&
              trim($request->input('pieza_contrapatron_estatus')) === "1";

        $request->session()->put('estatus_checked_Lectra', $allChecked);
        // Verificar si ya existe un registro con el mismo valor de orden_id
        $existeOrden = Lectra::where('id', $idLectra)->first();
        //dd($existeOrden);

        // Si ya existe un registro con el mismo valor de orden_id, puedes mostrar un mensaje de error o tomar alguna otra acción
        if ($existeOrden) {
            $existeOrden->nombre = $request->input('nombre');
            $existeOrden->mesa = $request->input('mesa');
            $existeOrden->auditor = $request->input('auditor');
            $existeOrden->simetria_pieza = $request->input('simetria_pieza');
            $existeOrden->simetria_pieza_estatus = $request->input('simetria_pieza_estatus');
            $existeOrden->pieza_completa = $request->input('pieza_completa');
            $existeOrden->pieza_completa_estatus = $request->input('pieza_completa_estatus');
            $existeOrden->pieza_contrapatron = $request->input('pieza_contrapatron');
            $existeOrden->pieza_contrapatron_estatus = $request->input('pieza_contrapatron_estatus');
            $existeOrden->pieza_inspeccionada = $request->input('pieza_inspeccionada');
            $existeOrden->defecto = $request->input('defecto');
            $existeOrden->porcentaje = $request->input('porcentaje');

        
            $existeOrden->save();
            
            return back()->with('sobre-escribir', 'Actualilzacion realizada con exito');
        }

        return back()->with('success', 'Datos guardados correctamente.')->with('activePage', $activePage);
    }

    public function formAuditoriaBulto(Request $request)
    {
        $activePage ='';
        // Validar los datos del formulario si es necesario
        // Obtener el ID seleccionado desde el formulario
        $idSeleccionado = $request->input('id');
        $idBulto = $request->input('idBulto');
        $orden = $request->input('orden');
        $accion = $request->input('accion'); // Obtener el valor del campo 'accion'
        //dd($request->input());
        if ($accion === 'finalizar') {
            // Buscar la fila en la base de datos utilizando el modelo AuditoriaMarcada
            $auditoria = DatoAX::findOrFail($idSeleccionado);

            // Actualizar el valor de la columna deseada
            $auditoria->estatus = 'estatusAuditoriaFinal';
            $auditoria->save();

            $auditoriaBulto = Lectra::where('id', $idBulto)->first();
            $auditoriaBulto->estatus = 'estatusAuditoriaFinal';
            // Asegúrate de llamar a save() en la variable actualizada
            $auditoriaBulto->save();
            return back()->with('cambio-estatus', 'Se Cambio a estatus: AUDITORIA FINAL.')->with('activePage', $activePage);
        }

        // Verificar si todos los checkboxes tienen el valor deseado
        $allChecked = trim($request->input('cantidad_bulto_estatus')) === "1" &&
              trim($request->input('pieza_paquete_estatus')) === "1" &&
              trim($request->input('ingreso_ticket_estatus')) === "1" &&
              trim($request->input('sellado_paquete_estatus')) === "1";

        $request->session()->put('estatus_checked_AuditoriaBulto', $allChecked);

        // Verificar si ya existe un registro con el mismo valor de orden_id
        $existeOrden = AuditoriaBulto::where('id', $idBulto)->first();
        //dd($existeOrden);
        // Si ya existe un registro con el mismo valor de orden_id, puedes mostrar un mensaje de error o tomar alguna otra acción
        if ($existeOrden) {
            $existeOrden->nombre = $request->input('nombre');
            $existeOrden->mesa = $request->input('mesa');
            $existeOrden->auditor = $request->input('auditor');
            $existeOrden->cantidad_bulto = $request->input('cantidad_bulto');
            $existeOrden->cantidad_bulto_estatus = $request->input('cantidad_bulto_estatus');
            $existeOrden->pieza_paquete = $request->input('pieza_paquete');
            $existeOrden->pieza_paquete_estatus = $request->input('pieza_paquete_estatus');
            $existeOrden->ingreso_ticket = $request->input('ingreso_ticket');
            $existeOrden->ingreso_ticket_estatus = $request->input('ingreso_ticket_estatus');
            $existeOrden->sellado_paquete = $request->input('sellado_paquete');
            $existeOrden->sellado_paquete_estatus = $request->input('sellado_paquete_estatus');
            $existeOrden->defecto = $request->input('defecto');
            $existeOrden->porcentaje = $request->input('porcentaje');

        
            $existeOrden->save();
            //dd($existeOrden);
            return back()->with('sobre-escribir', 'Actualilzacion realizada con exito');
        }

        return back()->with('success', 'Datos guardados correctamente.')->with('activePage', $activePage);
    }

    public function formAuditoriaFinal(Request $request)
    {
        $activePage ='';
        // Validar los datos del formulario si es necesario
        // Obtener el ID seleccionado desde el formulario
        $idSeleccionado = $request->input('id');
        $idAuditoriaFinal = $request->input('idAuditoriaFinal');
        $orden = $request->input('orden');
        $accion = $request->input('accion'); // Obtener el valor del campo 'accion'

        if ($accion === 'finalizar') {
            // Buscar la fila en la base de datos utilizando el modelo AuditoriaMarcada
            $auditoria = DatoAX::findOrFail($idSeleccionado);

            // Actualizar el valor de la columna deseada
            $auditoria->estatus = 'fin';
            $auditoria->save();
            $auditoriaFinal = AuditoriaFinal::where('id', $idAuditoriaFinal)->first();
            $auditoriaFinal->estatus = 'fin';
            // Asegúrate de llamar a save() en la variable actualizada
            $auditoriaFinal->save();
            return back()->with('cambio-estatus', 'Fin 👋.')->with('activePage', $activePage);
        }
        // Verificar si todos los checkboxes tienen el valor de "1"
        $allChecked = $request->input('estatus') == 1;
        // Guardar el estado del checkbox en la sesión
        $request->session()->put('estatus_checked_AuditoriaFinal', $allChecked);
        // Verificar si ya existe un registro con el mismo valor de orden_id
        $existeOrden = AuditoriaFinal::where('id', $idAuditoriaFinal)->first();

        // Si ya existe un registro con el mismo valor de orden_id, puedes mostrar un mensaje de error o tomar alguna otra acción
        if ($existeOrden) {
            $existeOrden->supervisor_corte = $request->input('supervisor_corte');
            $existeOrden->supervisor_linea = $request->input('supervisor_linea');
            $existeOrden->estatus = $request->input('estatus');
            
            $existeOrden->save();
            //dd($existeOrden);
            
            return back()->with('sobre-escribir', 'Actualilzacion realizada con exito');
        }

        return back()->with('success', 'Datos guardados correctamente.')->with('activePage', $activePage);
    }

}
