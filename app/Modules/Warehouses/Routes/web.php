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

Route::name('terminals.')->middleware(['auth'])->prefix('terminals')->group(function () {
    Route::get('/', ['uses' => 'TerminalController@index', 'as' => 'index'])->middleware('permission:terminals.index'); //

    Route::get('create', ['uses' => 'TerminalController@create', 'as' => 'create'])->middleware('permission:terminals.create');

    Route::get('assignCompany', ['uses' => 'TerminalController@assignCompany', 'as' => 'assign.company'])->middleware('permission:terminals.edit');

    Route::get('assign', ['uses' => 'TerminalController@assign', 'as' => 'assign'])->middleware('permission:terminals.edit');

    Route::get('reassign', ['uses' => 'TerminalController@reassign', 'as' => 'reassign'])->middleware('permission:terminals.edit');
    //Guardar Terminales
    Route::post('store', ['uses' => 'TerminalController@store', 'as' => 'store'])->middleware('permission:terminals.create');
    //Guardar Terminales
    Route::post('store-assign', ['uses' => 'TerminalController@assignCompanyStore', 'as' => 'assign.store'])->middleware('permission:terminals.create');
    //Formulario de Actualizacion Terminal
    Route::get('{id}/edit', ['uses' => 'TerminalController@edit', 'as' => 'edit'])->middleware('permission:terminals.edit');
    //Actualizar Terminal
    Route::put('{id}', ['uses' => 'TerminalController@update', 'as' => 'update'])->middleware('permission:terminals.edit');
    //Eliminar con Sofdeleted
    Route::delete('{id}', ['uses' => 'TerminalController@destroy', 'as' => 'destroy'])->middleware('permission:terminals.destroy');
    //Restaurar Simcard
    Route::put('restore/{id}', ['uses' => 'TerminalController@restore', 'as' => 'restore'])->middleware('permission:terminals.edit');
    //Select Available
    Route::get('select/available', ['uses' => 'TerminalController@available', 'as' => 'available']);

    Route::get('totalAvailable', ['uses' => 'TerminalController@totalAvailable', 'as' => 'total.available']);

    Route::get('totalTerminals', ['uses' => 'TerminalController@totalTerminals', 'as' => 'total.store']);
    //Datatable
    Route::get('datatable', ['uses' => 'TerminalController@datatable', 'as' => 'datatable'])->middleware('permission:terminals.index');
});

/**************************************************************************/
/*************************Simcards - Punto de Ventas**********************/
/************************************************************************/

Route::name('simcards.')->middleware(['auth'])->prefix('simcards')->group(function () {
    //Listado Simcard
    Route::get('/', ['uses' => 'SimcardController@index', 'as' => 'index'])->middleware('permission:simcards.index'); //
    //Form Registrar Simcard
    Route::get('create', ['uses' => 'SimcardController@create', 'as' => 'create'])->middleware('permission:simcards.create');

    Route::get('assign', ['uses' => 'SimcardController@assign', 'as' => 'assign'])->middleware('permission:simcards.create');

    Route::get('assignCompany', ['uses' => 'SimcardController@assignCompany', 'as' => 'assign.company'])->middleware('permission:simcards.edit');

    Route::get('reassign', ['uses' => 'SimcardController@reassign', 'as' => 'reassign'])->middleware('permission:simcards.edit');
    //Guardar Simcard
    Route::post('store', ['uses' => 'SimcardController@store', 'as' => 'store'])->middleware('permission:simcards.create');
    //Guardar Terminales
    Route::post('assign-store', ['uses' => 'SimcardController@assignZoneStore', 'as' => 'assign.store'])->middleware('permission:simcards.create');
    //Formulario de Actualizacion Simcard
    Route::get('{id}/edit', ['uses' => 'SimcardController@edit', 'as' => 'edit'])->middleware('permission:simcards.edit');
    //Actualizar Simcard
    Route::put('{id}', ['uses' => 'SimcardController@update', 'as' => 'update'])->middleware('permission:simcards.edit');
    //Eliminar con Sofdeleted
    Route::delete('{id}', ['uses' => 'SimcardController@destroy', 'as' => 'destroy'])->middleware('permission:simcards.destroy');
    //Restaurar Simcard
    Route::put('restore/{id}', ['uses' => 'SimcardController@restore', 'as' => 'restore'])->middleware('permission:simcards.edit');
    //Select Available
    Route::get('select/available', ['uses' => 'SimcardController@available', 'as' => 'available']);
    //Datatable
    Route::get('datatable', ['uses' => 'SimcardController@datatable', 'as' => 'datatable'])->middleware('permission:simcards.index');
});

Route::name('assignments.')->middleware(['auth'])->prefix('assignments')->group(function () {
    Route::post('store', ['uses' => 'AssignmentController@store', 'as' => 'store'])->middleware('permission:assignments.create');

    Route::get('reassign', ['uses' => 'AssignmentController@reassign', 'as' => 'reassign'])->middleware('permission:assignments.edit');

    Route::get('select', ['uses' => 'AssignmentController@select', 'as' => 'select']);

    Route::get('select/assigned', ['uses' => 'AssignmentController@assigned', 'as' => 'assigned']);

    Route::get('select/assignmentUser', ['uses' => 'AssignmentController@assignmentUser', 'as' => 'assignment.user']);

    Route::get('select/assigned-programmer', ['uses' => 'AssignmentController@assignedProgrammer', 'as' => 'assigned.programmer']);
});
