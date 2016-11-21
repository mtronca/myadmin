<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AdminGeradorController extends Controller
{
    public function __construct(){
		$this->middleware('auth');
	}

	public function index(){
		$data['modulos'] = \App\Gerador::get();
		return view('admin/gerador',$data);
	}

	public function add(){
		$data = array();
		$data['tipos'] = \App\TipoModulo::get();
		return view('admin/form-gerador', $data);
	}

	public function edit($id){
		$data['modulo'] = \App\Gerador::find($id);
		$data['tipos'] = \App\TipoModulo::get();
		return view('admin/form-gerador',$data);
	}

	public function save(Request $request){
		try{
			$post = $request->input();
			if($request->input('id')){
				\App\Gerador::editar($post, $request->input('id'));
			}else{
				\App\Gerador::criar($post);
			}
			\Session::flash('type', 'success');
            \Session::flash('message', "Alteracoes salvas com sucesso!");
			return redirect('admin/gerador');
		}catch(Exception $e){
			\Session::flash('type', 'error');
            \Session::flash('message', $e->getMessage());
            return redirect()->back();
		}
		
		
	}

	public function delete($id){
		try{
			\App\Gerador::deletar($id);

			\Session::flash('type', 'success');
            \Session::flash('message', "Registro removido com sucesso!");
			return redirect('admin/gerador');
		}catch(Exception $e){
			\Session::flash('type', 'error');
            \Session::flash('message', "Nao foi possivel remover o registro!");
            return redirect()->back();
		}
		
		
	}

}
