<?php

ini_set('memory_limit', '512M');
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
/****************************Soporte Administrativo****************************/
Route::name('csupports.')->middleware(['auth'])->prefix('csupports')->group(function () {
    //Listado de Marca
    Route::get('/', ['uses' => 'CsupportController@index', 'as' => 'index'])->middleware('permission:csupport.index');
    //Registrar
    Route::get('create', ['uses' => 'CsupportController@create', 'as' => 'create'])->middleware('permission:csupport.create');

    Route::post('store', ['uses' => 'CsupportController@store', 'as' => 'store'])->middleware('permission:csupport.create');
    //Formulario Actualizar Marca
    Route::get('{id}/edit', ['uses' => 'CsupportController@edit', 'as' => 'edit'])->middleware('permission:csupport.edit');
    //Actualizar
    Route::put('{id}', ['uses' => 'CsupportController@update', 'as' => 'update'])->middleware('permission:csupport.edit');
    //Eliminar con Sofdeleted
    Route::delete('{id}', ['uses' => 'CsupportController@destroy', 'as' => 'destroy'])->middleware('permission:csupport.destroy');
    //Datatable
    Route::get('datatable', ['uses' => 'CsupportController@datatable', 'as' => 'datatable'])->middleware('permission:csupport.index');
    //Ver Información Cobro
    Route::get('{id}', ['uses' => 'CsupportController@show', 'as' => 'show'])->middleware('permission:csupport.index');
});
/******************************************************************************/
Route::name('serviceSupport.')->middleware(['auth'])->prefix('serviceSupport')->group(function () {
    Route::get('contract', ['uses' => 'SupportServiceController@contract', 'as' => 'contract'])->middleware('permission:supportservice.index');

    Route::get('invoice', ['uses' => 'SupportServiceController@invoice', 'as' => 'invoice'])->middleware('permission:supportservice.index');

    Route::post('store', ['uses' => 'SupportServiceController@store', 'as' => 'store'])->middleware('permission:supportservice.index');

    Route::post('invoice/store', ['uses' => 'SupportServiceController@invoiceStore', 'as' => 'invoice.store'])->middleware('permission:supportservice.index');
});
/******************************************************************************/
Route::name('atcs.')->middleware(['auth'])->prefix('atcs')->group(function () {
    //Listado
    Route::get('/', ['uses' => 'AtcController@index', 'as' => 'index'])->middleware('permission:atcs.index');
    //Listado
    Route::get('internal', ['uses' => 'AtcController@internal', 'as' => 'internal'])->middleware('permission:atcs.atc');
    //Listado
    Route::get('invoice', ['uses' => 'AtcController@invoice', 'as' => 'invoice'])->middleware('permission:atcs.invoice');
    //Listado
    Route::get('sale', ['uses' => 'AtcController@sale', 'as' => 'sale'])->middleware('permission:atcs.sale');
    //Listado
    Route::get('support', ['uses' => 'AtcController@support', 'as' => 'support'])->middleware('permission:atcs.support');
    //Listado
    Route::get('operations', ['uses' => 'AtcController@operations', 'as' => 'operations'])->middleware('permission:atcs.support');
    //Registrar
    Route::get('create', ['uses' => 'AtcController@create', 'as' => 'create'])->middleware('permission:atcs.create');

    Route::get('createInternal', ['uses' => 'AtcController@createInternal', 'as' => 'create.internal'])->middleware('permission:atcs.create');

    Route::post('store', ['uses' => 'AtcController@store', 'as' => 'store'])->middleware('permission:atcs.create');
    //Formulario Actualizar
    Route::get('{id}/edit', ['uses' => 'AtcController@edit', 'as' => 'edit'])->middleware('permission:atcs.edit');
    //Actualizar
    Route::put('{id}', ['uses' => 'AtcController@update', 'as' => 'update'])->middleware('permission:atcs.edit');
    //Eliminar con Sofdeleted
    Route::delete('{id}', ['uses' => 'AtcController@destroy', 'as' => 'destroy'])->middleware('permission:atcs.destroy');
    //Datatable
    Route::get('datatable', ['uses' => 'AtcController@datatable', 'as' => 'datatable'])->middleware('permission:atcs.index');

    Route::get('totalStatus', ['uses' => 'AtcController@totalStatus', 'as' => 'total'])->middleware('permission:atc.index');

    Route::get('{id}', ['uses' => 'AtcController@show', 'as' => 'show'])->middleware('permission:atcmessages.index');
});
/******************************************************************************/
Route::name('channels.')->middleware(['auth'])->prefix('channels')->group(function () {
    //Listado
    Route::get('/', ['uses' => 'ChannelController@index', 'as' => 'index'])->middleware('permission:channels.index');
    //Registrar
    Route::post('store', ['uses' => 'ChannelController@store', 'as' => 'store'])->middleware('permission:channels.create');
    //Formulario Actualizar
    Route::get('{id}/edit', ['uses' => 'ChannelController@edit', 'as' => 'edit'])->middleware('permission:channels.edit');
    //Actualizar
    Route::put('{id}', ['uses' => 'ChannelController@update', 'as' => 'update'])->middleware('permission:channels.edit');
    //Eliminar con Sofdeleted
    Route::delete('{id}', ['uses' => 'ChannelController@destroy', 'as' => 'destroy'])->middleware('permission:channels.destroy');
    //Datatable
    Route::get('datatable', ['uses' => 'ChannelController@datatable', 'as' => 'datatable'])->middleware('permission:channels.index');
    //Api Select
    Route::get('select', ['uses' => 'ChannelController@select', 'as' => 'select']);
});
/******************************************************************************/
Route::name('managementtypes.')->middleware(['auth'])->prefix('managementtypes')->group(function () {
    //Listado
    Route::get('/', ['uses' => 'ManagementtypeController@index', 'as' => 'index'])->middleware('permission:managementtypes.index');
    //Registrar
    Route::post('store', ['uses' => 'ManagementtypeController@store', 'as' => 'store'])->middleware('permission:managementtypes.create');
    //Formulario Actualizar
    Route::get('{id}/edit', ['uses' => 'ManagementtypeController@edit', 'as' => 'edit'])->middleware('permission:managementtypes.edit');
    //Actualizar
    Route::put('{id}', ['uses' => 'ManagementtypeController@update', 'as' => 'update'])->middleware('permission:managementtypes.edit');
    //Eliminar con Sofdeleted
    Route::delete('{id}', ['uses' => 'ManagementtypeController@destroy', 'as' => 'destroy'])->middleware('permission:managementtypes.destroy');
    //Datatable
    Route::get('datatable', ['uses' => 'ManagementtypeController@datatable', 'as' => 'datatable'])->middleware('permission:managementtypes.index');
    //Api Select
    Route::get('select', ['uses' => 'ManagementtypeController@select', 'as' => 'select']);

    Route::get('{id}', ['uses' => 'ManagementtypeController@show', 'as' => 'show'])->middleware('permission:atcs.edit');
});
/******************************************************************************/
Route::name('mtypeitems.')->middleware(['auth'])->prefix('mtypeitems')->group(function () {
    //Listado de Marca
    Route::get('/', ['uses' => 'MtypeitemController@index', 'as' => 'index'])->middleware('permission:mtypeitems.index');
    //Registrar
    Route::post('store', ['uses' => 'MtypeitemController@store', 'as' => 'store'])->middleware('permission:mtypeitems.create');
    //Formulario Actualizar Marca
    Route::get('{id}/edit', ['uses' => 'MtypeitemController@edit', 'as' => 'edit'])->middleware('permission:mtypeitems.edit');
    //Actualizar
    Route::put('{id}', ['uses' => 'MtypeitemController@update', 'as' => 'update'])->middleware('permission:mtypeitems.edit');
    //Eliminar con Sofdeleted
    Route::delete('{id}', ['uses' => 'MtypeitemController@destroy', 'as' => 'destroy'])->middleware('permission:mtypeitems.destroy');
    //Datatable
    Route::get('datatable', ['uses' => 'MtypeitemController@datatable', 'as' => 'datatable'])->middleware('permission:mtypeitems.index');
    //Api Select
    Route::get('select', ['uses' => 'MtypeitemController@select', 'as' => 'select']);
});
/******************************************************************************/
Route::name('atcmessages.')->middleware(['auth'])->prefix('atcmessages')->group(function () {
    Route::post('store', ['uses' => 'AtcmessageController@store', 'as' => 'store'])->middleware('permission:atcmessages.create');

    Route::get('{id}', ['uses' => 'AtcmessageController@show', 'as' => 'show'])->middleware('permission:atcmessages.edit');
});
