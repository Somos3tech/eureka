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
/***********************************Reportes***********************************/
/******************************************************************************/
Route::name('reports.')->middleware(['auth'])->prefix('reports')->group(function () {
    Route::get('sales', ['uses' => 'ReportController@sales', 'as' => 'sales'])->middleware(['permission:reports.sales']);

    Route::get('salesExport', ['uses' => 'ReportController@salesExport', 'as' => 'sales.export'])->middleware(['permission:reports.sales']);

    Route::get('conciliation', ['uses' => 'ReportController@conciliation', 'as' => 'conciliation'])->middleware(['permission:reports.conciliation']);

    Route::get('conciliationExport', ['uses' => 'ReportController@conciliationExport', 'as' => 'conciliation.export'])->middleware(['permission:reports.conciliation']);

    Route::get('businessSale', ['uses' => 'ReportController@businessSale', 'as' => 'businesssale'])->middleware(['permission:reports.businesssale']);

    Route::get('businessSaleExport', ['uses' => 'ReportController@businessSaleExport', 'as' => 'businesssale.export'])->middleware(['permission:reports.businesssale']);

    Route::get('store', ['uses' => 'ReportController@store', 'as' => 'store'])->middleware(['permission:reports.store']);

    Route::get('storeExport', ['uses' => 'ReportController@storeExport', 'as' => 'store.export'])->middleware(['permission:reports.store']);

    Route::get('customer', ['uses' => 'ReportController@customer', 'as' => 'customer'])->middleware(['permission:reports.customer']);

    Route::get('customerExport', ['uses' => 'ReportController@customerExport', 'as' => 'customer.export'])->middleware(['permission:reports.customer']);

    Route::get('preafiliation', ['uses' => 'ReportController@preafiliation', 'as' => 'preafiliation'])->middleware(['permission:reports.preafiliation']);

    Route::get('preafiliationExport', ['uses' => 'ReportController@preafiliationExport', 'as' => 'preafiliation.export'])->middleware(['permission:reports.preafiliation']);

    Route::get('office', ['uses' => 'ReportController@office', 'as' => 'office'])->middleware(['permission:reports.office']);

    Route::get('officeExport', ['uses' => 'ReportController@officeExport', 'as' => 'office.export'])->middleware(['permission:reports.office']);

    Route::get('programmer', ['uses' => 'ReportController@programmer', 'as' => 'programmer'])->middleware(['permission:reports.programmer']);

    Route::get('programmerExport', ['uses' => 'ReportController@programmerExport', 'as' => 'programmer.export'])->middleware(['permission:reports.office']);

    Route::get('collection', ['uses' => 'ReportController@collection', 'as' => 'collection'])->middleware(['permission:reports.collection']);

    Route::get('collectionExport', ['uses' => 'ReportController@collectionExport', 'as' => 'collection.export'])->middleware(['permission:reports.collection']);

    Route::get('currencyvalue', ['uses' => 'ReportController@currencyvalue', 'as' => 'currencyvalue'])->middleware(['permission:reports.currencyvalue']);

    Route::get('currencyvalueExport', ['uses' => 'ReportController@currencyvalueExport', 'as' => 'currencyvalue.export'])->middleware(['permission:reports.currencyvalue']);

    Route::get('operation', ['uses' => 'ReportController@operation', 'as' => 'operation'])->middleware(['permission:reports.operation']);

    Route::get('operationExport', ['uses' => 'ReportController@operationExport', 'as' => 'operation.export'])->middleware(['permission:reports.operation']);

    Route::get('atc', ['uses' => 'ReportController@atc', 'as' => 'atc'])->middleware(['permission:reports.atc']);

    Route::get('atcExport', ['uses' => 'ReportController@atcExport', 'as' => 'atc.export'])->middleware(['permission:reports.atc']);
});
