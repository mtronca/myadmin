

// ================================
// <LABEL_MODULO> routes BEGGINING
// ================================
Route::get('admin/<ROTA_MODULO>', 'Admin<NOME_MODULO>Controller@index');
Route::get('admin/<ROTA_MODULO>/add', 'Admin<NOME_MODULO>Controller@add');
Route::get('admin/<ROTA_MODULO>/edit/{id}', 'Admin<NOME_MODULO>Controller@edit');
Route::post('admin/<ROTA_MODULO>/save', 'Admin<NOME_MODULO>Controller@save');
Route::get('admin/<ROTA_MODULO>/delete/{id}', 'Admin<NOME_MODULO>Controller@delete');
Route::post('admin/<ROTA_MODULO>/upload', 'Admin<NOME_MODULO>Controller@upload_image');
Route::post('admin/<ROTA_MODULO>/crop', 'Admin<NOME_MODULO>Controller@crop_image');
Route::get('admin/<ROTA_MODULO>/edit_imagem/{id}', 'Admin<NOME_MODULO>Controller@edit_imagem');
Route::get('admin/<ROTA_MODULO>/add_imagem/{id}', 'Admin<NOME_MODULO>Controller@add_imagem');
Route::post('admin/<ROTA_MODULO>/save-imagem', 'Admin<NOME_MODULO>Controller@save_imagem');
Route::get('admin/<ROTA_MODULO>/delete_imagem/{id}', 'Admin<NOME_MODULO>Controller@delete_imagem');

