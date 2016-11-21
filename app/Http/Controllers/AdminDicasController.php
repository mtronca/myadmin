<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AdminDicasController extends Controller
{
     public function __construct(){
		$this->middleware('auth');
	}

	public function index(){
		$data['dicas'] = \App\Dicas::get();
		$data['categorias'] = \App\Dicas::getListaCategorias();
		return view('admin/dicas',$data);
	}

	public function add(){
		$data['categorias'] = \App\Dicas::getListaCategorias();
		return view('admin/form-dicas', $data);
	}

	public function edit($id){
		$data['dica'] = \App\Dicas::find($id);
		$data['categorias'] = \App\Dicas::getListaCategorias();
		return view('admin/form-dicas',$data);
	}


	public function save(Request $request){
		try{
			$post = $request->input();
			$post['slug'] = $this->slugify($post['titulo']);
			if($request->input('id')){
				\App\Dicas::editar($post, $post['id']);
			}else{
				\App\Dicas::criar($post);
			}
			\Session::flash('type', 'success');
            \Session::flash('message', "Alteracoes salvas com sucesso!");
			return redirect('admin/dicas');
		}catch(Exception $e){
			\Session::flash('type', 'error');
            \Session::flash('message', $e->getMessage());
            return redirect()->back();
		}
		
		
	}

	public function add_categoria(){
		return view('admin/form-dicas-categorias');
	}

	public function edit_categoria($id){
		$data['categoria'] = \App\Dicas::getCategoria($id);
		return view('admin/form-dicas-categorias',$data);
	}


	public function save_categoria(Request $request){
		try{
			if($request->input('id')){
				\App\Dicas::editar_categoria($request->input(), $request->input('id'));
			}else{
				\App\Dicas::criar_categoria($request->input());
			}
			\Session::flash('type', 'success');
            \Session::flash('message', "Alteracoes salvas com sucesso!");
			return redirect('admin/dicas');
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
			$tmpFilePath = '/uploads/dicas/';
			$tmpFileName = time() . '-' . $file->getClientOriginalName();
			$file = $file->move(public_path() . $tmpFilePath, $tmpFileName);
			$path = $tmpFilePath . $tmpFileName;
			return response()->json(array('path'=> $path, 'file_name'=>$tmpFileName), 200);
		} else {
			return response()->json(false, 200);
		}
	}

	public function crop_image(Request $request) {
		$img = \Image::make('uploads/dicas/'.$request->input('file_name'));
		$dataCrop = json_decode($request->input('data_crop'));
		if($img->crop(intval($dataCrop->width), intval($dataCrop->height), intval($dataCrop->x), intval($dataCrop->y))->save('uploads/dicas/thumb_'.$request->input('file_name'))){
			@unlink('uploads/dicas/'.$request->input('file_name'));
			echo json_encode(array(
				'status' => true,
				'path' => '/uploads/dicas/thumb_'.$request->input('file_name'),
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
			\App\Dicas::deletar($id);

			\Session::flash('type', 'success');
            \Session::flash('message', "Registro removido com sucesso!");
			return redirect('admin/dicas');
		}catch(Exception $e){
			\Session::flash('type', 'error');
            \Session::flash('message', "Nao foi possivel remover o registro!");
            return redirect()->back();
		}
		
		
	}

	public function delete_categoria($id){
		try{
			\App\Dicas::deletar_categoria($id);

			\Session::flash('type', 'success');
            \Session::flash('message', "Registro removido com sucesso!");
			return redirect('admin/dicas');
		}catch(Exception $e){
			\Session::flash('type', 'error');
            \Session::flash('message', "Nao foi possivel remover o registro!");
            return redirect()->back();
		}
		
		
	}

	private function slugify($string)
    {
        return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
    }

}
