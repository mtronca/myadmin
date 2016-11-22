<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AdminGeradorController extends Controller
{
    public function __construct(){
		$this->middleware('auth');
	}

	public function index(){
		$data['modulos'] = \App\Gerador::get();
		return view('admin/gerador',$data);
	}

	public function add(){
		$data = array();
		$data['tipos'] = \App\TipoModulo::get();
		return view('admin/form-gerador', $data);
	}

	public function edit($id){
		$data['modulo'] = \App\Gerador::find($id);
		$data['tipos'] = \App\TipoModulo::get();
		return view('admin/form-gerador',$data);
	}

	public function save(Request $request){
		try{
			$post = $request->input();
			if($request->input('id')){
				\App\Gerador::editar($post, $request->input('id'));
			}else{
				$id_modulo = \App\Gerador::criar($post);
				$this->generateFiles(\App\Gerador::find($id_modulo));
			}
			\Session::flash('type', 'success');
            \Session::flash('message', "Alteracoes salvas com sucesso!");
			return redirect('admin/gerador');
		}catch(Exception $e){
			\Session::flash('type', 'error');
            \Session::flash('message', $e->getMessage());
            return redirect()->back();
		}
		
		
	}

	public function delete($id){
		try{
			\App\Gerador::deletar($id);

			\Session::flash('type', 'success');
            \Session::flash('message', "Registro removido com sucesso!");
			return redirect('admin/gerador');
		}catch(Exception $e){
			\Session::flash('type', 'error');
            \Session::flash('message', "Nao foi possível remover o registro!");
            return redirect()->back();
		}
		
		
	}

	private function generateFiles($modulo){
		$tipo_modulo = \App\TipoModulo::find($modulo->id_tipo_modulo);
		$replaces = array('<NOME_MODULO>','<ID_MODULO>','<ROTA_MODULO>','<ITEM_MODULO>','<ITEMS_MODULO>','<NOME_TABELA>','<LABEL_MODULO>');
		$by = array($modulo->nome,$modulo->id,$modulo->rota,$modulo->item_modulo,$modulo->items_modulo,$modulo->nome_tabela,$modulo->label);

		/* Gera o Controller */
		$path = "../resources/views/templates_tipo_modulo/".$tipo_modulo->controller_admin;
		$myfile = fopen($path, "r") or die("Unable to open file!");
		$text = str_replace($replaces,$by,fread($myfile,filesize($path)));
		fclose($myfile);
		file_put_contents('../app/Http/Controllers/Admin'.$modulo->nome.'Controller.php',$text);

		/* Gera o Model */
		$path = "../resources/views/templates_tipo_modulo/".$tipo_modulo->model;
		$myfile = fopen($path, "r") or die("Unable to open file!");
		$text = str_replace($replaces,$by,fread($myfile,filesize($path)));
		fclose($myfile);
		file_put_contents('../app/'.$modulo->nome.'.php',$text);

		/* Gera a View Index */
		$path = "../resources/views/templates_tipo_modulo/".$tipo_modulo->view_admin_index;
		$myfile = fopen($path, "r") or die("Unable to open file!");
		$text = str_replace($replaces,$by,fread($myfile,filesize($path)));
		fclose($myfile);
		file_put_contents('../resources/views/admin/'.$modulo->rota.'.blade.php',$text);

		/* Gera a View Form */
		$path = "../resources/views/templates_tipo_modulo/".$tipo_modulo->view_admin_form;
		$myfile = fopen($path, "r") or die("Unable to open file!");
		$text = str_replace($replaces,$by,fread($myfile,filesize($path)));
		fclose($myfile);
		file_put_contents('../resources/views/admin/form-'.$modulo->rota.'.blade.php',$text);

		/* Gera a view Galeria */
		$path = "../resources/views/templates_tipo_modulo/view_form_galeria.php";
		$myfile = fopen($path, "r") or die("Unable to open file!");
		$text = str_replace($replaces,$by,fread($myfile,filesize($path)));
		fclose($myfile);
		file_put_contents('../resources/views/admin/form-'.$modulo->rota.'-imagens.blade.php',$text);

		/* Gera as rotas */
		$path = "../resources/views/templates_tipo_modulo/".$tipo_modulo->rotas;
		$myfile = fopen($path, "r") or die("Unable to open file!");
		$text = str_replace($replaces,$by,fread($myfile,filesize($path)));
		fclose($myfile);
		file_put_contents('../app/Http/routes.php',$text, FILE_APPEND);

		return true;
	}

}
