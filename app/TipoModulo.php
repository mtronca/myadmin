<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class TipoModulo extends Model
{
	protected $table = 'sis_tipos_modulo';

	public static function criar($input){
		return DB::table('sis_tipos_modulo')->insert([
			[
				'nome' => $input['nome'],
			]
		]);
	}

	public static function editar($input, $id){
		return DB::table('sis_tipos_modulo')->where('id', $id)
		->update([
			'nome' => $input['nome'],
		]);
	}

	public static function deletar($id){
		return DB::table('sis_tipos_modulo')
				->where('id', $id)
				->delete();
	}
}
