<?php

ini_set('memory_limit', '8192M');
ini_set('post_max_size', '300M');
ini_set('upload_max_filesize', '300M');
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
/********************Contrato de Punto de Venta**************************/
Route::name('contracts.')->middleware(['auth'])->prefix('contracts')->group(function () {
    //Formulario de Verificacion si Existe Nro Afiliacion Cliente para crear Contrato
    Route::get('/', ['uses' => 'ContractController@index', 'as' => 'index'])->middleware('permission:contracts.create');
    //Formulario Crear Contrato Punto de Venta
    Route::get('create', ['uses' => 'ContractController@create', 'as' => 'create'])->middleware('permission:contracts.create');
    //Guardar Cliente
    Route::post('store', ['uses' => 'ContractController@store', 'as' => 'store'])->middleware('permission:contracts.create');
    //Actualizar Role(s)
    Route::post('update', ['uses' => 'ContractController@update', 'as' => 'update'])->middleware('permission:contracts.edit');
    //Formulario Actualizar Usuario
    Route::get('edit', ['uses' => 'ContractController@edit', 'as' => 'edit'])->middleware('permission:contracts.edit');
    //Datatable Información Cliente
    Route::get('datatable', ['uses' => 'ContractController@datatable', 'as' => 'datatable'])->middleware('permission:contracts.index');
    //Datatable Información Cobro
    Route::get('datatableUser/{id}', ['uses' => 'ContractController@datatableUser', 'as' => 'datatable.user'])->middleware('permission:customers.index');
    //Datatable Información Cobro
    Route::get('select', ['uses' => 'ContractController@select', 'as' => 'select']);

    Route::get('documentContract/{id}', ['uses' => 'ContractController@documentContract', 'as' => 'document.contract']);

    Route::get('totalContract', ['uses' => 'ContractController@totalContract', 'as' => 'total']);

    Route::get('find', ['uses' => 'ContractController@find', 'as' => 'find']);

    Route::get('findSupport', ['uses' => 'ContractController@contractSupport', 'as' => 'find.support']);

    Route::get('findContract', ['uses' => 'ContractController@findContract', 'as' => 'find.contract']);

    Route::get('getContractActive', ['uses' => 'ContractController@getContractActive', 'as' => 'getcontract.active'])->middleware('permission:invoices.edit');

    Route::get('getAffiliateActive', ['uses' => 'ContractController@getAffiliateActive', 'as' => 'getaffiliate']);

    Route::get('getAffiliatePending', ['uses' => 'ContractController@getAffiliatePending', 'as' => 'affiliate.pending'])->middleware('permission:adomiciliations.index');
    //Registrar Usuario
});
/*******************************************************************************************************************************************************/
Route::name('invoices.')->middleware(['auth'])->prefix('invoices')->group(function () {
    //Dashboard Cobros Pendientes x Conciliar
    Route::get('/', ['uses' => 'InvoiceController@index', 'as' => 'index'])->middleware('permission:invoices.index');
    Route::get('datatable', ['uses' => 'InvoiceController@datatable', 'as' => 'datatable'])->middleware('permission:invoices.index');
    //Formulario Crear Cobro Punto de Venta
    Route::get('create', ['uses' => 'InvoiceController@create', 'as' => 'create'])->middleware('permission:invoices.create');
    Route::post('store', ['uses' => 'InvoiceController@store', 'as' => 'store'])->middleware('permission:invoices.create');

    Route::get('edit', ['uses' => 'InvoiceController@edit', 'as' => 'edit'])->middleware('permission:invoices.edit');
    Route::put('{id}', ['uses' => 'InvoiceController@update', 'as' => 'update'])->middleware('permission:invoices.edit');
    Route::put('api/{id}', ['uses' => 'InvoiceController@updateApi', 'as' => 'update.api'])->middleware('permission:invoices.edit');
    //Datatable Información Cobro
    Route::get('datatableUser', ['uses' => 'InvoiceController@datatableUser', 'as' => 'datatable.user']);

    Route::get('financing', ['uses' => 'InvoiceController@financing', 'as' => 'financing'])->middleware('permission:invoices.index');
    Route::get('datatableFinancing', ['uses' => 'InvoiceController@datatableFinancing', 'as' => 'datatable.financing'])->middleware('permission:invoices.index');

    Route::get('postpago', ['uses' => 'InvoiceController@postpago', 'as' => 'postpago'])->middleware('permission:invoices.index');

    Route::get('totalInvoice', ['uses' => 'InvoiceController@totalInvoice', 'as' => 'total']);

    Route::get('view-document/{id}', ['uses' => 'InvoiceController@viewDocument', 'as' => 'viewdocument']);
    //Ver Información Cobro
    Route::get('find', ['uses' => 'InvoiceController@find', 'as' => 'find']);

    Route::get('findService', ['uses' => 'InvoiceController@findService', 'as' => 'find.service'])->middleware('permission:services.create');
    //Ver Información Cobro
    Route::get('findInvoiceId', ['uses' => 'InvoiceController@findInvoiceId', 'as' => 'find.invoiceid']);

    Route::get('{id}', ['uses' => 'InvoiceController@show', 'as' => 'show']);
});
/*******************************************************************************************************************************************************/
Route::name('invoiceitems.')->middleware(['auth'])->prefix('invoiceitems')->group(function () {
    Route::get('find', ['uses' => 'InvoiceItemController@find', 'as' => 'find'])->middleware('permission:collections.create');

    Route::get('{id}', ['uses' => 'InvoiceItemController@show', 'as' => 'show'])->middleware('permission:collections.create');
});
/*******************************************************************************************************************************************************/
Route::name('services.')->middleware(['auth'])->prefix('services')->group(function () {
    Route::get('create', ['uses' => 'InvoiceMasiveController@create', 'as' => 'create'])->middleware('permission:services.edit');

    Route::post('store', ['uses' => 'InvoiceMasiveController@serviceStore', 'as' => 'store'])->middleware('permission:services.edit');

    Route::get('getServiceBank', ['uses' => 'InvoiceMasiveController@getServiceBank', 'as' => 'get.bank'])->middleware('permission:services.index');

    Route::get('report', ['uses' => 'InvoiceMasiveController@reportService', 'as' => 'report'])->middleware('permission:services.index');

    Route::get('/', ['uses' => 'InvoiceMasiveController@index', 'as' => 'index'])->middleware('permission:services.index');
    /************************************************************************************************************************************/
    Route::get('affiliate', ['uses' => 'InvoiceMasiveController@affiliate', 'as' => 'affiliate'])->middleware('permission:services.edit');

    Route::post('affiliateStore', ['uses' => 'InvoiceMasiveController@affiliateStore', 'as' => 'affiliate.store'])->middleware('permission:services.edit');

    Route::post('affiliateResponse', ['uses' => 'InvoiceMasiveController@affiliateResponse', 'as' => 'affiliate.response'])->middleware('permission:services.edit');

    Route::get('affiliateResponse', ['uses' => 'InvoiceMasiveController@reportAffiliateResponse', 'as' => 'affiliate.report.response'])->middleware('permission:services.edit');
    /************************************************************************************************************************************/
    Route::get('reportBank', ['uses' => 'InvoiceMasiveController@report', 'as' => 'export.bank'])->middleware('permission:services.index');

    Route::get('downloadBankReport', ['uses' => 'InvoiceMasiveController@downloadBankReport', 'as' => 'report.bank'])->middleware('permission:services.create');
    /************************************************************************************************************************************/
    Route::get('reportInvoiceDetail', ['uses' => 'InvoiceMasiveController@reportInvoiceDetail', 'as' => 'report.invoices.detail'])->middleware('permission:services.index');

    Route::post('downloadInvoiceDetail', ['uses' => 'InvoiceMasiveController@downloadInvoiceDetail', 'as' => 'report.detail'])->middleware('permission:services.create');
    /************************************************************************************************************************************/
    Route::get('datatable', ['uses' => 'InvoiceMasiveController@serviceDatatable', 'as' => 'datatable'])->middleware('permission:services.index');
    /***************************Reportes Cobranza********************************/
    Route::get('financial', ['uses' => 'InvoiceMasiveController@financial', 'as' => 'financial'])->middleware('permission:services.index');
    Route::get('reportFinancial', ['uses' => 'InvoiceMasiveController@reportFinancial', 'as' => 'report.financial'])->middleware('permission:services.index');

    Route::get('bankmovement', ['uses' => 'InvoiceMasiveController@bankmovement', 'as' => 'bankmovement'])->middleware('permission:services.index');
    Route::get('reportBankMovement', ['uses' => 'InvoiceMasiveController@reportBankMovement', 'as' => 'report.bankmovement'])->middleware('permission:services.index');

    Route::get('active', ['uses' => 'InvoiceMasiveController@active', 'as' => 'report.active'])->middleware('permission:services.index');
    Route::post('activeReport', ['uses' => 'InvoiceMasiveController@activeReport', 'as' => 'report.export.active'])->middleware('permission:services.index');

    Route::get('demographic', ['uses' => 'InvoiceMasiveController@demographic', 'as' => 'report.demographic'])->middleware('permission:services.index');
    Route::post('demographicReport', ['uses' => 'InvoiceMasiveController@demographicReport', 'as' => 'report.demographic.export'])->middleware('permission:services.index');

    Route::get('reportAffiliate', ['uses' => 'InvoiceMasiveController@reportAffiliate', 'as' => 'report.affiliate'])->middleware('permission:services.index');

    Route::post('downloadReportAffiliate', ['uses' => 'InvoiceMasiveController@downloadReportAffiliate', 'as' => 'affiliate.report'])->middleware('permission:services.index');
});
/*******************************************************************************************************************************************************/
Route::name('sales.')->middleware(['auth'])->prefix('sales')->group(function () {
    //Formulario de Verificacion si Existe Nro Afiliacion Cliente para crear Contrato
    Route::get('/', ['uses' => 'SaleController@index', 'as' => 'index'])->middleware('permission:sales.create');
    //Formulario Crear Contrato Punto de Venta
    Route::get('create', ['uses' => 'SaleController@create', 'as' => 'create'])->middleware('permission:sales.create');
    //Guardar Cliente
    Route::post('store', ['uses' => 'SaleController@store', 'as' => 'store'])->middleware('permission:sales.create');

    Route::post('upload', ['uses' => 'SaleController@upload', 'as' => 'upload'])->middleware('permission:sales.create');
});
/*******************************************************************************************************************************************************/
Route::name('collections.')->middleware(['auth'])->prefix('collections')->group(function () {
    //Actualizar
    Route::get('create', ['uses' => 'CollectionController@create', 'as' => 'create'])->middleware('permission:collections.create');
    //Guardar Cliente
    Route::post('store', ['uses' => 'CollectionController@store', 'as' => 'store'])->middleware('permission:collections.create');
    //Formulario Crear Contrato Punto de Venta
    Route::get('searchDelete', ['uses' => 'CollectionController@delete', 'as' => 'delete'])->middleware('permission:collections.destroy');

    Route::post('delete', ['uses' => 'CollectionController@destroyCollect', 'as' => 'destroy.collect'])->middleware('permission:collections.destroy');

    Route::post('storeMasive', ['uses' => 'CollectionController@storeMasive', 'as' => 'store.masive'])->middleware('permission:services.create');

    Route::get('serviceMasive', ['uses' => 'CollectionController@serviceMasive', 'as' => 'service.masive'])->middleware('permission:services.create');

    Route::get('reportService', ['uses' => 'CollectionController@reportService', 'as' => 'report.service'])->middleware('permission:operations.create');

    Route::get('reportServiceExport', ['uses' => 'CollectionController@reportServiceExport', 'as' => 'reportservice.export'])->middleware('permission:operations.create');

    Route::get('{id}', ['uses' => 'CollectionController@show', 'as' => 'show']);
});
/*******************************************************************************************************************************************************/
Route::name('operations.')->middleware(['auth'])->prefix('operations')->group(function () {
    //Index
    Route::get('/', ['uses' => 'OperationController@index', 'as' => 'index'])->middleware('permission:operations.index');
    //Download Carga Masiva Entrada
    Route::get('download/cargamasiva', ['uses' => 'OperationController@download', 'as' => 'download'])->middleware('permission:operations.index');

    //Actualizar
    Route::get('create', ['uses' => 'OperationController@create', 'as' => 'create'])->middleware('permission:operations.create');
    //Guardar Cliente
    Route::post('store', ['uses' => 'OperationController@store', 'as' => 'store'])->middleware('permission:operations.create');

    Route::get('masive', ['uses' => 'OperationController@masive', 'as' => 'masive'])->middleware('permission:operations.create');

    Route::post('masiveStore', ['uses' => 'OperationController@masiveStore', 'as' => 'masive.store'])->middleware('permission:operations.create');
    //Guardar Cliente
});
/*******************************************************************************************************************************************************/
Route::name('operterminals.')->middleware(['auth'])->prefix('operterminals')->group(function () {
    Route::get('/', ['uses' => 'OperterminalController@index', 'as' => 'index'])->middleware('permission:operterminals.index');
    //Actualizar
    Route::get('create', ['uses' => 'OperterminalController@create', 'as' => 'create'])->middleware('permission:operterminals.create');
    //Guardar Cliente
    Route::post('store', ['uses' => 'OperterminalController@store', 'as' => 'store'])->middleware('permission:operterminals.create');

    Route::post('reactive/{id}', ['uses' => 'OperterminalController@reactive', 'as' => 'reactive'])->middleware('permission:operterminals.create');

    Route::get('datatable', ['uses' => 'OperterminalController@datatable', 'as' => 'datatable'])->middleware('permission:operterminals.index');

    Route::get('report', ['uses' => 'OperterminalController@report', 'as' => 'report'])->middleware('permission:operterminals.report');

    Route::get('reportExport', ['uses' => 'OperterminalController@reportExport', 'as' => 'report.export'])->middleware('permission:operterminals.create');

    Route::delete('{id}', ['uses' => 'OperterminalController@destroy', 'as' => 'destroy'])->middleware('permission:operterminals.destroy');

    Route::get('{id}', ['uses' => 'OperterminalController@show', 'as' => 'show'])->middleware('permission:operterminals.create');
});
/*******************************************************************************************************************************************************/
Route::name('rcollections.')->middleware(['auth'])->prefix('rcollections')->group(function () {
    Route::get('report', ['uses' => 'RcollectionController@report', 'as' => 'report'])->middleware('permission:rcollections.index');

    Route::post('reportExport', ['uses' => 'RcollectionController@reportExport', 'as' => 'report.export'])->middleware('permission:rcollections.index');
});
/*******************************************************************************************************************************************************/
Route::name('statements.')->middleware(['auth'])->prefix('statements')->group(function () {
    Route::get('/', ['uses' => 'StatementController@index', 'as' => 'index'])->middleware('permission:statements.index');

    Route::get('getTotalServiceCustomer', ['uses' => 'StatementController@getTotalServiceCustomer', 'as' => 'total.service.customer'])->middleware('permission:statements.index');

    Route::get('getTotalServicePending', ['uses' => 'StatementController@getTotalServicePending', 'as' => 'total.service.pending'])->middleware('permission:statements.index');

    Route::get('getBankCustomer', ['uses' => 'StatementController@getBankCustomer', 'as' => 'banks.customer'])->middleware('permission:statements.index');

    Route::get('getBankContractCustomer', ['uses' => 'StatementController@getBankContractCustomer', 'as' => 'banks.contract'])->middleware('permission:statements.index');

    Route::get('datatableBankCustomer', ['uses' => 'StatementController@datatableBankCustomer', 'as' => 'datatable.bank.customer'])->middleware('permission:statements.index');

    Route::get('datatableBankContractCustomer', ['uses' => 'StatementController@datatableBankContractCustomer', 'as' => 'datatable.contracts.customer'])->middleware('permission:statements.index');

    Route::get('detailCustomer', ['uses' => 'StatementController@detailCustomer', 'as' => 'detail.customer'])->middleware('permission:statements.index');

    Route::get('getCustomer', ['uses' => 'StatementController@getCustomer', 'as' => 'customer'])->middleware('permission:statements.index');

    Route::get('getInformationCustomer', ['uses' => 'StatementController@getInformationCustomer', 'as' => 'information.customer'])->middleware('permission:statements.index');

    Route::get('getHistorialManagement', ['uses' => 'StatementController@getHistorialManagement', 'as' => 'historial.management'])->middleware();
    Route::get('getHistorialManagementTest', ['uses' => 'StatementController@getHistorialManagementTest', 'as' => 'historial.management'])->middleware();

    Route::get('getHistorialDomiciliationOperation', ['uses' => 'StatementController@getHistorialDomiciliationOperation', 'as' => 'domiciliation.operation'])->middleware('permission:statements.index');

    Route::get('getHistorialDomiciliationBank', ['uses' => 'StatementController@getHistorialDomiciliationBank', 'as' => 'domiciliation.bank'])->middleware('permission:statements.index');

    Route::get('getHistorialOperterminal', ['uses' => 'StatementController@getHistorialOperterminal', 'as' => 'historial.operterminal'])->middleware('permission:statements.index');

    Route::get('export', ['uses' => 'StatementController@export', 'as' => 'export.pdf'])->middleware('permission:statements.index');
    Route::get('exportExcel', ['uses' => 'StatementController@exportExcel', 'as' => 'export.excel'])->middleware('permission:statements.index');
});
/*******************************************************************************************************************************************************/
Route::name('raffiliates.')->middleware(['auth'])->prefix('raffiliates')->group(function () {
    Route::get('datatable', ['uses' => 'RaffiliateController@datatable', 'as' => 'datatable']);
});
/*******************************************************************************************************************************************************/
Route::name('consecutives.')->middleware(['auth'])->prefix('consecutives')->group(function () {
    Route::get('destroyConsecutiveBank', ['uses' => 'ConsecutiveController@destroyConsecutiveBank', 'as' => 'destroy.bank'])->middleware('permission:services.edit');
});

/*******************************Domiciliación**********************************/
/******************************************************************************/
Route::name('domiciliations.')->middleware(['auth'])->prefix('domiciliations')->group(function () {
    //Listado de Marca
    Route::get('/', ['uses' => 'DomiciliationController@index', 'as' => 'index'])->middleware('permission:domiciliations.index');
    //Registrar
    Route::post('store', ['uses' => 'DomiciliationController@store', 'as' => 'store'])->middleware('permission:domiciliations.create');
    //Datatable
    Route::get('datatable', ['uses' => 'DomiciliationController@datatable', 'as' => 'datatable'])->middleware('permission:domiciliations.index');

    Route::put('send/{id}', ['uses' => 'DomiciliationController@send', 'as' => 'send'])->middleware('permission:domiciliations.create');

    Route::post('upload', ['uses' => 'DomiciliationController@upload', 'as' => 'upload.response'])->middleware('permission:domiciliations.edit');

    Route::get('download/{id}', ['uses' => 'DomiciliationController@download', 'as' => 'download'])->middleware('permission:domiciliations.index');

    Route::get('download/response/{id}', ['uses' => 'DomiciliationController@downloadResponse', 'as' => 'download.response'])->middleware('permission:domiciliations.index');

    Route::get('process/{id}', ['uses' => 'DomiciliationController@process', 'as' => 'process'])->middleware('permission:domiciliations.edit');

    Route::get('{id}/edit', ['uses' => 'DomiciliationController@edit', 'as' => 'edit'])->middleware('permission:domiciliations.edit');
    //Actualizar
    Route::put('{id}', ['uses' => 'DomiciliationController@update', 'as' => 'update'])->middleware('permission:domiciliations.edit');
    //Eliminar con Sofdeleted
    Route::delete('{id}', ['uses' => 'DomiciliationController@destroy', 'as' => 'destroy'])->middleware('permission:domiciliations.destroy');
});

/*********************************Afiliación***********************************/
/******************************************************************************/
Route::name('adomiciliations.')->middleware(['auth'])->prefix('adomiciliations')->group(function () {
    //Listado de Marca
    Route::get('/', ['uses' => 'AdomiciliationController@index', 'as' => 'index'])->middleware('permission:adomiciliations.index');
    //Registrar
    Route::post('store', ['uses' => 'AdomiciliationController@store', 'as' => 'store'])->middleware('permission:adomiciliations.create');
    //Datatable
    Route::get('datatable', ['uses' => 'AdomiciliationController@datatable', 'as' => 'datatable'])->middleware('permission:adomiciliations.index');

    Route::put('send/{id}', ['uses' => 'AdomiciliationController@send', 'as' => 'send'])->middleware('permission:adomiciliations.create');

    Route::post('upload', ['uses' => 'AdomiciliationController@upload', 'as' => 'upload.response'])->middleware('permission:adomiciliations.edit');

    Route::get('download/{id}', ['uses' => 'AdomiciliationController@download', 'as' => 'download'])->middleware('permission:adomiciliations.index');

    Route::get('download/response/{id}', ['uses' => 'AdomiciliationController@downloadResponse', 'as' => 'download.response'])->middleware('permission:adomiciliations.index');

    Route::get('process/{id}', ['uses' => 'AdomiciliationController@process', 'as' => 'process'])->middleware('permission:adomiciliations.edit');

    Route::get('{id}/edit', ['uses' => 'AdomiciliationController@edit', 'as' => 'edit'])->middleware('permission:adomiciliations.edit');
    //Actualizar
    Route::put('{id}', ['uses' => 'AdomiciliationController@update', 'as' => 'update'])->middleware('permission:adomiciliations.edit');
    //Eliminar con Sofdeleted
    Route::delete('{id}', ['uses' => 'AdomiciliationController@destroy', 'as' => 'destroy'])->middleware('permission:adomiciliations.destroy');
});
