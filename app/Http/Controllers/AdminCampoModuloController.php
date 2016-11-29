<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;

class AdminCampoModuloController extends Controller
{
    public function __construct(){
		$this->middleware('auth');
	}

	public function delete($id){
		try{
			$campo = \App\CampoModulo::find($id);
			$modulo = \App\Gerador::find($campo->id_modulo);
			\App\CampoModulo::deletar($id);

			DB::statement('ALTER TABLE '.$modulo->nome_tabela.' DROP COLUMN '.$campo->nome);
			
			echo json_encode(array(
				'status' => true,
				'message' => 'Registro removido com sucesso!'
			));
			exit;
		}catch(Exception $e){
			echo json_encode(array(
				'status' => false,
				'message' => 'Não foi possível remover o registro.'
			));
			exit;
		}
		
		
	}

}
