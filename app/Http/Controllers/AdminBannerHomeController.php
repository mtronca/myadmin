<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AdminBannerHomeController extends Controller
{
    public function __construct(){
		$this->middleware('auth');
	}

	public function index(){
		$data['banner'] = \App\BannerHome::find(1);
		return view('admin/banner-home',$data);
	}

	public function save(Request $request){
		$banner = \App\BannerHome::find(1);
		if($banner){
			try{
				\App\BannerHome::editar($request->input(), 1);
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
		return redirect('/admin/banner-home');
	}

	public function upload_image(Request $request) {
		if($request->hasFile('file')) {
			//upload an image to the /img/tmp directory and return the filepath.
			$file = $request->file('file');
			$tmpFilePath = '/uploads/banner-home/';
			$tmpFileName = time() . '-' . $file->getClientOriginalName();
			$file = $file->move(public_path() . $tmpFilePath, $tmpFileName);
			$path = $tmpFilePath . $tmpFileName;
			return response()->json(array('path'=> $path, 'file_name'=>$tmpFileName), 200);
		} else {
			return response()->json(false, 200);
		}
	}

	public function crop_image(Request $request) {
		$img = \Image::make('uploads/banner-home/'.$request->input('file_name'));
		$dataCrop = json_decode($request->input('data_crop'));
		if($img->crop(intval($dataCrop->width), intval($dataCrop->height), intval($dataCrop->x), intval($dataCrop->y))->save('uploads/banner-home/thumb_'.$request->input('file_name'))){
			@unlink('uploads/banner-home/'.$request->input('file_name'));
			echo json_encode(array(
				'status' => true,
				'path' => '/uploads/banner-home/thumb_'.$request->input('file_name'),
				'file_name' => 'thumb_'.$request->input('file_name'),
			));
		}else{
			echo json_encode(array(
				'status' => false,
				'message' => 'Não foi possível alterar a imagem.'
			));
		}

	}

}
