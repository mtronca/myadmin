<?php

namespace App\Modules\<NOME_MODULO>\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class <NOME_MODULO> extends Model
{
	protected $table = '<NOME_TABELA>';

	protected $lastInsertId = 0;

	public function getBySlug($slug){
		return DB::table($this->table)->where('slug',$slug)->firstOrFail();
	}

	public function criar($fields, $input){
		$insert = [];
		foreach ($fields as $field) {
			$insert[$field] = $input[$field];
		}

		DB::table($this->table)->insert([
			$insert
		]);

		$id_<ITEM_MODULO> = DB::getPdo()->lastInsertId();


		return 1;
	}

    public function editar($fields, $input, $id){
		$insert = [];
		foreach ($fields as $field) {
			$insert[$field] = $input[$field];
		}

    	DB::table($this->table)->where('id', $id)
		->update($insert);

		return 1;
	}

	public function deletar($id){
		return DB::table($this->table)
				->where('id', $id)
				->delete();
	}


	public function getImagem($id){
		return DB::table($this->table.'_imagens')->find($id);
	}

	public function getImagens($id){
		return DB::table($this->table.'_imagens')->where('id_<ITEM_MODULO>', $id)->get();
	}
	public function criar_imagem($input){
		return DB::table($this->table.'_imagens')->insert([
			[
				'id_<ITEM_MODULO>' => $input['id_<ITEM_MODULO>'],
				'thumbnail_principal' => $input['thumbnail_principal'],
			]
		]);
	}
	public function deletar_imagem($id){
		return DB::table($this->table.'_imagens')
				->where('id', $id)
				->delete();
	}

	public function getLastInsertId(){
		return $this->lastInsertId;
	}
}
