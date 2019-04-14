<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/empleados', 'EmployeesController@index');
Route::post('/empleados/registrar', 'EmployeesController@store');
Route::put('/empleados/actualizar', 'EmployeesController@update');
Route::delete('/empleados/eliminar/{id}', 'EmployeesController@delete');
