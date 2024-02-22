<?php

// ini_set('memory_limit', '512M');
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your module. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

/***********************************************************************************************************************************/
/***********************************************************Clientes****************************************************************/
/***********************************************************************************************************************************/
Route::name('customers.')->middleware(['auth'])->prefix('customers')->group(function () {
    //Validar Cliente Existe
    Route::get('/', ['uses' => 'CustomerController@index', 'as' => 'index'])->middleware('permission:customers.index');
    //Registrar Cliente
    Route::get('create', ['uses' => 'CustomerController@create', 'as' => 'create'])->middleware('permission:customers.create');
    //Registrar Usuario
    Route::post('store', ['uses' => 'CustomerController@store', 'as' => 'store'])->middleware('permission:customers.create');
    //Formulario de Actualizacion de Cliente
    Route::get('{id}/edit', ['uses' => 'CustomerController@edit', 'as' => 'edit'])->middleware('permission:customers.edit');
    //Actualizar Cliente
    Route::put('{id}', ['uses' => 'CustomerController@update', 'as' => 'update'])->middleware('permission:customers.edit');
    //Listado Cliente
    Route::post('search', ['uses' => 'CustomerController@search', 'as' => 'search'])->middleware('permission:customers.index');
    //Listado Cliente
    Route::get('find', ['uses' => 'CustomerController@find', 'as' => 'find'])->middleware('permission:customers.index');
    //Eliminar con Sofdeleted
    Route::delete('{id}', ['uses' => 'CustomerController@destroy', 'as' => 'destroy'])->middleware('permission:customers.destroy');
    //Api Datatable Busqueda Cliente
    Route::get('datatable', ['uses' => 'CustomerController@datatable', 'as' => 'datatable'])->middleware('permission:customers.index');

    //Api Datatable Busqueda Cliente
    Route::get('validCheckList', ['uses' => 'CustomerController@validCheckList', 'as' => 'datatable.valid.checklist'])->middleware('permission:customers.edit');

    Route::get('datatableCheckList', ['uses' => 'CustomerController@datatableCheckList', 'as' => 'datatable.checklist'])->middleware('permission:customers.edit');

    Route::get('validCheckContract', ['uses' => 'CustomerController@validCheckContract', 'as' => 'datatable.valid.checkcontract'])->middleware('permission:customers.edit');

    Route::get('datatableCheckContract', ['uses' => 'CustomerController@datatableCheckContract', 'as' => 'datatable.checklist'])->middleware('permission:customers.edit');

    Route::get('totalCustomer', ['uses' => 'CustomerController@totalCustomer']);

    Route::post('upload', ['uses' => 'CustomerController@upload', 'as' => 'upload'])->middleware('permission:customers.edit');

    Route::post('checklist', ['uses' => 'CustomerController@checklist', 'as' => 'checklist'])->middleware('permission:customers.edit');

    Route::get('remove', ['uses' => 'CustomerController@remove', 'as' => 'remove'])->middleware('permission:customers.destroy');

    //Ver Información Clientes
    Route::get('{id}', ['uses' => 'CustomerController@show', 'as' => 'show'])->middleware('permission:customers.index');
    //Wrapper Documento cargado del Cliente en PDF
    Route::get('view-document/{path_file}', ['uses' => 'CustomerController@viewDocumentPdf'])->middleware('permission:customers.index');
});

/************************************************************************/
/************************Representante Legal*****************************/
/************************************************************************/
Route::name('rcustomers.')->middleware(['auth'])->prefix('rcustomers')->group(function () {
    //Registrar
    Route::post('store', ['uses' => 'RcustomerController@store', 'as' => 'store'])->middleware('permission:rcustomer.create');
    //Formulario de Actualizacion
    Route::get('{id}/edit', ['uses' => 'RcustomerController@edit', 'as' => 'edit'])->middleware('permission:rcustomer.edit');
    //Actualizar
    Route::put('{id}', ['uses' => 'RcustomerController@update', 'as' => 'update'])->middleware('permission:rcustomer.edit');

    Route::post('upload', ['uses' => 'RcustomerController@upload', 'as' => 'upload'])->middleware('permission:rcustomer.edit');
    //Eliminar con Sofdeleted
    Route::delete('{id}', ['uses' => 'RcustomerController@destroy', 'as' => 'destroy'])->middleware('permission:rcustomer.destroy');
    //Datatable
    Route::get('remove', ['uses' => 'RcustomerController@remove', 'as' => 'remove'])->middleware('permission:rcustomer.edit');

    Route::get('datatable', ['uses' => 'RcustomerController@datatable', 'as' => 'datatable']);
});

/************************************************************************/
/**************************Afiliación Bancaria***************************/
/************************************************************************/
Route::name('dcustomers.')->middleware(['auth'])->prefix('dcustomers')->group(function () {
    //Registrar Usuario
    Route::post('store', ['uses' => 'DcustomerController@store', 'as' => 'store'])->middleware('permission:dcustomer.create');
    //Formulario de Actualizacion
    Route::get('{id}/edit', ['uses' => 'DcustomerController@edit', 'as' => 'edit'])->middleware('permission:dcustomer.edit');
    //Actualizar Cliente
    Route::put('{id}', ['uses' => 'DcustomerController@update', 'as' => 'update'])->middleware('permission:dcustomer.edit');
    //Eliminar con Sofdeleted
    Route::delete('{id}', ['uses' => 'DcustomerController@destroy', 'as' => 'destroy'])->middleware('permission:dcustomer.destroy');
    //Select Asesores Externos Activas
    Route::get('select', ['uses' => 'DcustomerController@select', 'as' => 'select']);
    //Datatable
    //Actualizar Cliente
    Route::get('find', ['uses' => 'DcustomerController@find', 'as' => 'find'])->middleware('permission:dcustomer.index');

    Route::get('datatable', ['uses' => 'DcustomerController@datatable', 'as' => 'datatable']);
});
