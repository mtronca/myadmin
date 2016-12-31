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

	public function add(){
		$data = array();
		$data['listaUserGroup'] = \App\UserGroup::get();
		return view('admin/form-users', $data);
	}

	public function edit($id){
		$data['user'] = \App\User::find($id);
		$data['listaUserGroup'] = \App\UserGroup::get();
		return view('admin/form-users',$data);
	}



	public function save(Request $request){
		try{
			$post = $request->input();

			if($request->input('id')){
				\App\User::editar($post, $request->input('id'));
			}else{
				\App\User::criar($post);
			}
			\Session::flash('type', 'success');
            \Session::flash('message', "Alteracoes salvas com sucesso!");
			return redirect('admin/users');
		}catch(Exception $e){
			\Session::flash('type', 'error');
            \Session::flash('message', $e->getMessage());
            return redirect()->back();
		}
		
		
	}

	public function upload_image(Request $request) {
		if($request->hasFile('file')) {
			//upload an image to the /img/tmp directory and return the filepath.
			$file = $request->file('file');
			$tmpFilePath = '/uploads/users/';
			$tmpFileName = time() . '-' . $file->getClientOriginalName();
			$file = $file->move(public_path() . $tmpFilePath, $tmpFileName);
			$path = $tmpFilePath . $tmpFileName;
			return response()->json(array('path'=> $path, 'file_name'=>$tmpFileName), 200);
		} else {
			return response()->json(false, 200);
		}
	}

	public function crop_image(Request $request) {
		$img = \Image::make('uploads/users/'.$request->input('file_name'));
		$dataCrop = json_decode($request->input('data_crop'));
		if($img->crop(intval($dataCrop->width), intval($dataCrop->height), intval($dataCrop->x), intval($dataCrop->y))->save('uploads/users/thumb_'.$request->input('file_name'))){
			@unlink('uploads/users/'.$request->input('file_name'));
			echo json_encode(array(
				'status' => true,
				'path' => '/uploads/users/thumb_'.$request->input('file_name'),
				'file_name' => 'thumb_'.$request->input('file_name'),
			));
		}else{
			echo json_encode(array(
				'status' => false,
				'message' => 'Não foi possível alterar a imagem.'
			));
		}

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
