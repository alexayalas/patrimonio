<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'AuthenticateController@login');

// Routes

Route::middleware(['auth'])->group(function(){
    Route::post('logout', 'AuthenticateController@logout'); 
    Route::post('/users/changepassword', 'UserController@changePassword'); 
    // Areas
    Route::resource('areas','AreaController');
    // bajas
    Route::resource('bajas','BajaController'); 
    // Bienes
    Route::resource('bienes','BienController');
    // Clases
    Route::resource('clases','ClaseController'); 
    // Cuentas
    Route::resource('cuentas','CuentaController');  
    // Documentos
    Route::resource('documentos','DocumentoController');  
    // Empleados
    Route::resource('empleados','EmpleadoController');   
    // Empresas
    Route::resource('empresas','EmpresaController'); 
    // Sedes
    Route::resource('sedes','SedeController');     
    // Grupos
    Route::resource('grupos','GrupoController');
    // Mantenimientos
    Route::resource('mantenimientos','MantenimientoController');  
    // Proveedores
    Route::resource('proveedores','ProveedorController'); 
    // TipoIngresos
    Route::resource('tipoingresos','TipoingresoController');  
    // Traslados
    Route::resource('traslados','TrasladoController'); 
    // Ubicaciones
    Route::resource('ubicaciones','UbicacionController');                                        
    // Roles
    Route::resource('roles','RoleController'); 
    // Usuarios
    Route::resource('users','UserController');
    // Garantias
    Route::resource('garantias','GarantiaController');    
    
});
