<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class CampoModulo extends Model
{
	protected $table = 'sis_campo_modulo';

	public static function criar($input){
		
		return DB::table('sis_campo_modulo')->insert([
			[
				'nome' => $input['nome'],
				'valor_padrao' => $input['valor_padrao'],
				'listagem' => $input['listagem'],
				'label' => $input['label'],
				'id_tipo_campo' => $input['id_tipo_campo'],
				'id_modulo' => $input['id_modulo'],
			]
		]);
	}

	public static function editar($input, $id){
		return DB::table('sis_campo_modulo')->where('id', $id)
		->update([
			'nome' => $input['nome'],
			'valor_padrao' => $input['valor_padrao'],
			'listagem' => $input['listagem'],
			'label' => $input['label'],
			'id_tipo_campo' => $input['id_tipo_campo'],
			'id_modulo' => $input['id_modulo'],
		]);
	}
}
