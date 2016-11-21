<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class BasicInfo extends Model
{
	protected $table = 'sis_basic_info';

	public static function criar($input){
		$basic_meta_keywords = implode(',',$input['taggles']);
		return DB::table('sis_basic_info')->insert([
			[
				'title' => $input['title'],
				'basic_meta_keywords' => $basic_meta_keywords,
				'basic_meta_descricao' => $input['basic_meta_descricao']
			]
		]);
	}

	public static function editar($input, $id){
		$basic_meta_keywords = implode(',',$input['taggles']);
		return DB::table('sis_basic_info')->where('id', $id)
		->update([
			'title' => $input['title'],
			'basic_meta_keywords' => $basic_meta_keywords,
			'basic_meta_descricao' => $input['basic_meta_descricao']
		]);
	}
}
