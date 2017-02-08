<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Gerador extends Model
{
	protected $table = 'sis_modulos';

	public static function criar($input){
		$imagem = (isset($input['imagem'])) ? $input['imagem'] : 0;
		$galeria = (isset($input['galeria'])) ? $input['galeria'] : 0;

		DB::table('sis_modulos')->insert([
			[
				'label' => $input['label'],
				'nome' => $input['nome'],
				'rota' => $input['rota'],
				'item_modulo' => $input['item_modulo'],
				'items_modulo' => $input['items_modulo'],
				'nome_tabela' => $input['nome_tabela'],
				'imagem' => $imagem,
				'galeria' => $galeria,
				'id_tipo_modulo' => $input['id_tipo_modulo']
			]
		]);
		$id_modulo = DB::getPdo()->lastInsertId();

		return ($id_modulo) ? $id_modulo : null;
	}

	public static function editar($input, $id){
		$imagem = (isset($input['imagem'])) ? $input['imagem'] : 0;
		$galeria = (isset($input['galeria'])) ? $input['galeria'] : 0;
		return DB::table('sis_modulos')->where('id', $id)
		->update([
			'label' => $input['label'],
			'nome' => $input['nome'],
			'rota' => $input['rota'],
			'item_modulo' => $input['item_modulo'],
			'items_modulo' => $input['items_modulo'],
			'nome_tabela' => $input['nome_tabela'],
			'imagem' => $imagem,
			'galeria' => $galeria,
			'id_tipo_modulo' => $input['id_tipo_modulo']
		]);
	}

	public static function deletar($id){
		return DB::table('sis_modulos')
				->where('id', $id)
				->delete();
	}

	public function campos()
    {
        return $this->hasMany('App\CampoModulo','id_modulo');
    }
}
