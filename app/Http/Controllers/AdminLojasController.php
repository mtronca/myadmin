<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AdminLojasController extends Controller
{
    public function __construct(){
		$this->middleware('auth');
	}

	public function index(){
		$data['lojas'] = \App\Lojas::find(1);
		$data['lojas']->imagens = \App\Lojas::getImagens();
		return view('admin/lojas',$data);
	}

	public function save(Request $request){
		$lojas = \App\Lojas::find(1);
		if($lojas){
			try{
				\App\Lojas::editar($request->input(), 1);
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
		return redirect('/admin/lojas');
	}

	public function upload_image(Request $request) {
		if($request->hasFile('file')) {
			//upload an image to the /img/tmp directory and return the filepath.
			$file = $request->file('file');
			$tmpFilePath = '/uploads/lojas/';
			$tmpFileName = time() . '-' . $file->getClientOriginalName();
			$file = $file->move(public_path() . $tmpFilePath, $tmpFileName);
			$path = $tmpFilePath . $tmpFileName;
			return response()->json(array('path'=> $path, 'file_name'=>$tmpFileName), 200);
		} else {
			return response()->json(false, 200);
		}
	}

	public function crop_image(Request $request) {
		$img = \Image::make('uploads/lojas/'.$request->input('file_name'));
		$dataCrop = json_decode($request->input('data_crop'));
		if($img->crop(intval($dataCrop->width), intval($dataCrop->height), intval($dataCrop->x), intval($dataCrop->y))->save('uploads/lojas/thumb_'.$request->input('file_name'))){
			@unlink('uploads/lojas/'.$request->input('file_name'));
			echo json_encode(array(
				'status' => true,
				'path' => '/uploads/lojas/thumb_'.$request->input('file_name'),
				'file_name' => 'thumb_'.$request->input('file_name'),
			));
		}else{
			echo json_encode(array(
				'status' => false,
				'message' => 'Não foi possível alterar a imagem.'
			));
		}

	}

	public function add_imagem(){
		$data['lojas'] = \App\Lojas::find(1);
		return view('admin/form-lojas-imagem', $data);
	}

	public function edit_imagem($id){
		$data['imagem'] = \App\Lojas::getImagem($id);
		$data['lojas'] = \App\Lojas::find(1);
		return view('admin/form-lojas-imagem',$data);
	}
	public function save_imagem(Request $request){
		try{
			$post = $request->input();
			if($request->input('id')){
				\App\Lojas::editar_imagem($post, $request->input('id'));
			}else{
				\App\Lojas::criar_imagem($post);
			}
			\Session::flash('type', 'success');
            \Session::flash('message', "Alteracoes salvas com sucesso!");
			return redirect('admin/lojas');
		}catch(Exception $e){
			\Session::flash('type', 'error');
            \Session::flash('message', $e->getMessage());
            return redirect()->back();
		}
		
		
	}
	public function delete_imagem($id){
		try{
			$imagem = \App\Lojas::getImagem($id);
			\App\Lojas::deletar_imagem($id);

			\Session::flash('type', 'success');
            \Session::flash('message', "Registro removido com sucesso!");
			return redirect('admin/lojas');
		}catch(Exception $e){
			\Session::flash('type', 'error');
            \Session::flash('message', "Nao foi possivel remover o registro!");
            return redirect()->back();
		}
		
		
	}

}
