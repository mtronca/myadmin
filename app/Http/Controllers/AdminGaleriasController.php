<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AdminGaleriasController extends Controller
{
     public function __construct(){
		$this->middleware('auth');
	}

	public function index(){
		$data['galerias'] = \App\Galerias::get();
		return view('admin/galerias',$data);
	}

	public function add(){
		return view('admin/form-galerias');
	}

	public function edit($id){
		$data['galeria'] = \App\Galerias::find($id);
		$data['galeria']->imagens = \App\Galerias::getImagens($id);
		return view('admin/form-galerias',$data);
	}

	public function add_imagem($id){
		$data['galeria'] = \App\Galerias::find($id);
		return view('admin/form-imagem', $data);
	}

	public function edit_imagem($id){
		$data['imagem'] = \App\Galerias::getImagem($id);
		$item = $data['imagem'];
		$data['galeria'] = \App\Galerias::find($item->id_galeria);
		return view('admin/form-imagem',$data);
	}


	public function save(Request $request){
		try{
			$post = $request->input();
			if($request->input('id')){
				\App\Galerias::editar($post, $request->input('id'));
			}else{
				\App\Galerias::criar($post);
			}
			\Session::flash('type', 'success');
            \Session::flash('message', "Alteracoes salvas com sucesso!");
			return redirect('admin/galerias');
		}catch(Exception $e){
			\Session::flash('type', 'error');
            \Session::flash('message', $e->getMessage());
            return redirect()->back();
		}
		
		
	}

	public function save_imagem(Request $request){
		try{
			$post = $request->input();
			if($request->input('id')){
				\App\Galerias::editar_imagem($post, $request->input('id'));
			}else{
				\App\Galerias::criar_imagem($post);
			}
			\Session::flash('type', 'success');
            \Session::flash('message', "Alteracoes salvas com sucesso!");
			return redirect('admin/galerias/edit/'.$post['id_galeria']);
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
			$tmpFilePath = '/uploads/galerias/';
			$tmpFileName = time() . '-' . $file->getClientOriginalName();
			$file = $file->move(public_path() . $tmpFilePath, $tmpFileName);
			$path = $tmpFilePath . $tmpFileName;
			return response()->json(array('path'=> $path, 'file_name'=>$tmpFileName), 200);
		} else {
			return response()->json(false, 200);
		}
	}

	public function crop_image(Request $request) {
		$img = \Image::make('uploads/galerias/'.$request->input('file_name'));
		$dataCrop = json_decode($request->input('data_crop'));
		if($img->crop(intval($dataCrop->width), intval($dataCrop->height), intval($dataCrop->x), intval($dataCrop->y))->save('uploads/galerias/thumb_'.$request->input('file_name'))){
			@unlink('uploads/galerias/'.$request->input('file_name'));
			echo json_encode(array(
				'status' => true,
				'path' => '/uploads/galerias/thumb_'.$request->input('file_name'),
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
			\App\Galerias::deletar($id);

			\Session::flash('type', 'success');
            \Session::flash('message', "Registro removido com sucesso!");
			return redirect('admin/galerias');
		}catch(Exception $e){
			\Session::flash('type', 'error');
            \Session::flash('message', "Nao foi possivel remover o registro!");
            return redirect()->back();
		}
		
		
	}

	public function delete_imagem($id){
		try{
			$imagem = \App\Galerias::getImagem($id);
			\App\Galerias::deletar_imagem($id);

			\Session::flash('type', 'success');
            \Session::flash('message', "Registro removido com sucesso!");
			return redirect('admin/galerias/edit/'.$imagem->id_galeria);
		}catch(Exception $e){
			\Session::flash('type', 'error');
            \Session::flash('message', "Nao foi possivel remover o registro!");
            return redirect()->back();
		}
		
		
	}

}
