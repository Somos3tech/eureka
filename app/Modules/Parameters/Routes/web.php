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

/*******************************Conceptos Contables****************************/
/******************************************************************************/
Route::name('acconcepts.')->middleware(['auth'])->prefix('acconcepts')->group(function () {
    //Listado de Categoria Contable
    Route::get('/', ['uses' => 'AcconceptController@index', 'as' => 'index'])->middleware('permission:acconcepts.index');
    //Registrar
    Route::post('store', ['uses' => 'AcconceptController@store', 'as' => 'store'])->middleware('permission:acconcepts.create');
    //Formulario Actualizar Categoria Contable
    Route::get('{id}/edit', ['uses' => 'AcconceptController@edit', 'as' => 'edit'])->middleware('permission:acconcepts.edit');
    //Actualizar
    Route::put('{id}', ['uses' => 'AcconceptController@update', 'as' => 'update'])->middleware('permission:acconcepts.edit');
    //Eliminar con Sofdeleted
    Route::delete('{id}', ['uses' => 'AcconceptController@destroy', 'as' => 'destroy'])->middleware('permission:acconcepts.destroy');
    //Datatable
    Route::get('datatable', ['uses' => 'AcconceptController@datatable', 'as' => 'datatable'])->middleware('permission:acconcepts.index');
    //Api Select
    Route::get('select', ['uses' => 'AcconceptController@select', 'as' => 'select']);
});

/*******************************Tipo Almacén***********************************/
/******************************************************************************/
Route::name('typecompanies.')->middleware(['auth'])->prefix('typecompanies')->group(function () {
    //Listado de Marca
    Route::get('/', ['uses' => 'TypeCompanyController@index', 'as' => 'index'])->middleware('permission:typecompanies.index');
    //Registrar
    Route::post('store', ['uses' => 'TypeCompanyController@store', 'as' => 'store'])->middleware('permission:typecompanies.create');
    //Formulario Actualizar Marca
    Route::get('{id}/edit', ['uses' => 'TypeCompanyController@edit', 'as' => 'edit'])->middleware('permission:typecompanies.edit');
    //Actualizar
    Route::put('{id}', ['uses' => 'TypeCompanyController@update', 'as' => 'update'])->middleware('permission:typecompanies.edit');
    //Eliminar con Sofdeleted
    Route::delete('{id}', ['uses' => 'TypeCompanyController@destroy', 'as' => 'destroy'])->middleware('permission:typecompanies.destroy');
    //Datatable
    Route::get('datatable', ['uses' => 'TypeCompanyController@datatable', 'as' => 'datatable'])->middleware('permission:typecompanies.index');
    //Api Select
    Route::get('select', ['uses' => 'TypeCompanyController@select', 'as' => 'select']);
});

/*************************************Zonas************************************/
/******************************************************************************/
Route::name('companies.')->middleware(['auth'])->prefix('companies')->group(function () {
    //Listado de Zonas
    Route::get('/', ['uses' => 'CompanyController@index', 'as' => 'index'])->middleware('permission:company.index');
    //Registrar
    Route::post('store', ['uses' => 'CompanyController@store', 'as' => 'store'])->middleware('permission:company.create');
    //Formulario Actualizar Zonas
    Route::get('{id}/edit', ['uses' => 'CompanyController@edit', 'as' => 'edit'])->middleware('permission:company.edit');
    //Actualizar
    Route::put('{id}', ['uses' => 'CompanyController@update', 'as' => 'update'])->middleware('permission:company.edit');
    //Eliminar con Sofdeleted
    Route::delete('{id}', ['uses' => 'CompanyController@destroy', 'as' => 'destroy'])->middleware('permission:company.destroy');
    //Datatable
    Route::get('datatable', ['uses' => 'CompanyController@datatable', 'as' => 'datatable'])->middleware('permission:company.index');
    //Api Select
    Route::get('select', ['uses' => 'CompanyController@select', 'as' => 'select']);
    //Api Select Validar Admin Zone
    Route::get('select/zone-valid', ['uses' => 'CompanyController@zoneValid', 'as' => 'zone-valid']);
});

/******************************************************************************/
/**************************************Banco***********************************/
/******************************************************************************/
Route::name('banks.')->middleware(['auth'])->prefix('banks')->group(function () {
    //Listado de Bancos
    Route::get('/', ['uses' => 'BankController@index', 'as' => 'index'])->middleware('permission:banks.index');
    //Registrar
    Route::post('store', ['uses' => 'BankController@store', 'as' => 'store'])->middleware('permission:banks.create');
    //Formulario Actualizar Banco
    Route::get('{id}/edit', ['uses' => 'BankController@edit', 'as' => 'edit'])->middleware('permission:banks.edit');
    //Actualizar
    Route::put('{id}', ['uses' => 'BankController@update', 'as' => 'update'])->middleware('permission:banks.edit');
    //Eliminar con Sofdeleted
    Route::delete('{id}', ['uses' => 'BankController@destroy', 'as' => 'destroy'])->middleware('permission:banks.destroy');
    //Datatable
    Route::get('datatable', ['uses' => 'BankController@datatable', 'as' => 'datatable'])->middleware('permission:banks.index');
    //Api Select
    Route::get('select', ['uses' => 'BankController@select', 'as' => 'select']);
    //Api Bank Code
    Route::get('bankcode', ['uses' => 'BankController@bankCode', 'as' => 'bankcode']);
});

/**********************************Marca***************************************/
/******************************************************************************/
Route::name('marks.')->middleware(['auth'])->prefix('marks')->group(function () {
    //Listado de Marca
    Route::get('/', ['uses' => 'MarkController@index', 'as' => 'index'])->middleware('permission:marks.index');
    //Registrar
    Route::post('store', ['uses' => 'MarkController@store', 'as' => 'store'])->middleware('permission:marks.create');
    //Formulario Actualizar Marca
    Route::get('{id}/edit', ['uses' => 'MarkController@edit', 'as' => 'edit'])->middleware('permission:marks.edit');
    //Actualizar
    Route::put('{id}', ['uses' => 'MarkController@update', 'as' => 'update'])->middleware('permission:marks.edit');
    //Eliminar con Sofdeleted
    Route::delete('{id}', ['uses' => 'MarkController@destroy', 'as' => 'destroy'])->middleware('permission:marks.destroy');
    //Datatable
    Route::get('datatable', ['uses' => 'MarkController@datatable', 'as' => 'datatable'])->middleware('permission:marks.index');
    //Api Select
    Route::get('select', ['uses' => 'MarkController@select', 'as' => 'select']);
});

/******************************Tipificación Venta******************************/
/******************************************************************************/
Route::name('concepts.')->middleware(['auth'])->prefix('concepts')->group(function () {
    //Listado de Tipificación Venta
    Route::get('/', ['uses' => 'ConceptController@index', 'as' => 'index'])->middleware('permission:concept.index');
    //Registrar
    Route::post('store', ['uses' => 'ConceptController@store', 'as' => 'store'])->middleware('permission:concept.create');
    //Formulario Actualizar Tipificación Venta
    Route::get('{id}/edit', ['uses' => 'ConceptController@edit', 'as' => 'edit'])->middleware('permission:concept.edit');
    //Actualizar
    Route::put('{id}', ['uses' => 'ConceptController@update', 'as' => 'update'])->middleware('permission:concept.edit');
    //Eliminar con Sofdeleted
    Route::delete('{id}', ['uses' => 'ConceptController@destroy', 'as' => 'destroy'])->middleware('permission:concept.destroy');
    //Datatable
    Route::get('datatable', ['uses' => 'ConceptController@datatable', 'as' => 'datatable'])->middleware('permission:concept.index');
    //Api Select
    Route::get('select', ['uses' => 'ConceptController@select', 'as' => 'select']);
});

/***********************************Operador***********************************/
/******************************************************************************/
Route::name('operators.')->middleware(['auth'])->prefix('operators')->group(function () {
    //Listado de Operador
    Route::get('/', ['uses' => 'OperatorController@index', 'as' => 'index'])->middleware('permission:operators.index');
    //Registrar
    Route::post('store', ['uses' => 'OperatorController@store', 'as' => 'store'])->middleware('permission:operators.create');
    //Formulario Actualizar Operador
    Route::get('{id}/edit', ['uses' => 'OperatorController@edit', 'as' => 'edit'])->middleware('permission:operators.edit');
    //Actualizar
    Route::put('{id}', ['uses' => 'OperatorController@update', 'as' => 'update'])->middleware('permission:operators.edit');
    //Eliminar con Sofdeleted
    Route::delete('{id}', ['uses' => 'OperatorController@destroy', 'as' => 'destroy'])->middleware('permission:operators.destroy');
    //Datatable
    Route::get('datatable', ['uses' => 'OperatorController@datatable', 'as' => 'datatable'])->middleware('permission:operators.index');
    //Api Select
    Route::get('select', ['uses' => 'OperatorController@select', 'as' => 'select']);
});

/************************************APN***************************************/
/******************************************************************************/
Route::name('apn.')->middleware(['auth'])->prefix('apn')->group(function () {
    //Listado de APN
    Route::get('/', ['uses' => 'ApnController@index', 'as' => 'index'])->middleware('permission:apn.index');
    //Registrar
    Route::post('store', ['uses' => 'ApnController@store', 'as' => 'store'])->middleware('permission:apn.create');
    //Formulario Actualizar APN
    Route::get('{id}/edit', ['uses' => 'ApnController@edit', 'as' => 'edit'])->middleware('permission:apn.edit');
    //Actualizar
    Route::put('{id}', ['uses' => 'ApnController@update', 'as' => 'update'])->middleware('permission:apn.edit');
    //Eliminar con Sofdeleted
    Route::delete('{id}', ['uses' => 'ApnController@destroy', 'as' => 'destroy'])->middleware('permission:apn.destroy');
    //Datatable
    Route::get('datatable', ['uses' => 'ApnController@datatable', 'as' => 'datatable'])->middleware('permission:apn.index');
    //Api Select
    Route::get('select', ['uses' => 'ApnController@select', 'as' => 'select']);
});

/*******************************Comisión Servicios*****************************/
/******************************************************************************/
Route::name('comissions.')->middleware(['auth'])->prefix('comissions')->group(function () {
    //Listado de Comisión Servicio
    Route::get('/', ['uses' => 'ComissionController@index', 'as' => 'index'])->middleware('permission:comissions.index');
    //Registrar
    Route::post('store', ['uses' => 'ComissionController@store', 'as' => 'store'])->middleware('permission:comissions.create');
    //Formulario Actualizar Compañia
    //Route::get('{id}/edit',['uses' => 'ComissionController@edit', 'as' => 'edit'])->middleware('permission:comissions.edit');
    //Actualizar
    //Route::put('{id}',['uses' => 'ComissionController@update', 'as' => 'update'])->middleware('permission:comissions.edit');
    //Eliminar con Sofdeleted
    Route::delete('{id}', ['uses' => 'ComissionController@destroy', 'as' => 'destroy'])->middleware('permission:comissions.destroy');
    //Datatable
    Route::get('datatable', ['uses' => 'ComissionController@datatable', 'as' => 'datatable'])->middleware('permission:comissions.index');

    Route::get('select', ['uses' => 'ComissionController@select', 'as' => 'select']);

    Route::get('{id}', ['uses' => 'ComissionController@show', 'as' => 'show'])->middleware('permission:comissions.index');
});

/*******************************Nueva Comisión Servicios*****************************/
/******************************************************************************/
Route::name('commissions.')->middleware(['auth'])->prefix('commissions')->group(function () {
    //Listado de Comisión Servicio
    Route::get('/', ['uses' => 'CommissionController@index', 'as' => 'index'])->middleware('permission:commissions.index');
    //Registrar
    Route::post('store', ['uses' => 'CommissionController@store', 'as' => 'store'])->middleware('permission:commissions.create');
    //Formulario Actualizar Compañia
    //Route::get('{id}/edit',['uses' => 'CommissionController@edit', 'as' => 'edit'])->middleware('permission:commissions.edit');
    //Actualizar
    //Route::put('{id}',['uses' => 'CommissionController@update', 'as' => 'update'])->middleware('permission:commissions.edit');
    //Eliminar con Sofdeleted
    Route::delete('{id}', ['uses' => 'CommissionController@destroy', 'as' => 'destroy'])->middleware('permission:commissions.destroy');
    //Datatable
    Route::get('datatable', ['uses' => 'CommissionController@datatable', 'as' => 'datatable'])->middleware('permission:commissions.index');

    Route::get('select', ['uses' => 'CommissionController@select', 'as' => 'select']);

    Route::get('{id}', ['uses' => 'CommissionController@show', 'as' => 'show'])->middleware('permission:commissions.index');
});

/********************************Modelo Terminal*******************************/
/******************************************************************************/
Route::name('mterminals.')->middleware(['auth'])->prefix('mterminals')->group(function () {
    //Listado de Compañia
    Route::get('/', ['uses' => 'MterminalController@index', 'as' => 'index'])->middleware('permission:mterminal.index');
    //Registrar
    Route::post('store', ['uses' => 'MterminalController@store', 'as' => 'store'])->middleware('permission:mterminal.create');
    //Formulario Actualizar Compañia
    Route::get('{id}/edit', ['uses' => 'MterminalController@edit', 'as' => 'edit'])->middleware('permission:mterminal.edit');
    //Actualizar
    Route::put('{id}', ['uses' => 'MterminalController@update', 'as' => 'update'])->middleware('permission:mterminal.edit');
    //Eliminar con Sofdeleted
    Route::delete('{id}', ['uses' => 'MterminalController@destroy', 'as' => 'destroy'])->middleware('permission:mterminal.destroy');
    //Datatable
    Route::get('datatable', ['uses' => 'MterminalController@datatable', 'as' => 'datatable'])->middleware('permission:mterminal.index');
    //Api Select
    Route::get('select', ['uses' => 'MterminalController@select', 'as' => 'select']);
});

/**************************Condiciones Comerciales*****************************/
/******************************************************************************/
Route::name('terms.')->middleware(['auth'])->prefix('terms')->group(function () {
    //Listado de Condiciones Comerciales
    Route::get('/', ['uses' => 'TermController@index', 'as' => 'index'])->middleware('permission:terms.index');
    //Guardar Condiciones Comerciales
    Route::post('store', ['uses' => 'TermController@store', 'as' => 'store'])->middleware('permission:terms.create');
    //Formulario Actualizar Condiciones Comerciales
    Route::get('{id}/edit', ['uses' => 'TermController@edit', 'as' => 'edit'])->middleware('permission:terms.edit');
    //Actualizar Condiciones Comerciales
    Route::put('{id}', ['uses' => 'TermController@update', 'as' => 'update'])->middleware('permission:terms.edit');
    //Eliminar con Sofdeleted la Condicion Comercial
    Route::delete('{id}', ['uses' => 'TermController@destroy', 'as' => 'destroy'])->middleware('permission:terms.destroy');
    //Datatable
    Route::get('datatable', ['uses' => 'TermController@datatable', 'as' => 'datatable'])->middleware('permission:terms.index');
    //Select Comisiones Activas
    Route::get('select', ['uses' => 'TermController@select', 'as' => 'select']);
    //Ver Informacion de Condiciones Comerciales
    Route::get('{id}', ['uses' => 'TermController@show', 'as' => 'show']);
});

/*****************************Aliados Comerciales******************************/
/******************************************************************************/
Route::name('consultants.')->middleware(['auth'])->prefix('consultants')->group(function () {
    //Listado de Condiciones Comerciales
    Route::get('/', ['uses' => 'ConsultantController@index', 'as' => 'index'])->middleware('permission:consultants.index');
    //Guardar Condiciones Comerciales
    Route::post('store', ['uses' => 'ConsultantController@store', 'as' => 'store'])->middleware('permission:consultants.create');
    //Formulario Actualizar Condiciones Comerciales
    Route::get('{id}/edit', ['uses' => 'ConsultantController@edit', 'as' => 'edit'])->middleware('permission:consultants.edit');
    //Actualizar Condiciones Comerciales
    Route::put('{id}', ['uses' => 'ConsultantController@update', 'as' => 'update'])->middleware('permission:consultants.edit');
    //Eliminar con Sofdeleted la Condicion Comercial
    Route::delete('{id}', ['uses' => 'ConsultantController@destroy', 'as' => 'destroy'])->middleware('permission:consultants.destroy');
    //Datatable
    Route::get('datatable', ['uses' => 'ConsultantController@datatable', 'as' => 'datatable'])->middleware('permission:consultants.index');
    //Select Asesores Externos Activas
    Route::get('select', ['uses' => 'ConsultantController@select', 'as' => 'select']);
});

/*************************************Divisas**********************************/
/******************************************************************************/
Route::name('currencies.')->middleware(['auth'])->prefix('currencies')->group(function () {
    //Listado de Divisas
    Route::get('/', ['uses' => 'CurrencyController@index', 'as' => 'index'])->middleware('permission:currency.index');
    //Registrar
    Route::post('store', ['uses' => 'CurrencyController@store', 'as' => 'store'])->middleware('permission:currency.create');
    //Formulario Actualizar Divisa
    Route::get('{id}/edit', ['uses' => 'CurrencyController@edit', 'as' => 'edit'])->middleware('permission:currency.edit');
    //Actualizar
    Route::put('{id}', ['uses' => 'CurrencyController@update', 'as' => 'update'])->middleware('permission:currency.edit');
    //Eliminar con Sofdeleted
    Route::delete('{id}', ['uses' => 'CurrencyController@destroy', 'as' => 'destroy'])->middleware('permission:currency.destroy');
    //Datatable
    Route::get('datatable', ['uses' => 'CurrencyController@datatable', 'as' => 'datatable'])->middleware('permission:currency.index');
    //Api Select
    Route::get('select', ['uses' => 'CurrencyController@select', 'as' => 'select']);

    Route::get('find', ['uses' => 'CurrencyController@find', 'as' => 'find']);
});

/*******************************Valor Divisas**********************************/
/******************************************************************************/
Route::name('currencyvalues.')->middleware(['auth'])->prefix('currencyvalues')->group(function () {
    //Listado de Valor Divisas
    Route::get('/', ['uses' => 'CurrencyValueController@index', 'as' => 'index'])->middleware('permission:currencyvalues.index');
    //Registrar
    Route::post('store', ['uses' => 'CurrencyValueController@store', 'as' => 'store'])->middleware('permission:currencyvalues.create');
    //Formulario Actualizar Valor Divisa
    Route::get('{id}/edit', ['uses' => 'CurrencyValueController@edit', 'as' => 'edit'])->middleware('permission:currencyvalues.edit');
    //Actualizar
    Route::put('{id}', ['uses' => 'CurrencyValueController@update', 'as' => 'update'])->middleware('permission:currencyvalues.edit');
    //Eliminar con Sofdeleted
    Route::delete('{id}', ['uses' => 'CurrencyValueController@destroy', 'as' => 'destroy'])->middleware('permission:currencyvalues.destroy');
    //Datatable
    Route::get('datatable', ['uses' => 'CurrencyValueController@datatable', 'as' => 'datatable'])->middleware('permission:currencyvalues.index');
    //Selcct
    Route::get('valueDycon', ['uses' => 'CurrencyValueController@valueDycon', 'as' => 'valueDycon']);
    //último registro de Valor Dicom
    Route::get('getLast', ['uses' => 'CurrencyValueController@getLast', 'as' => 'getlast']);
    //Api Select
    Route::get('getCurrencyValue', ['uses' => 'CurrencyValueController@getCurrencyValue', 'as' => 'getcurrencyvalue']);
});

/*******************************Valor Terminal*********************************/
/******************************************************************************/
Route::name('terminalvalues.')->middleware(['auth'])->prefix('terminalvalues')->group(function () {
    //Listado de Valor Terminal
    Route::get('/', ['uses' => 'TerminalValueController@index', 'as' => 'index'])->middleware('permission:terminalvalues.index');
    //Registrar
    Route::post('store', ['uses' => 'TerminalValueController@store', 'as' => 'store'])->middleware('permission:terminalvalues.create');
    //Formulario Actualizar Valor Terminal
    Route::get('{id}/edit', ['uses' => 'TerminalValueController@edit', 'as' => 'edit'])->middleware('permission:terminalvalues.edit');
    //Actualizar
    Route::put('{id}', ['uses' => 'TerminalValueController@update', 'as' => 'update'])->middleware('permission:terminalvalues.edit');
    //Eliminar con Sofdeleted
    Route::delete('{id}', ['uses' => 'TerminalValueController@destroy', 'as' => 'destroy'])->middleware('permission:terminalvalues.destroy');
    //Datatable
    Route::get('datatable', ['uses' => 'TerminalValueController@datatable', 'as' => 'datatable'])->middleware('permission:terminalvalues.index');

    Route::get('get-amount', ['uses' => 'TerminalValueController@getAmount', 'as' => 'getAmount']);

    Route::get('getLast', ['uses' => 'TerminalValueController@getLast', 'as' => 'getLast']);
});

/******************************Métodos de Pago*********************************/
/******************************************************************************/
Route::name('pmethods.')->middleware(['auth'])->prefix('pmethods')->group(function () {
    //Listado de Marca
    Route::get('/', ['uses' => 'PmethodController@index', 'as' => 'index'])->middleware('permission:pmethods.index');
    //Registrar
    Route::post('store', ['uses' => 'PmethodController@store', 'as' => 'store'])->middleware('permission:pmethods.create');
    //Formulario Actualizar Marca
    Route::get('{id}/edit', ['uses' => 'PmethodController@edit', 'as' => 'edit'])->middleware('permission:pmethods.edit');
    //Actualizar
    Route::put('{id}', ['uses' => 'PmethodController@update', 'as' => 'update'])->middleware('permission:pmethods.edit');
    //Eliminar con Sofdeleted
    Route::delete('{id}', ['uses' => 'PmethodController@destroy', 'as' => 'destroy'])->middleware('permission:pmethods.destroy');
    //Datatable
    Route::get('datatable', ['uses' => 'PmethodController@datatable', 'as' => 'datatable'])->middleware('permission:pmethods.index');
    //Api Select
    Route::get('select', ['uses' => 'PmethodController@select', 'as' => 'select']);
});

/****************************Empresa(Business)*********************************/
/******************************************************************************/
Route::name('business.')->middleware(['auth'])->prefix('business')->group(function () {
    //Listado de APN
    Route::get('/', ['uses' => 'BusinessController@index', 'as' => 'index'])->middleware('permission:business.index');
    //Registrar
    Route::post('store', ['uses' => 'BusinessController@store', 'as' => 'store'])->middleware('permission:business.create');
    //Formulario Actualizar APN
    Route::get('{id}/edit', ['uses' => 'BusinessController@edit', 'as' => 'edit'])->middleware('permission:business.edit');
    //Actualizar
    Route::put('{id}', ['uses' => 'BusinessController@update', 'as' => 'update'])->middleware('permission:business.edit');
    //Eliminar con Sofdeleted
    Route::delete('{id}', ['uses' => 'BusinessController@destroy', 'as' => 'destroy'])->middleware('permission:business.destroy');
    //Datatable
    Route::get('datatable', ['uses' => 'BusinessController@datatable', 'as' => 'datatable'])->middleware('permission:business.index');
    //Api Select
    Route::get('select', ['uses' => 'BusinessController@select', 'as' => 'select']);
});

/*****************************Tipificación Soporte*****************************/
/******************************************************************************/
Route::name('tipifications.')->middleware(['auth'])->prefix('tipifications')->group(function () {
    //Listado de Marca
    Route::get('/', ['uses' => 'TipificationController@index', 'as' => 'index'])->middleware('permission:tipifications.index');
    //Registrar
    Route::post('store', ['uses' => 'TipificationController@store', 'as' => 'store'])->middleware('permission:tipifications.create');
    //Formulario Actualizar Marca
    Route::get('{id}/edit', ['uses' => 'TipificationController@edit', 'as' => 'edit'])->middleware('permission:tipifications.edit');
    //Actualizar
    Route::put('{id}', ['uses' => 'TipificationController@update', 'as' => 'update'])->middleware('permission:tipifications.edit');
    //Eliminar con Sofdeleted
    Route::delete('{id}', ['uses' => 'TipificationController@destroy', 'as' => 'destroy'])->middleware('permission:tipifications.destroy');
    //Datatable
    Route::get('datatable', ['uses' => 'TipificationController@datatable', 'as' => 'datatable'])->middleware('permission:tipifications.index');
    //Api Select
    Route::get('select', ['uses' => 'TipificationController@select', 'as' => 'select']);
});

/*****************************Tipificación Soporte*****************************/
/******************************************************************************/
Route::name('zoneroles.')->middleware(['auth'])->prefix('zoneroles')->group(function () {
    //Listado de Marca
    Route::get('/', ['uses' => 'ZoneRoleController@index', 'as' => 'index'])->middleware('permission:zonerole.index');
    //Registrar
    Route::post('store', ['uses' => 'ZoneRoleController@store', 'as' => 'store'])->middleware('permission:zonerole.create');
    //Formulario Actualizar Marca
    Route::get('{id}/edit', ['uses' => 'ZoneRoleController@edit', 'as' => 'edit'])->middleware('permission:zonerole.edit');
    //Actualizar
    Route::put('{id}', ['uses' => 'ZoneRoleController@update', 'as' => 'update'])->middleware('permission:zonerole.edit');
    //Eliminar con Sofdeleted
    Route::delete('{id}', ['uses' => 'ZoneRoleController@destroy', 'as' => 'destroy'])->middleware('permission:zonerole.destroy');
    //Datatable
    Route::get('datatable', ['uses' => 'ZoneRoleController@datatable', 'as' => 'datatable'])->middleware('permission:zonerole.index');
    //Api Valid Role(s)
    Route::get('valid-company', ['uses' => 'ZoneRoleController@validCompany', 'as' => 'valid-company']);
});

/*******************************Tipo Almacén***********************************/
/******************************************************************************/
Route::name('cactivities.')->middleware(['auth'])->prefix('cactivities')->group(function () {
    //Listado de Marca
    Route::get('/', ['uses' => 'CactivityController@index', 'as' => 'index'])->middleware('permission:cactivities.index');
    //Registrar
    Route::post('store', ['uses' => 'CactivityController@store', 'as' => 'store'])->middleware('permission:cactivities.create');
    //Formulario Actualizar Marca
    Route::get('{id}/edit', ['uses' => 'CactivityController@edit', 'as' => 'edit'])->middleware('permission:cactivities.edit');
    //Actualizar
    Route::put('{id}', ['uses' => 'CactivityController@update', 'as' => 'update'])->middleware('permission:cactivities.edit');
    //Eliminar con Sofdeleted
    Route::delete('{id}', ['uses' => 'CactivityController@destroy', 'as' => 'destroy'])->middleware('permission:cactivities.destroy');
    //Datatable
    Route::get('datatable', ['uses' => 'CactivityController@datatable', 'as' => 'datatable'])->middleware('permission:cactivities.index');
    //Api Select
    Route::get('select', ['uses' => 'CactivityController@select', 'as' => 'select']);
});
/**********************************Ordenantes**********************************/
/******************************************************************************/
Route::name('payers.')->middleware(['auth'])->prefix('payers')->group(function () {
    //Listado de Marca
    Route::get('/', ['uses' => 'PayerController@index', 'as' => 'index'])->middleware('permission:payers.index');
    //Registrar
    Route::post('store', ['uses' => 'PayerController@store', 'as' => 'store'])->middleware('permission:payers.create');
    //Formulario Actualizar Marca
    Route::get('{id}/edit', ['uses' => 'PayerController@edit', 'as' => 'edit'])->middleware('permission:payers.edit');
    //Actualizar
    Route::put('{id}', ['uses' => 'PayerController@update', 'as' => 'update'])->middleware('permission:payers.edit');
    //Eliminar con Sofdeleted
    Route::delete('{id}', ['uses' => 'PayerController@destroy', 'as' => 'destroy'])->middleware('permission:payers.destroy');
    //Datatable
    Route::get('datatable', ['uses' => 'PayerController@datatable', 'as' => 'datatable'])->middleware('permission:payers.index');
});
/*******************************Modo Negocio***********************************/
/******************************************************************************
Route::name('logs.')->middleware(['auth'])->prefix('logs')->group(function() {
  //Listado de Marca
 Route::get('find',['uses' => 'LogController@find', 'as' => 'index'])->middleware('permission:logs.create');
});
 */

//API Ciudad, Estados
Route::get('states/select', ['uses' => 'ApiController@states', 'as' => 'states'])->middleware('auth');
Route::get('cities/select', ['uses' => 'ApiController@cities', 'as' => 'cities'])->middleware('auth');
