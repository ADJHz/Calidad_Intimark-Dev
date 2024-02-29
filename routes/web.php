<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\FormulariosCalidadController;
use App\Http\Controllers\ProgresoCorteController;
use App\Http\Controllers\CalidadScreenPrintController;
use App\Http\Controllers\AuditoriaCorteController;
use App\Http\Controllers\EvaluacionCorteController;
use App\Http\Controllers\CalidadProcesoPlancha;
use App\Http\Controllers\InspeccionEstampadoHorno;
use App\Http\Controllers\Maquila;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
	Route::get('table-list', function () {
		return view('pages.table_list');
	})->name('table');

	Route::get('typography', function () {
		return view('pages.typography');
	})->name('typography');

	Route::get('icons', function () {
		return view('pages.icons');
	})->name('icons');

	Route::get('map', function () {
		return view('pages.map');
	})->name('map');

	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');

	Route::get('rtl-support', function () {
		return view('pages.language');
	})->name('language');

	Route::get('upgrade', function () {
		return view('pages.upgrade');
	})->name('upgrade');
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

Route::get('/tipoAuditorias', [UserManagementController::class, 'tipoAuditorias']);
Route::post('/AddUser', [UserManagementController::class, 'AddUser'])->name('user.AddUser');
Route::get('/puestos', [UserManagementController::class, 'puestos']);
Route::post('/editUser', [UserManagementController::class, 'editUser'])->name('users.editUser');

Route::post('/blockUser/{noEmpleado}', [UserManagementController::class, 'blockUser'])->name('blockUser');
Route::put('/blockUser/{noEmpleado}', [UserManagementController::class, 'blockUser'])->name('blockUser');

//ruta para generar archivo pdf
Route::get('/descargar-pdf', [PDFController::class, 'descargarPDF']);
//apartado para el primer formuarlio
Route::get('/auditoriaEtiquetas', [FormulariosCalidadController::class, 'auditoriaEtiquetas'])->name('formulariosCalidad.auditoriaEtiquetas');
Route::get('/auditoriaCortes', [FormulariosCalidadController::class, 'auditoriaCortes'])->name('formulariosCalidad.auditoriaCortes');
Route::get('/auditoriaLimpieza', [FormulariosCalidadController::class, 'auditoriaLimpieza'])->name('formulariosCalidad.auditoriaLimpieza');
Route::get('/evaluacionCorte1', [FormulariosCalidadController::class, 'evaluacionCorte'])->name('formulariosCalidad.evaluacionCorte');
Route::get('/auditoriaFinalAQL', [FormulariosCalidadController::class, 'auditoriaFinalAQL'])->name('formulariosCalidad.auditoriaFinalAQL');
Route::get('/mostrarAuditoriaEtiquetas', [FormulariosCalidadController::class, 'mostrarAuditoriaEtiquetas'])->name('formulariosCalidad.mostrarAuditoriaEtiquetas');
Route::post('/formAuditoriaEtiquetas', [FormulariosCalidadController::class, 'formAuditoriaEtiquetas'])->name('formulariosCalidad.formAuditoriaEtiquetas');
Route::post('/formAuditoriaCortes', [FormulariosCalidadController::class, 'formAuditoriaCortes'])->name('formulariosCalidad.formAuditoriaCortes');
Route::post('/formEvaluacionCorte', [FormulariosCalidadController::class, 'formEvaluacionCorte'])->name('formulariosCalidad.formEvaluacionCorte');
//Apartado para el formulario para mostrar datos filtrados
Route::get('/filtrarDatosEtiquetas', [FormulariosCalidadController::class, 'filtrarDatosEtiquetas'])->name('formulariosCalidad.filtrarDatosEtiquetas');

Route::get('/listaFormularios', [FormulariosCalidadController::class, 'listaFormularios'])->name('listaFormularios');
//aparado para exportar el archivo de excel
Route::get('/exportar-excel', [FormulariosCalidadController::class, 'exportarExcel'])->name('exportar-excel');

Route::get('/controlCalidadEmpaque', [FormulariosCalidadController::class, 'controlCalidadEmpaque'])->name('formulariosCalidad.controlCalidadEmpaque');
Route::post('/formControlCalidadEmpaque', [FormulariosCalidadController::class, 'formControlCalidadEmpaque'])->name('formulariosCalidad.formControlCalidadEmpaque');
Route::get('/ProgresoCorte', [ProgresoCorteController::class, 'ProgresoCorte'])->name('formulariosCalidad.ProgresoCorte');
//Apartado de una nueva seccion para corte, ya que es uno de los mas grandes
Route::get('/inicioAuditoriaCorte', [AuditoriaCorteController::class, 'inicioAuditoriaCorte'])->name('auditoriaCorte.inicioAuditoriaCorte');
Route::post('/formAuditoriaCortes', [AuditoriaCorteController::class, 'formAuditoriaCortes'])->name('auditoriaCorte.formAuditoriaCortes');
Route::get('/auditoriaCorte/{id}/{orden}', [AuditoriaCorteController::class, 'auditoriaCorte'])->name('auditoriaCorte.auditoriaCorte');
Route::get('/altaAuditoriaCorte/{id}/{orden}', [AuditoriaCorteController::class, 'altaAuditoriaCorte'])->name('auditoriaCorte.altaAuditoriaCorte');
Route::post('/formEncabezadoAuditoriaCorte', [AuditoriaCorteController::class, 'formEncabezadoAuditoriaCorte'])->name('auditoriaCorte.formEncabezadoAuditoriaCorte');
Route::post('/formAuditoriaMarcada', [AuditoriaCorteController::class, 'formAuditoriaMarcada'])->name('auditoriaCorte.formAuditoriaMarcada');
Route::post('/formAuditoriaTendido', [AuditoriaCorteController::class, 'formAuditoriaTendido'])->name('auditoriaCorte.formAuditoriaTendido');
Route::post('/formLectra', [AuditoriaCorteController::class, 'formLectra'])->name('auditoriaCorte.formLectra');
Route::post('/formAuditoriaBulto', [AuditoriaCorteController::class, 'formAuditoriaBulto'])->name('auditoriaCorte.formAuditoriaBulto');
Route::post('/formAuditoriaFinal', [AuditoriaCorteController::class, 'formAuditoriaFinal'])->name('auditoriaCorte.formAuditoriaFinal');
//fin aprtado Auditoria Corte

//Inicio apartado para seccion Evaluacion corte
Route::get('/inicioEvaluacionCorte', [EvaluacionCorteController::class, 'inicioEvaluacionCorte'])->name('evaluacionCorte.inicioEvaluacionCorte');
Route::get('/evaluaciondeCorte', [EvaluacionCorteController::class, 'evaluaciondeCorte'])->name('evaluacionCorte.evaluaciondeCorte');
Route::post('/formAuditoriaCortes', [EvaluacionCorteController::class, 'formAuditoriaCortes'])->name('evaluacionCorte.formEvaluacionCortes');
Route::post('/obtener-estilo', [EvaluacionCorteController::class, 'obtenerEstilo'])->name('evaluacionCorte.obtenerEstilo');


//Fin apartado para seccion Evaluacion corte

// Ruta de Screen Print <---Inicio------>
Route::get('/ScreenPrint', [CalidadScreenPrintController::class, 'ScreenPrint'])->name('ScreenPlanta2.ScreenPrint');
Route::get('/Ordenes', [CalidadScreenPrintController::class, 'Ordenes']);
Route::get('/Clientes/{ordenes}', [CalidadScreenPrintController::class, 'Clientes']);
Route::get('/Estilo/{ordenes}', [CalidadScreenPrintController::class, 'Estilos']);
Route::get('/Tecnicos', [CalidadScreenPrintController::class, 'Tecnicos']);
Route::get('/TipoTecnica', [CalidadScreenPrintController::class, 'TipoTecnica']);
Route::post('/AgregarTecnica', [CalidadScreenPrintController::class, 'AgregarTecnica']);
Route::get('/TipoFibra', [CalidadScreenPrintController::class, 'TipoFibra']);
Route::post('/AgregarFibra', [CalidadScreenPrintController::class, 'AgregarFibra']);
Route::get('/viewTabl', [CalidadScreenPrintController::class, 'viewTabl']);
Route::post('/SendScreenPrint', [CalidadScreenPrintController::class, 'SendScreenPrint']);
Route::put('/UpdateScreenPrint/{idValue}', [CalidadScreenPrintController::class, 'UpdateScreenPrint']);
Route::get('/obtenerOpcionesACCorrectiva',[CalidadScreenPrintController::class, 'obtenerOpcionesACCorrectiva']);
Route::get('/obtenerOpcionesTipoProblema', [CalidadScreenPrintController::class, 'obtenerOpcionesTipoProblema']);
Route::get('/OpcionesACCorrectiva',[CalidadScreenPrintController::class, 'OpcionesACCorrectiva']);
Route::get('/OpcionesTipoProblema', [CalidadScreenPrintController::class, 'OpcionesTipoProblema']);
Route::post('/actualizarStatScrin/{id}', [CalidadScreenPrintController::class, 'actualizarStatScrin']);
Route::get('/horno_banda', [CalidadScreenPrintController::class, 'horno_banda']);
Route::post('/savedatahorno_banda', [CalidadScreenPrintController::class, 'savedatahorno_banda']);
Route::get('/PorcenScreen', [CalidadScreenPrintController::class, 'PorcenScreen']);
////// <-------Fin de Screen Print-------------->
// Ruta de Inspeccion Estampado Despues del Horno<-----Inicio------->
Route::get('/InspecciondHorno', [InspeccionEstampadoHorno::class, 'InsEstamHorno'])->name('ScreenPlanta2.InsEstamHorno');
Route::get('/Ordenes', [InspeccionEstampadoHorno::class, 'Ordenes']);
Route::get('/Clientes/{ordenes}', [InspeccionEstampadoHorno::class, 'Clientes']);
Route::get('/Estilo/{ordenes}', [InspeccionEstampadoHorno::class, 'Estilo']);
Route::get('/Tecnicos', [InspeccionEstampadoHorno::class, 'Tecnicos']);
Route::get('/TipoTecnica', [InspeccionEstampadoHorno::class, 'TipoTecnica']);
Route::post('/AgregarTecnica', [InspeccionEstampadoHorno::class, 'AgregarTecnica']);
Route::get('/TipoFibra', [InspeccionEstampadoHorno::class, 'TipoFibra']);
Route::post('/AgregarFibra', [InspeccionEstampadoHorno::class, 'AgregarFibra']);
Route::get('/viewTableIns', [InspeccionEstampadoHorno::class, 'viewTableIns']);
Route::post('/SendInspeccionEstampadoHornot', [InspeccionEstampadoHorno::class, 'SendInspeccionEstampadoHornot']);
Route::put('/UpdateIsnpec/{idValue}', [InspeccionEstampadoHorno::class, 'UpdateIsnpec']);
Route::get('/obtenerOpcionesACCorrectiva',[InspeccionEstampadoHorno::class, 'obtenerOpcionesACCorrectiva']);
Route::get('/obtenerOpcionesTipoProblema', [InspeccionEstampadoHorno::class, 'obtenerOpcionesTipoProblema']);
Route::get('/OpcionesACCorrectiva',[InspeccionEstampadoHorno::class, 'OpcionesACCorrectiva']);
Route::get('/OpcionesTipoProblema', [InspeccionEstampadoHorno::class, 'OpcionesTipoProblema']);
Route::post('/actualizarEstado/{id}', [InspeccionEstampadoHorno::class, 'actualizarEstado']);
Route::get('/PorcenTotalDefec', [InspeccionEstampadoHorno::class, 'PorcenTotalDefec']);
////// <-------Fin de Inspeccion Estampado Despues del Horno-------------->
// Ruta de Calidad Proceso Plancha<-----Inicio------->
Route::get('/ProcesoPlancha', [CalidadProcesoPlancha::class, 'ProcesoPlancha'])->name('ScreenPlanta2.CalidadProcesoPlancha');
Route::get('/Ordenes', [CalidadProcesoPlancha::class, 'Ordenes']);
Route::get('/Clientes/{ordenes}', [CalidadProcesoPlancha::class, 'Clientes']);
Route::get('/Estilo/{ordenes}', [CalidadProcesoPlancha::class, 'Estilo']);
Route::get('/Tecnicos', [CalidadProcesoPlancha::class, 'Tecnicos']);
Route::get('/viewTablePlancha', [CalidadProcesoPlancha::class, 'viewTablePlancha']);
Route::post('/SendPlancha', [CalidadProcesoPlancha::class, 'SendPlancha']);
Route::put('/UpdatePlancha/{idValue}', [CalidadProcesoPlancha::class, 'UpdatePlancha']);
Route::get('/obtenerOpcionesACCorrectiva',[CalidadProcesoPlancha::class, 'obtenerOpcionesACCorrectiva']);
Route::get('/obtenerOpcionesTipoProblema', [CalidadProcesoPlancha::class, 'obtenerOpcionesTipoProblema']);
Route::get('/OpcionesACCorrectiva',[CalidadProcesoPlancha::class, 'OpcionesACCorrectiva']);
Route::get('/OpcionesTipoProblema', [CalidadProcesoPlancha::class, 'OpcionesTipoProblema']);
Route::post('/actualizarEstado/{id}', [CalidadProcesoPlancha::class, 'actualizarEstado']);
Route::get('/PorcenTotalDefecPlancha', [CalidadProcesoPlancha::class, 'PorcenTotalDefecPlancha']);
////// <-------Fin de Calidad Process Plancha-------------->
// Ruta de Maquila<-----Inicio------->
Route::get('/Maquila', [Maquila::class, 'Maquilas'])->name('ScreenPlanta2.Maquila');
Route::get('/Tecnicos', [Maquila::class, 'Tecnicos']);
Route::get('/viewTableMaquila', [Maquila::class, 'viewTableMaquila']);
Route::post('/SendMaquila', [Maquila::class, 'SendMaquila']);
Route::put('/UpdateMaquila/{idValue}', [Maquila::class, 'UpdateMaquila']);
Route::get('/obtenerOpcionesACCorrectiva',[Maquila::class, 'obtenerOpcionesACCorrectiva']);
Route::get('/obtenerOpcionesTipoProblema', [Maquila::class, 'obtenerOpcionesTipoProblema']);
Route::get('/OpcionesACCorrectiva',[Maquila::class, 'OpcionesACCorrectiva']);
Route::get('/OpcionesTipoProblema', [Maquila::class, 'OpcionesTipoProblema']);
Route::post('/actualizarEstado/{id}', [Maquila::class, 'actualizarEstado']);
Route::get('/PorcenTotalDefecMaquila', [Maquila::class, 'PorcenTotalDefecMaquila']);
////// <-------Fin de Maquila-------------->
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']])->middleware('checkrole');
Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit'])->middleware('checkrole');
Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update'])->middleware('checkrole');
Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password'])->middleware('checkrole');
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Route::get('/auditoriaEtiquetas', 'App\Http\Controllers\FormulariosCalidadController@auditoriaEtiquetas')->name('formulariosCalidad.auditoriaEtiquetas')->middleware('checkroleandplant1');
Route::get('/inicioAuditoriaCorte', 'App\Http\Controllers\AuditoriaCorteController@inicioAuditoriaCorte')->name('auditoriaCorte.inicioAuditoriaCorte')->middleware('checkroleandplant1');
Route::get('/evaluacionCorte', 'App\Http\Controllers\FormulariosCalidadController@evaluacionCorte')->name('formulariosCalidad.evaluacionCorte')->middleware('checkroleandplant1');
Route::get('/auditoriaLimpieza', 'App\Http\Controllers\FormulariosCalidadController@auditoriaLimpieza')->name('formulariosCalidad.auditoriaLimpieza')->middleware('checkroleandplant1');
Route::get('/auditoriaFinalAQL', 'App\Http\Controllers\FormulariosCalidadController@auditoriaFinalAQL')->name('formulariosCalidad.auditoriaFinalAQL')->middleware('checkroleandplant1');
Route::get('/controlCalidadEmpaque', 'App\Http\Controllers\FormulariosCalidadController@controlCalidadEmpaque')->name('formulariosCalidad.controlCalidadEmpaque')->middleware('checkroleandplant1');
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Route::get('/ScreenPrint',  [CalidadScreenPrintController::class, 'ScreenPrint'])->name('ScreenPlanta2.ScreenPrint')->middleware('checkroleandplant2');
Route::get('/InsEstamHorno', [InspeccionEstampadoHorno::class, 'InsEstamHorno'])->name('ScreenPlanta2.InsEstamHorno')->middleware('checkroleandplant2');
Route::get('/ProcesoPlancha',  [CalidadProcesoPlancha::class, 'ProcesoPlancha'])->name('ScreenPlanta2.CalidadProcesoPlancha')->middleware('checkroleandplant2');
Route::get('/Maquila',  [Maquila::class, 'Maquilas'])->name('ScreenPlanta2.Maquila')->middleware('checkroleandplant2');
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Route::view('/error', 'error')->name('error');
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


