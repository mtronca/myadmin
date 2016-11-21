<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Http\Requests;

class AdminApartamentosController extends Controller
{
     public function __construct(){
		$this->middleware('auth');
	}

	public function index(){
		$data['apartamentos'] = \App\Apartamentos::get();
		return view('admin/apartamentos',$data);
	}

	public function add(){
		return view('admin/form-apartamentos');
	}

	public function edit($id){
		$data['apartamento'] = \App\Apartamentos::find($id);
		$data['apartamento']->caracteristicas = \App\Apartamentos::getCaracteristicas($id);
		$data['apartamento']->solicitacoes = \App\Apartamentos::getSolicitacoes($id);
		$data['apartamento']->reservas = \App\Apartamentos::getReservas($id);
		$data['apartamento']->imagens = \App\Apartamentos::getImagens($id);
		return view('admin/form-apartamentos',$data);
	}

	public function add_reserva($id){
		$data['apartamento'] = \App\Apartamentos::find($id);
		$data['apartamento']->reservas = \App\Apartamentos::getReservas($id);
		return view('admin/form-reservas',$data);
	}

	public function edit_reserva($id){
		$data['reserva'] = \App\Apartamentos::getReserva($id);
		$item = $data['reserva'];
		$data['apartamento'] = \App\Apartamentos::find($item->id_apartamento);
		$data['apartamento']->reservas = \App\Apartamentos::getReservasDiff($item->id_apartamento, $id);

		return view('admin/form-reservas',$data);
	}


	public function save(Request $request){
		try{
			$post = $request->input();
			$post['slug'] = $this->slugify($post['titulo']);
			if($request->input('id')){
				\App\Apartamentos::editar($post, $request->input('id'));
			}else{
				\App\Apartamentos::criar($post);
			}
			\Session::flash('type', 'success');
            \Session::flash('message', "Alteracoes salvas com sucesso!");
			return redirect('admin/apartamentos');
		}catch(Exception $e){
			\Session::flash('type', 'error');
            \Session::flash('message', $e->getMessage());
            return redirect()->back();
		}
		
		
	}

	public function aprovar_solicitacao($id){
		try{
			$solicitacao = \App\Apartamentos::getSolicitacao($id);
			$apartamento = \App\Apartamentos::find($solicitacao->id_apartamento);
			$info = array(
				'id_apartamento' => $solicitacao->id_apartamento,
				'nr_adultos' => $solicitacao->nr_adultos,
				'nr_criancas' => $solicitacao->nr_criancas,
				'data_entrada' => $solicitacao->data_entrada,
				'data_saida' => $solicitacao->data_saida,
				'nome' => $solicitacao->nome,
				'email' => $solicitacao->email,
			);
		
			\App\Apartamentos::criar_reserva($info);

			\App\Apartamentos::aprovar_solicitacao($id);

			$solicitacao_aprovada = array(
				'nome' => $solicitacao->nome,
				'data_entrada' => date('d/m/Y', strtotime($solicitacao->data_entrada)),
				'data_saida' => date('d/m/Y', strtotime($solicitacao->data_saida)),
				'nome_apartamento' => $apartamento->nome,
				'nr_adultos' => $solicitacao->nr_adultos,
				'nr_criancas' => $solicitacao->nr_criancas,
			);

			Mail::send('emails.solicitacao_aprovada', $solicitacao_aprovada, function ($m) use ($solicitacao){
                $m->from(env('MAIL_USERNAME'), 'Solar de Garopaba (Site)');
                $m->to($solicitacao->email)->subject('Reserva Aprovada (Solar de Garopaba)');
            });
		
			\Session::flash('type', 'success');
            \Session::flash('message', "Alteracoes salvas com sucesso!");
			return redirect('admin/apartamentos/edit/'.$solicitacao->id_apartamento);
		}catch(Exception $e){
			\Session::flash('type', 'error');
            \Session::flash('message', $e->getMessage());
            return redirect()->back();
		}
		
		
	}

	public function save_reserva(Request $request){
		try{
			$post = $request->input();

            $a = $post['data_entrada'];
            $post['data_entrada'] = substr($a,6,4).'-'.substr($a,3,2).'-'.substr($a,0,2);
            $a = $post['data_saida'];
            $post['data_saida'] = substr($a,6,4).'-'.substr($a,3,2).'-'.substr($a,0,2);

			if($request->input('id')){
				\App\Apartamentos::editar_reserva($post, $request->input('id'));
			}else{
				\App\Apartamentos::criar_reserva($post);
			}
			\Session::flash('type', 'success');
            \Session::flash('message', "Alteracoes salvas com sucesso!");
			return redirect('admin/apartamentos/edit/'.$post['id_apartamento']);
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
			$tmpFilePath = '/uploads/apartamentos/';
			$tmpFileName = time() . '-' . $file->getClientOriginalName();
			$file = $file->move(public_path() . $tmpFilePath, $tmpFileName);
			$path = $tmpFilePath . $tmpFileName;
			return response()->json(array('path'=> $path, 'file_name'=>$tmpFileName), 200);
		} else {
			return response()->json(false, 200);
		}
	}

	public function crop_image(Request $request) {
		$img = \Image::make('uploads/apartamentos/'.$request->input('file_name'));
		$dataCrop = json_decode($request->input('data_crop'));
		if($img->crop(intval($dataCrop->width), intval($dataCrop->height), intval($dataCrop->x), intval($dataCrop->y))->save('uploads/apartamentos/thumb_'.$request->input('file_name'))){
			@unlink('uploads/apartamentos/'.$request->input('file_name'));
			echo json_encode(array(
				'status' => true,
				'path' => '/uploads/apartamentos/thumb_'.$request->input('file_name'),
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
			\App\Apartamentos::deletar($id);

			\Session::flash('type', 'success');
            \Session::flash('message', "Registro removido com sucesso!");
			return redirect('admin/apartamentos');
		}catch(Exception $e){
			\Session::flash('type', 'error');
            \Session::flash('message', "Nao foi possivel remover o registro!");
            return redirect()->back();
		}
		
		
	}

	public function delete_reserva($id){
		try{
			$reserva = \App\Apartamentos::getReserva($id);
			\App\Apartamentos::deletar_reserva($id);

			\Session::flash('type', 'success');
            \Session::flash('message', "Registro removido com sucesso!");
			return redirect('admin/apartamentos/edit/'.$reserva->id_apartamento);
		}catch(Exception $e){
			\Session::flash('type', 'error');
            \Session::flash('message', "Nao foi possivel remover o registro!");
            return redirect()->back();
		}
		
		
	}

	public function delete_solicitacao($id){
		try{
			$solicitacao = \App\Apartamentos::getSolicitacao($id);
			\App\Apartamentos::deletar_solicitacao($id);

			\Session::flash('type', 'success');
            \Session::flash('message', "Registro removido com sucesso!");
			return redirect('admin/apartamentos/edit/'.$solicitacao->id_apartamento);
		}catch(Exception $e){
			\Session::flash('type', 'error');
            \Session::flash('message', "Nao foi possivel remover o registro!");
            return redirect()->back();
		}
		
		
	}

	public function add_imagem($id){
		$data['apartamento'] = \App\Apartamentos::find($id);
		return view('admin/form-apartamento-imagem', $data);
	}

	public function edit_imagem($id){
		$data['imagem'] = \App\Apartamentos::getImagem($id);
		$item = $data['imagem'];
		$data['apartamento'] = \App\Apartamentos::find($item->id_apartamento);
		return view('admin/form-apartamento-imagem',$data);
	}
	public function save_imagem(Request $request){
		try{
			$post = $request->input();
			if($request->input('id')){
				\App\Apartamentos::editar_imagem($post, $request->input('id'));
			}else{
				\App\Apartamentos::criar_imagem($post);
			}
			\Session::flash('type', 'success');
            \Session::flash('message', "Alteracoes salvas com sucesso!");
			return redirect('admin/apartamentos/edit/'.$post['id_apartamento']);
		}catch(Exception $e){
			\Session::flash('type', 'error');
            \Session::flash('message', $e->getMessage());
            return redirect()->back();
		}
		
		
	}
	public function delete_imagem($id){
		try{
			$imagem = \App\Apartamentos::getImagem($id);
			\App\Apartamentos::deletar_imagem($id);

			\Session::flash('type', 'success');
            \Session::flash('message', "Registro removido com sucesso!");
			return redirect('admin/apartamentos/edit/'.$imagem->id_apartamento);
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
