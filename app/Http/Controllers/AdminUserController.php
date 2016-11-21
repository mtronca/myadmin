<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

use App\Http\Requests;

class AdminUserController extends Controller
{
    public function __construct(){
		$this->middleware('auth');
	}

	public function index(){
		$data['listaUser'] = \App\User::all();
		return view('admin/users',$data);
	}


	public function view($id){
		$data['user'] = \App\User::find($id);
		return view('admin/view-user',$data);
	}



	public function delete($id){
		try{
			DB::table('users')
				->where('id', $id)
				->delete();
			
			\Session::flash('type', 'success');
            \Session::flash('message', "Registro removido com sucesso!");
			return redirect('admin/users');
		}catch(Exception $e){
			\Session::flash('type', 'error');
            \Session::flash('message', "Nao foi possivel remover o registro!");
            return redirect()->back();
		}
		
		
	}
}
