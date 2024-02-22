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
/******************************************************************************/
/*********************************PreAfiliación********************************/
/******************************************************************************/
Route::name('preafiliations.')->middleware(['auth'])->prefix('preafiliations')->group(function () {
    //Datatable
    Route::get('/', ['uses' => 'PreafiliationController@index', 'as' => 'index'])->middleware('permission:preafiliations.index');

    Route::get('valid', ['uses' => 'PreafiliationController@valid', 'as' => 'valid'])->middleware('permission:preafiliations.edit');
    //Registrar
    Route::get('create', ['uses' => 'PreafiliationController@create', 'as' => 'create'])->middleware('permission:preafiliations.create');

    Route::post('store', ['uses' => 'PreafiliationController@store', 'as' => 'store'])->middleware('permission:preafiliations.create');

    Route::get('{id}/edit', ['uses' => 'PreafiliationController@edit', 'as' => 'edit'])->middleware('permission:preafiliations.edit');

    //Carga Documento
    Route::post('tempUpload', ['uses' => 'PreafiliationController@tempUpload', 'as' => 'upload.temp'])->middleware('permission:preafiliations.create');

    Route::post('upload', ['uses' => 'PreafiliationController@upload', 'as' => 'upload'])->middleware('permission:preafiliations.create');

    Route::get('rcustomerDetail', ['uses' => 'PreafiliationController@rcustomerDetail', 'as' => 'rcustomer.detail'])->middleware('permission:preafiliations.index');

    //Actualizar
    Route::put('{id}', ['uses' => 'PreafiliationController@update', 'as' => 'update'])->middleware('permission:preafiliations.edit');

    //Actualizar
    Route::put('validation/{id}', ['uses' => 'PreafiliationController@updateValid', 'as' => 'update.validation'])->middleware('permission:preafiliations.edit');

    //Actualizar
    Route::put('support/{id}', ['uses' => 'PreafiliationController@support', 'as' => 'support'])->middleware('permission:preafiliations.index');

    //Actualizar
    Route::get('datatable', ['uses' => 'PreafiliationController@datatable', 'as' => 'datatable'])->middleware('permission:preafiliations.index');
    Route::get('validDatatable', ['uses' => 'PreafiliationController@validDatatable', 'as' => 'valid.datatable'])->middleware('permission:preafiliations.edit');
    //Wrapper Documento cargado del Cliente en PDF
    Route::get('view-document', ['uses' => 'PreafiliationController@viewDocumentPdf'])->middleware('permission:preafiliations.index');

    Route::get('totalAvailable', ['uses' => 'PreafiliationController@totalAvailable', 'as' => 'total.available']);

    Route::get('getTotal', ['uses' => 'PreafiliationController@getTotal', 'as' => 'total']);

    Route::delete('{id}', ['uses' => 'PreafiliationController@destroy', 'as' => 'destroy'])->middleware('permission:preafiliations.destroy');

    Route::post('remove', ['uses' => 'PreafiliationController@remove', 'as' => 'remove'])->middleware('permission:preafiliations.edit');
    //Datatable
    Route::get('{id}', ['uses' => 'PreafiliationController@show'])->middleware('permission:preafiliations.index');
});
