<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Http\Requests;

class Admin<NOME_MODULO>Controller extends Controller
{
	private $modulo;
	private $fields;

    public function __construct(){
		$this->middleware('auth');
		$this->modulo = \App\Gerador::find(<ID_MODULO>);
		$this->fields = \App\CampoModulo::where('id_modulo',<ID_MODULO>)->orderBy('ordem','ASC')->get();
	}

	public function index(){
		$data['modulo'] = $this->modulo;
		$data['fields'] = $this->fields;
		$data['<ITEM_MODULO>'] = \App\<NOME_MODULO>::find(1);
		if($this->modulo->galeria){
			$data['<ITEM_MODULO>']->imagens = \App\<NOME_MODULO>::getImagens(1);
		}
		return view('admin/<ROTA_MODULO>',$data);
	}


	public function save(Request $request){
		try{
			$post = $request->input();
			
			foreach ($this->fields as $field) {
				$arrayFields[] = $field->nome;
			}
			if($this->modulo->imagem){
				$arrayFields[] = 'thumbnail_principal';
			}

			\App\<NOME_MODULO>::editar($arrayFields, $post, $request->input('id'));
	
			\Session::flash('type', 'success');
            \Session::flash('message', "Alteracoes salvas com sucesso!");
			return redirect('admin/<ROTA_MODULO>');
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
			$tmpFilePath = '/uploads/<ROTA_MODULO>/';
			$tmpFileName = time() . '-' . $file->getClientOriginalName();
			$file = $file->move(public_path() . $tmpFilePath, $tmpFileName);
			$path = $tmpFilePath . $tmpFileName;
			return response()->json(array('path'=> $path, 'file_name'=>$tmpFileName), 200);
		} else {
			return response()->json(false, 200);
		}
	}

	public function crop_image(Request $request) {
		$img = \Image::make('uploads/<ROTA_MODULO>/'.$request->input('file_name'));
		$dataCrop = json_decode($request->input('data_crop'));
		if($img->crop(intval($dataCrop->width), intval($dataCrop->height), intval($dataCrop->x), intval($dataCrop->y))->save('uploads/<ROTA_MODULO>/thumb_'.$request->input('file_name'))){
			@unlink('uploads/<ROTA_MODULO>/'.$request->input('file_name'));
			echo json_encode(array(
				'status' => true,
				'path' => '/uploads/<ROTA_MODULO>/thumb_'.$request->input('file_name'),
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
			\App\<NOME_MODULO>::deletar($id);

			\Session::flash('type', 'success');
            \Session::flash('message', "Registro removido com sucesso!");
			return redirect('admin/<ROTA_MODULO>');
		}catch(Exception $e){
			\Session::flash('type', 'error');
            \Session::flash('message', "Nao foi possivel remover o registro!");
            return redirect()->back();
		}
		
		
	}

	public function add_imagem($id){
		$data['<ITEM_MODULO>'] = \App\<NOME_MODULO>::find($id);
		return view('admin/form-<ROTA_MODULO>-imagem', $data);
	}

	public function edit_imagem($id){
		$data['imagem'] = \App\<NOME_MODULO>::getImagem($id);
		$item = $data['imagem'];
		$data['<ITEM_MODULO>'] = \App\<NOME_MODULO>::find($item->id_<ITEM_MODULO>);
		return view('admin/form-<ROTA_MODULO>-imagem',$data);
	}
	public function save_imagem(Request $request){
		try{
			$post = $request->input();
			if($request->input('id')){
				\App\<NOME_MODULO>::editar_imagem($post, $request->input('id'));
			}else{
				\App\<NOME_MODULO>::criar_imagem($post);
			}
			\Session::flash('type', 'success');
            \Session::flash('message', "Alteracoes salvas com sucesso!");
			return redirect('admin/<ROTA_MODULO>');
		}catch(Exception $e){
			\Session::flash('type', 'error');
            \Session::flash('message', $e->getMessage());
            return redirect()->back();
		}
		
		
	}
	public function delete_imagem($id){
		try{
			$imagem = \App\<NOME_MODULO>::getImagem($id);
			\App\<NOME_MODULO>::deletar_imagem($id);

			\Session::flash('type', 'success');
            \Session::flash('message', "Registro removido com sucesso!");
			return redirect('admin/<ROTA_MODULO>');
		}catch(Exception $e){
			\Session::flash('type', 'error');
            \Session::flash('message', "Nao foi possível remover o registro!");
            return redirect()->back();
		}
		
		
	}

}
