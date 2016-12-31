<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// ================================
// Admin Index routes BEGINING
// ================================
Route::get('/admin', 'AdminIndexController@index');
//Route::get('info/edit', 'AdminIndexController@edit');
//Route::post('info/save', 'AdminIndexController@save');
//Route::post('info/upload', 'AdminIndexController@upload_image');
//Route::post('info/crop', 'AdminIndexController@crop_image');






// ==============================
// Configurações (Admin) routes
// ==============================
Route::get('admin/informacoes-basicas', 'AdminBasicInfoController@index');
Route::post('admin/informacoes-basicas/save', 'AdminBasicInfoController@save');
Route::get('admin/gerador', 'AdminGeradorController@index');
Route::get('admin/gerador/add', 'AdminGeradorController@add');
Route::get('admin/gerador/edit/{id}', 'AdminGeradorController@edit');
Route::get('admin/gerador/delete/{id}', 'AdminGeradorController@delete');
Route::post('admin/gerador/save', 'AdminGeradorController@save');
Route::post('admin/campo-modulo/delete/{id}', 'AdminCampoModuloController@delete');

// ==============================
// Tipo Módulo routes
// ==============================
Route::get('admin/tipo-modulo', 'AdminTipoModuloController@index');
Route::get('admin/tipo-modulo/add', 'AdminTipoModuloController@add');
Route::get('admin/tipo-modulo/edit/{id}', 'AdminTipoModuloController@edit');
Route::get('admin/tipo-modulo/delete/{id}', 'AdminTipoModuloController@delete');
Route::post('admin/tipo-modulo/save', 'AdminTipoModuloController@save');


// ================================
// UserGroup routes BEGINING
// ================================
Route::get('admin/users-groups', 'AdminUserGroupController@index');
Route::get('admin/users-groups/add', 'AdminUserGroupController@add');
Route::get('admin/users-groups/edit/{id}', 'AdminUserGroupController@edit');
Route::post('admin/users-groups/save', 'AdminUserGroupController@save');
Route::get('admin/users-groups/delete/{id}', 'AdminUserGroupController@delete');

// ================================
// User routes BEGINING
// ================================
Route::get('admin/users', 'AdminUserController@index');
Route::get('admin/users/add', 'AdminUserController@add');
Route::get('admin/users/edit/{id}', 'AdminUserController@edit');
Route::post('admin/users/save', 'AdminUserController@save');
Route::get('admin/users/delete/{id}', 'AdminUserController@delete');
Route::post('admin/users/upload', 'AdminUserController@upload_image');
Route::post('admin/users/crop', 'AdminUserController@crop_image');


// ================================
// Exemplos de rotas (Apartamentos)
// ================================
/*
Route::get('admin/apartamentos', 'AdminApartamentosController@index');
Route::get('admin/apartamentos/add', 'AdminApartamentosController@add');
Route::get('admin/apartamentos/edit/{id}', 'AdminApartamentosController@edit');
Route::get('admin/apartamentos/edit_reserva/{id}', 'AdminApartamentosController@edit_reserva');
Route::get('admin/apartamentos/add_reserva/{id}', 'AdminApartamentosController@add_reserva');
Route::post('admin/apartamentos/save', 'AdminApartamentosController@save');
Route::post('admin/apartamentos/save-reserva', 'AdminApartamentosController@save_reserva');
Route::get('admin/apartamentos/delete/{id}', 'AdminApartamentosController@delete');
Route::get('admin/apartamentos/delete_reserva/{id}', 'AdminApartamentosController@delete_reserva');
Route::get('admin/apartamentos/delete_solicitacao/{id}', 'AdminApartamentosController@delete_solicitacao');
Route::get('admin/apartamentos/aprovar_solicitacao/{id}', 'AdminApartamentosController@aprovar_solicitacao');
Route::post('admin/apartamentos/upload', 'AdminApartamentosController@upload_image');
Route::post('admin/apartamentos/crop', 'AdminApartamentosController@crop_image');
Route::get('apartamentos', 'ApartamentosController@index');
Route::get('apartamentos/detalhe/{slug}', 'ApartamentosController@detalhe');
Route::post('apartamentos/solicitar', 'ApartamentosController@solicitar');
Route::get('admin/apartamentos/edit_imagem/{id}', 'AdminApartamentosController@edit_imagem');
Route::get('admin/apartamentos/add_imagem/{id}', 'AdminApartamentosController@add_imagem');
Route::post('admin/apartamentos/save-imagem', 'AdminApartamentosController@save_imagem');
Route::get('admin/apartamentos/delete_imagem/{id}', 'AdminApartamentosController@delete_imagem');
*/


// ================================
// Auth routes BEGINING
// ================================
Route::auth();


// ================================
// Home routes BEGINING
// ================================
Route::get('/', 'HomeController@index');


// ================================
// Telegram routes BEGINING
// ================================
Route::get('telegram/get-updates','TelegramController@getUpdates');
Route::post('telegram/send-message','TelegramController@postSendMessage');
//Route::get('send-message','TelegramController@getSendMessage');

