<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\FormulariosCalidadController;
use App\Http\Controllers\ProgresoCorteController;
use App\Http\Controllers\CalidadScreenPrintController;
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
Route::get('/evaluacionCorte', [FormulariosCalidadController::class, 'evaluacionCorte'])->name('formulariosCalidad.evaluacionCorte');
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


// Ruta con parámetro de cliente
Route::get('/ScreenPrint', [CalidadScreenPrintController::class, 'ScreenPrint'])->name('ScreenPlanta2.ScreenPrint');
Route::get('/Clientes', [CalidadScreenPrintController::class, 'Clientes']);
Route::get('/Estilo/{cliente}', [CalidadScreenPrintController::class, 'Estilos']);
Route::get('/Ordenes/{estilo}', [CalidadScreenPrintController::class, 'Ordenes']);
Route::get('/Tecnicos', [CalidadScreenPrintController::class, 'Tecnicos']);
Route::get('/TipoTecnica', [CalidadScreenPrintController::class, 'TipoTecnica']);

Route::post('/AgregarTecnica', [CalidadScreenPrintController::class, 'AgregarTecnica']);

Route::get('/TipoFibra', [CalidadScreenPrintController::class, 'TipoFibra']);

Route::post('/AgregarFibra', [CalidadScreenPrintController::class, 'AgregarFibra']);



Route::get('/viewTable', [CalidadScreenPrintController::class, 'viewTable']);

Route::post('/SendScreenPrint', [CalidadScreenPrintController::class, 'SendScreenPrint']);
Route::put('/UpdateScreenPrint/{id}', [CalidadScreenPrintController::class, 'UpdateScreenPrint']);

