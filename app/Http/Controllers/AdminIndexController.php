<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;

class AdminIndexController extends Controller
{
	public function __construct(){
		$this->middleware('auth'/*, array('only' => array(
				'edit',
				'save'
			))*/);
	}

	public function index(){
		$data = array();
		return view('admin/index',$data);
	}

	public function busca(Request $request){
		$keyword = $request->get('q');
		$data = array();
		$modulos = \App\Gerador::where('id_tipo_modulo',1)->get();
		foreach ($modulos as $modulo) {
			$listagem = array();
			$query = DB::table($modulo->nome_tabela)->select('*');
			foreach ($modulo->campos as $campo) {
				$query->orWhere($campo->nome, 'LIKE', "%$keyword%");
				if($campo->listagem){
					$listagem[] = $campo;
				}
			}
			$results = $query->get();

			if(count($results)){
				$data['modulos'][$modulo->id]['modulo'] = $modulo;
				$data['modulos'][$modulo->id]['campos_listagem'] = $listagem;
				$data['modulos'][$modulo->id]['registros'] = $results;
			}

		}

		//print_r($data);die();

		return view('admin/busca', $data);
	}


}
