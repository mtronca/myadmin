<?php

// ================================
// <LABEL_MODULO> routes BEGGINING
// ================================

Route::group(array('middleware' => 'web', 'namespace' => 'App\Modules\<NOME_MODULO>\Controllers\Admin'), function() {
	Route::get('admin/<ROTA_MODULO>', ['uses' => 'Admin<NOME_MODULO>Controller@index']);
	Route::get('admin/<ROTA_MODULO>/add', ['uses' => 'Admin<NOME_MODULO>Controller@add']);
	Route::get('admin/<ROTA_MODULO>/edit/{id}', ['uses' => 'Admin<NOME_MODULO>Controller@edit']);
	Route::post('admin/<ROTA_MODULO>/save', ['uses' => 'Admin<NOME_MODULO>Controller@save']);
	Route::get('admin/<ROTA_MODULO>/delete/{id}', ['uses' => 'Admin<NOME_MODULO>Controller@delete']);
	Route::post('admin/<ROTA_MODULO>/upload', ['uses' => 'Admin<NOME_MODULO>Controller@upload_image']);
	Route::post('admin/<ROTA_MODULO>/crop', ['uses' => 'Admin<NOME_MODULO>Controller@crop_image']);
	Route::post('admin/<ROTA_MODULO>/upload_galeria/{id}', ['uses' => 'Admin<NOME_MODULO>Controller@upload_galeria']);
	Route::post('admin/<ROTA_MODULO>/delete_imagem/{id}', ['uses' => 'Admin<NOME_MODULO>Controller@delete_imagem']);
});

Route::group(array('middleware' => 'web', 'namespace' => 'App\Modules\<NOME_MODULO>\Controllers'), function() {
	Route::get('<ROTA_MODULO>', ['uses' => '<NOME_MODULO>Controller@index']);
	Route::get('<ROTA_MODULO>/detalhe/{slug}', ['uses' => '<NOME_MODULO>Controller@detalhe']);
});
