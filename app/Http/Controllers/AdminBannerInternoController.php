<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AdminBannerInternoController extends Controller
{
     public function __construct(){
		$this->middleware('auth');
	}

	public function index(){
		$data['banners_internos'] = \App\BannerInterno::get();
		return view('admin/banner-interno',$data);
	}

	public function add(){
		return view('admin/form-banner-interno');
	}

	public function edit($id){
		$data['banner'] = \App\BannerInterno::find($id);
		return view('admin/form-banner-interno',$data);
	}


	public function save(Request $request){
		try{
			if($request->input('id')){
				\App\BannerInterno::editar($request->input(), $request->input('id'));
			}else{
				\App\BannerInterno::criar($request->input());
			}
			\Session::flash('type', 'success');
            \Session::flash('message', "Alteracoes salvas com sucesso!");
			return redirect('admin/banner-interno');
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
			$tmpFilePath = '/uploads/banner-interno/';
			$tmpFileName = time() . '-' . $file->getClientOriginalName();
			$file = $file->move(public_path() . $tmpFilePath, $tmpFileName);
			$path = $tmpFilePath . $tmpFileName;
			return response()->json(array('path'=> $path, 'file_name'=>$tmpFileName), 200);
		} else {
			return response()->json(false, 200);
		}
	}

	public function crop_image(Request $request) {
		$img = \Image::make('uploads/banner-interno/'.$request->input('file_name'));
		$dataCrop = json_decode($request->input('data_crop'));
		if($img->crop(intval($dataCrop->width), intval($dataCrop->height), intval($dataCrop->x), intval($dataCrop->y))->save('uploads/banner-interno/thumb_'.$request->input('file_name'))){
			@unlink('uploads/banner-interno/'.$request->input('file_name'));
			echo json_encode(array(
				'status' => true,
				'path' => '/uploads/banner-interno/thumb_'.$request->input('file_name'),
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
			\App\Paginas::deletar($id);

			\Session::flash('type', 'success');
            \Session::flash('message', "Registro removido com sucesso!");
			return redirect('admin/banner-interno');
		}catch(Exception $e){
			\Session::flash('type', 'error');
            \Session::flash('message', "Nao foi possível remover o registro!");
            return redirect()->back();
		}
		
		
	}
}
