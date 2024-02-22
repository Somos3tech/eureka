<?php

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

/**************************Ordenes de Servicios**************************/
/************************************************************************/
Route::name('orders.')->middleware(['auth'])->prefix('orders')->group(function () {
    Route::get('/', ['uses' => 'OrderController@index', 'as' => 'index'])->middleware('permission:orders.index');

    Route::get('programmer', ['uses' => 'OrderController@programmer', 'as' => 'programmer'])->middleware('permission:orders.edit');
    Route::get('office', ['uses' => 'OrderController@office', 'as' => 'office'])->middleware('permission:offices.index');

    //Datatable
    Route::get('dataStatus', ['uses' => 'OrderController@dataStatus', 'as' => 'data.status']);
    Route::get('datatable', ['uses' => 'OrderController@datatable', 'as' => 'datatable']);
    Route::get('datatableUser/{id}', ['uses' => 'OrderController@datatableUser', 'as' => 'datatable.user'])->middleware('permission:customers.index');

    Route::get('pdf/{id}', ['uses' => 'OrderController@pdf', 'as' => 'pdf'])->middleware('permission:orders.index');

    //Exportar Reporte Programador
    Route::get('reportProgrammer', ['uses' => 'OrderController@reportProgrammer', 'as' => 'report.programmer'])->middleware('permission:orders.edit');
    //Exportar Reporte Credicard
    Route::get('reportCredicard', ['uses' => 'OrderController@reportCredicard', 'as' => 'report.credicard'])->middleware('permission:orders.edit');
    //Exportar Reporte Credicard
    Route::get('reportPlatco', ['uses' => 'OrderController@reportPlatco', 'as' => 'report.platco'])->middleware('permission:orders.edit');

    //Actualizar Orden de Servcio Parcialmente
    Route::put('service/{id}', ['uses' => 'OrderController@updateService', 'as' => 'service'])->middleware('permission:orders.edit');

    Route::get('posted/{id}/edit', ['uses' => 'OrderController@posted', 'as' => 'posted'])->middleware('permission:offices.edit');

    Route::put('posted/{id}', ['uses' => 'OrderController@managePosted', 'as' => 'manage.posted'])->middleware('permission:offices.edit');
    //Restaurar Servicio
    Route::put('service/restore/{id}', ['uses' => 'OrderController@restoreManagement', 'as' => 'restore.management']);

    //Actualizar Notificación Cambio Rif o No. AFILIACIÓN
    Route::put('service/csupport/{id}', ['uses' => 'OrderController@csupportManagement', 'as' => 'csupport.management']);

    Route::get('totalStatus', ['uses' => 'OrderController@totalStatus', 'as' => 'total.status']);
    //Formulario Asignar Equipo -Simcard

    Route::get('{id}/edit', ['uses' => 'OrderController@edit', 'as' => 'edit'])->middleware('permission:orders.edit');
    Route::put('{id}', ['uses' => 'OrderController@update', 'as' => 'update'])->middleware('permission:orders.edit');

    //Ver Información Orden Servicio
    Route::get('{id}', ['uses' => 'OrderController@show', 'as' => 'show']);
});

Route::name('billings.')->middleware(['auth'])->prefix('billings')->group(function () {
    Route::get('/', ['uses' => 'BillingController@index', 'as' => 'index'])->middleware('permission:billings.index');

    Route::get('datatable', ['uses' => 'BillingController@datatable', 'as' => 'datatable'])->middleware('permission:billings.index');
});

Route::name('billingitems.')->middleware(['auth'])->prefix('billingitems')->group(function () {
    Route::get('/', ['uses' => 'BillingItemController@index', 'as' => 'index'])->middleware('permission:billings.index');
});
