<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;

class AdminUserGroupController extends Controller
{
    public function __construct(){
		$this->middleware('auth');
	}

	public function index(){
		$data['listaUserGroup'] = \App\UserGroup::all();
		return view('admin/users-groups',$data);
	}

	public function add(){
		return view('admin/form-user-group');
	}

	public function edit($id){
		$data['userGroup'] = \App\UserGroup::find($id);
		return view('admin/form-user-group',$data);
	}


	public function save(Request $request){
		try{
			if($request->input('id')){
			DB::table('users_groups')
					->where('id', $request->input('id'))
					->update([
						'nome' => $request->input('nome')
					]);
			}else{
				DB::table('users_groups')->insert([
					[
						'nome' => $request->input('nome')
					]
				]);
			}
			\Session::flash('type', 'success');
            \Session::flash('message', "Alteracoes salvas com sucesso!");
			return redirect('admin/users-groups');
		}catch(Exception $e){
			\Session::flash('type', 'error');
            \Session::flash('message', "Nao foi possivel salvar as alteracoes!");
            return redirect()->back();
		}
		
		
	}

	public function delete($id){
		try{

			DB::table('users_groups')
				->where('id', $id)
				->delete();
			
			\Session::flash('type', 'success');
            \Session::flash('message', "Registro removido com sucesso!");
			return redirect('admin/users-groups');
		}catch(Exception $e){
			\Session::flash('type', 'error');
            \Session::flash('message', "Nao foi possivel remover o registro!");
            return redirect()->back();
		}
		
		
	}

}
