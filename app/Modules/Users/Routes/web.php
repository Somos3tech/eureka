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
Route::name('users.')->middleware(['auth'])->prefix('users')->group(function () {
    /****************************************************************************/
    /***************************Usuarios del Sistema*****************************/
    //Listado de Usuarios del Sistema
    Route::get('/', ['uses' => 'UserController@index', 'as' => 'index'])->middleware('permission:users.index');
    //Crear Usuario
    Route::get('create', ['uses' => 'UserController@create', 'as' => 'create'])->middleware('permission:users.create');
    Route::post('store', ['uses' => 'UserController@store', 'as' => 'store'])->middleware('permission:users.create');
    //Formulario Actualizar Usuario
    Route::get('{id}/edit', ['uses' => 'UserController@edit', 'as' => 'edit'])->middleware('permission:users.edit');
    Route::put('{id}', ['uses' => 'UserController@update', 'as' => 'update'])->middleware('permission:users.edit');
    //Eliminar con Sofdeleted
    Route::delete('{id}', ['uses' => 'UserController@destroy', 'as' => 'destroy'])->middleware('permission:users.destroy');
    //Cambio Contraseña
    Route::get('changepassword', ['uses' => 'UserController@changePassword', 'as' => 'changepassword']);
    //Api Listado Usuarios
    Route::get('datatable', ['uses' => 'UserController@datatable', 'as' => 'datatable'])->middleware('permission:users.index');
    //Perfil Usuario
    Route::get('profile', ['uses' => 'UserController@profile', 'as' => 'profile']);
    //Api Select Usuario(s)
    Route::get('select', ['uses' => 'UserController@select', 'as' => 'select']);
    //Api Select Usuario(s)
    Route::get('select/assignment', ['uses' => 'UserController@assignment', 'as' => 'assignment']);
});

/******************************************************************************/
/*******************************Item Role(s)***********************************/
Route::name('roles.')->prefix('roles')->middleware(['auth'])->group(function () {
    //Listar
    Route::get('/', ['uses' => 'RoleController@index', 'as' => 'index'])->middleware('permission:roles.index');
    //Registrar
    Route::get('create', ['uses' => 'RoleController@create', 'as' => 'create'])->middleware('permission:roles.create');
    Route::post('store', ['uses' => 'RoleController@store', 'as' => 'store'])->middleware('permission:roles.create');
    //Actualizar
    Route::get('{id}/edit', ['uses' => 'RoleController@edit', 'as' => 'edit'])->middleware('permission:roles.edit');
    Route::put('{id}', ['uses' => 'RoleController@update', 'as' => 'update'])->middleware('permission:roles.edit');
    //Eliminar
    Route::delete('{id}', ['uses' => 'RoleController@destroy', 'as' => 'destroy'])->middleware('permission:roles.destroy');
    //Datatable
    Route::get('datatable', ['uses' => 'RoleController@datatable', 'as' => 'datatable'])->middleware('permission:roles.index');
    //Select
    Route::get('select', ['uses' => 'RoleController@select', 'as' => 'select']);
    //Api Valid Role(s)
    Route::get('valid-role', ['uses' => 'RoleController@validRole', 'as' => 'valid-role']);

    Route::get('getrole', ['uses' => 'RoleController@getRole', 'as' => 'get_role']);
});

/******************************************************************************/
/******************************Item Permiso(s)*********************************/
Route::name('permissions.')->prefix('permissions')->middleware(['auth'])->group(function () {
    //Listar
    Route::get('/', ['uses' => 'PermissionController@index', 'as' => 'index'])->middleware('permission:permissions.index');
    //Registrar
    Route::get('create', ['uses' => 'PermissionController@create', 'as' => 'create'])->middleware('permission:permissions.create');
    Route::post('store', ['uses' => 'PermissionController@store', 'as' => 'store'])->middleware('permission:permissions.create');
    //Actualizar
    Route::get('{id}/edit', ['uses' => 'PermissionController@edit', 'as' => 'edit'])->middleware('permission:permissions.edit');
    Route::put('{id}', ['uses' => 'PermissionController@update', 'as' => 'update'])->middleware('permission:permissions.edit');
    //Eliminar
    Route::delete('{id}', ['uses' => 'PermissionController@destroy', 'as' => 'destroy'])->middleware('permission:permissions.destroy');
    //Datatable
    Route::get('datatable', ['uses' => 'PermissionController@datatable', 'as' => 'datatable'])->middleware('permission:permissions.index');
    //Select
    Route::get('select', ['uses' => 'PermissionController@select', 'as' => 'select']);
});
