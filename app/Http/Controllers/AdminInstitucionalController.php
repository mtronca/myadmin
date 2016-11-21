<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AdminInstitucionalController extends Controller
{
     public function __construct(){
		$this->middleware('auth');
	}

	public function index(){
		$data['institucional'] = \App\Institucional::find(1);
		$data['institucional']->imagens = \App\Institucional::getImagens();
		return view('admin/institucional',$data);
	}


	public function save(Request $request){
		try{
			\App\Institucional::editar($request->input(), 1);
			\Session::flash('type', 'success');
            \Session::flash('message', "Alteracoes salvas com sucesso!");
			return redirect('admin/institucional');
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
			$tmpFilePath = '/uploads/institucional/';
			$tmpFileName = time() . '-' . $file->getClientOriginalName();
			$file = $file->move(public_path() . $tmpFilePath, $tmpFileName);
			$path = $tmpFilePath . $tmpFileName;
			return response()->json(array('path'=> $path, 'file_name'=>$tmpFileName), 200);
		} else {
			return response()->json(false, 200);
		}
	}

	public function crop_image(Request $request) {
		$img = \Image::make('uploads/institucional/'.$request->input('file_name'));
		$dataCrop = json_decode($request->input('data_crop'));
		if($img->crop(intval($dataCrop->width), intval($dataCrop->height), intval($dataCrop->x), intval($dataCrop->y))->save('uploads/institucional/thumb_'.$request->input('file_name'))){
			@unlink('uploads/institucional/'.$request->input('file_name'));
			echo json_encode(array(
				'status' => true,
				'path' => '/uploads/institucional/thumb_'.$request->input('file_name'),
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
		$data['institucional'] = \App\Institucional::find(1);
		return view('admin/form-institucional-imagem', $data);
	}

	public function edit_imagem($id){
		$data['imagem'] = \App\Institucional::getImagem($id);
		$data['institucional'] = \App\Institucional::find(1);
		return view('admin/form-institucional-imagem',$data);
	}
	public function save_imagem(Request $request){
		try{
			$post = $request->input();
			if($request->input('id')){
				\App\Institucional::editar_imagem($post, $request->input('id'));
			}else{
				\App\Institucional::criar_imagem($post);
			}
			\Session::flash('type', 'success');
            \Session::flash('message', "Alteracoes salvas com sucesso!");
			return redirect('admin/institucional');
		}catch(Exception $e){
			\Session::flash('type', 'error');
            \Session::flash('message', $e->getMessage());
            return redirect()->back();
		}
		
		
	}
	public function delete_imagem($id){
		try{
			$imagem = \App\Institucional::getImagem($id);
			\App\Institucional::deletar_imagem($id);

			\Session::flash('type', 'success');
            \Session::flash('message', "Registro removido com sucesso!");
			return redirect('admin/institucional');
		}catch(Exception $e){
			\Session::flash('type', 'error');
            \Session::flash('message', "Nao foi possivel remover o registro!");
            return redirect()->back();
		}
		
		
	}

}
