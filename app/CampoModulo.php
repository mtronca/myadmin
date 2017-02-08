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
				'required' => $input['required'],
				'label' => $input['label'],
				'tipo_campo' => $input['tipo_campo'],
				'ordem' => $input['ordem'],
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
			'required' => $input['required'],
			'tipo_campo' => $input['tipo_campo'],
			'ordem' => $input['ordem'],
			'id_modulo' => $input['id_modulo'],
		]);
	}

	public static function deletar($id){
		return DB::table('sis_campo_modulo')
				->where('id', $id)
				->delete();
	}

	public function modulo()
   {
      return $this->belongsTo('App\Gerador', 'id_modulo');
   }
}
