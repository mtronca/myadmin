<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Gerador extends Model
{
	protected $table = 'sis_modulos';

	public static function criar($input){
		return DB::table('sis_modulos')->insert([
			[
				'title' => $input['title'],
				'nome' => $input['nome'],
				'rota' => $input['rota'],
				'id_tipo' => $input['id_tipo']
			]
		]);
	}

	public static function editar($input, $id){
		return DB::table('sis_modulos')->where('id', $id)
		->update([
			'title' => $input['title'],
			'nome' => $input['nome'],
			'rota' => $input['rota'],
			'id_tipo' => $input['id_tipo']
		]);
	}

	public static function deletar($id){
		return DB::table('sis_modulos')
				->where('id', $id)
				->delete();
	}
}
