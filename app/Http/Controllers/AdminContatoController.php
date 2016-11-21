<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AdminContatoController extends Controller
{
    public function __construct(){
		$this->middleware('auth');
	}

	public function index(){
		$data['contato'] = \App\Contato::find(1);
		$data['registros'] = \App\Contato::allRegistros();
		return view('admin/contato',$data);
	}

	public function save(Request $request){
		$contato = \App\Contato::find(1);
		if($contato){
			try{
				\App\Contato::editar($request->input(), 1);
				\Session::flash('type', 'success');
	            \Session::flash('message', "Registro alterado com sucesso!");
			}catch(Exception $e){
				\Session::flash('type', 'error');
	            \Session::flash('message', "Não foi possível alterar o registro!");
			}
		}else{
			\Session::flash('type', 'error');
            \Session::flash('message', "Não foi possível encontrar o registro fixo do módulo de contato.");
		}
		return redirect('/admin/contato');
	}

	public function deleteRegistro($id){
		$contatoRecord = \App\Contato::buscaRegistro($id);
		if($contatoRecord){
			try{
				\App\Contato::deletarRegistro($id);
				\Session::flash('type', 'success');
	            \Session::flash('message', "Registro removido com sucesso!");
			}catch(Exception $e){
				\Session::flash('type', 'error');
	            \Session::flash('message', "Não foi possível remover o registro!");
			}
		}else{
			\Session::flash('type', 'error');
            \Session::flash('message', "Não foi possível encontrar o registro.");
		}
		return redirect('/admin/contato');
	}

	public function getcep() {
	  	$cep = $_POST['cep'];
	  	$url = 'http://republicavirtual.com.br/web_cep.php?cep='.$cep.'&formato=jsonp';
	  	$resultado = file_get_contents($url);
	  	if(!$resultado){
	  		$resultado = "&resultado=0&resultado_txt=erro+ao+buscar+cep";
	  	}	 
	  	print_r($resultado);
	  	exit;
	}
}
