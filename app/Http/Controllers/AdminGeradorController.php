<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
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
		$data['campos'] = \App\CampoModulo::where('id_modulo', $data['modulo']->id)->get();
		return view('admin/form-gerador',$data);
	}

	public function save(Request $request){
		try{
			$post = $request->input();
			if($request->input('id')){
				$modulo = \App\Gerador::find($request->input('id'));
				\App\Gerador::editar($post, $request->input('id'));

				$this->updateTable($request->input(), $modulo);
			}else{
				$id_modulo = \App\Gerador::criar($post);
				$modulo = \App\Gerador::find($id_modulo);
				$this->createTable($request->input(), $modulo);
				$this->generateFiles($modulo);

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
			$modulo = \App\Gerador::find($id);

			\App\Gerador::deletar($id);

			/* Apaga a pasta do módulo recursivamente */
			$this->rrmdir('../app/Modules/'.$modulo->nome);

			$this->rrmdir('../public/uploads/'.$modulo->rota);

			/* Remove do config/module.php */
			$modules = config("module.modules");
			$str = "<?php
			# config/module.php
			return  [
			    'modules' => [
			";
			while (list(,$module) = each($modules)) {
				if($module != $modulo->nome){
					$str .= "'$module',
					";
				}
			}
			$str .= "
				]
			];";
			file_put_contents('../config/module.php',$str);

			\App\CampoModulo::where('id_modulo',$modulo->id)->delete();
			DB::statement('DROP TABLE '.$modulo->nome_tabela);
			DB::statement('DROP TABLE '.$modulo->nome_tabela.'_imagens');

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

		if(file_exists('../app/Modules/'.$modulo->nome)){
			die('Ja existe um módulo com esse nome, seu idiota !');
		}

		/* Cria as pastas */
		mkdir('../app/Modules/'.$modulo->nome, 0777, true);
		mkdir('../app/Modules/'.$modulo->nome.'/Views', 0777, true);
		mkdir('../app/Modules/'.$modulo->nome.'/Views/admin', 0777, true);
		mkdir('../app/Modules/'.$modulo->nome.'/Models', 0777, true);
		mkdir('../app/Modules/'.$modulo->nome.'/Controllers', 0777, true);
		mkdir('../app/Modules/'.$modulo->nome.'/Controllers/Admin', 0777, true);

		/* Gera o Controller */
		$text = str_replace($replaces,$by,file_get_contents("../resources/views/templates_tipo_modulo/".$tipo_modulo->controller_admin));
		file_put_contents('../app/Modules/'.$modulo->nome.'/Controllers/Admin/Admin'.$modulo->nome.'Controller.php',$text);

		/* Gera o Controller do Site */
		$text = str_replace($replaces,$by,file_get_contents("../resources/views/templates_tipo_modulo/controller_basico.php"));
		file_put_contents('../app/Modules/'.$modulo->nome.'/Controllers/'.$modulo->nome.'Controller.php',$text);

		/* Gera o Model */
		$text = str_replace($replaces,$by,file_get_contents("../resources/views/templates_tipo_modulo/".$tipo_modulo->model));
		file_put_contents('../app/Modules/'.$modulo->nome.'/Models/'.$modulo->nome.'.php',$text);

		/* Gera a View Index */
		$text = str_replace($replaces,$by,file_get_contents("../resources/views/templates_tipo_modulo/".$tipo_modulo->view_admin_index));
		file_put_contents('../app/Modules/'.$modulo->nome.'/Views/admin/'.$modulo->rota.'.blade.php',$text);

		if($tipo_modulo->id == 1){ // Com Detalhe
			/* Gera a View Form */
			$text = str_replace($replaces,$by,file_get_contents("../resources/views/templates_tipo_modulo/".$tipo_modulo->view_admin_form));
			file_put_contents('../app/Modules/'.$modulo->nome.'/Views/admin/form-'.$modulo->rota.'.blade.php',$text);
		}


		/* Gera a view Galeria */
		$text = str_replace($replaces,$by,file_get_contents("../resources/views/templates_tipo_modulo/view_form_galeria.php"));
		file_put_contents('../app/Modules/'.$modulo->nome.'/Views/admin/form-'.$modulo->rota.'-imagem.blade.php',$text);

		/* Gera a view index do site */
		file_put_contents('../app/Modules/'.$modulo->nome.'/Views/'.$modulo->rota.'.blade.php','');

		/* Gera as rotas */
		$text = str_replace($replaces,$by,file_get_contents("../resources/views/templates_tipo_modulo/".$tipo_modulo->rotas));
		file_put_contents('../app/Modules/'.$modulo->nome.'/routes.php',$text);

		/* Adiciona o módulo ao config/module.php */
		$modules = config("module.modules");

		$str = "<?php
		# config/module.php

		return  [
		    'modules' => [
		";
		while (list(,$module) = each($modules)) {
			$str .= "'$module',
			";
		}
		$str .= "'$modulo->nome'
		";
		$str .= "
			]
		];";

		file_put_contents('../config/module.php',$str);

		return true;
	}

	private function createTable($input, $modulo){
		$sqlColumns = '( id INT NOT NULL AUTO_INCREMENT, thumbnail_principal VARCHAR(255) DEFAULT NULL';
		if($modulo->id_tipo_modulo == 1){
			$sqlColumns .= ', meta_keywords TEXT DEFAULT NULL, meta_descricao TEXT DEFAULT NULL, slug VARCHAR(255) NOT NULL';
		}
		foreach ($input['campo-nome'] as $key => $nome_campo) {
			$sqlColumns .= ', ';
			switch ($input['campo-tipo-campo'][$key]) {
				case 'I':
					$tipo = 'VARCHAR';
					$valor_tipo = '(255)';
					break;
				case 'N':
					$tipo = 'DECIMAL';
					$valor_tipo = '(15,2)';
					break;
				case 'T':
					$tipo = 'TEXT';
					$valor_tipo = '';
					break;
				case 'D':
					$tipo = 'DATE';
					$valor_tipo = '';
					break;
				case 'DT':
					$tipo = 'DATETIME';
					$valor_tipo = '';
					break;
				case 'S':
					$tipo = 'TINYINT';
					$valor_tipo = '';
					break;
			}
			$sqlColumns .= $nome_campo.' '.$tipo.' '.$valor_tipo.' DEFAULT NULL';

			$campoInfo = array(
				'nome' => $nome_campo,
				'valor_padrao' => $input['campo-valor-padrao'][$key],
				'listagem' => $input['campo-listagem'][$key],
				'required' => $input['campo-required'][$key],
				'label' => $input['campo-label'][$key],
				'required' => $input['campo-required'][$key],
				'tipo_campo' => $input['campo-tipo-campo'][$key],
				'ordem' => $input['campo-ordem'][$key],
				'id_modulo' => $modulo->id,
			);
			\App\CampoModulo::criar($campoInfo);
		}
		$sqlColumns .= ', PRIMARY KEY (id))';
		DB::statement('CREATE TABLE '.$input['nome_tabela'].' '.$sqlColumns);

		DB::statement('CREATE TABLE '.$input['nome_tabela'].'_imagens (id INT NOT NULL AUTO_INCREMENT, thumbnail_principal VARCHAR (255) DEFAULT NULL, id_'.$modulo->item_modulo.' INT(11) NOT NULL, PRIMARY KEY (id))');

		if($modulo->id_tipo_modulo == 2){
			DB::statement('INSERT INTO '.$input['nome_tabela'].' (id) VALUES (1)');
		}

		return true;
	}

	private function updateTable($input, $modulo){
		if(isset($input['edit-campo-nome'])){
			foreach ($input['edit-campo-nome'] as $key => $nome_campo) {
				if($input['old-campo-nome'][$key] != $nome_campo){
					$new_name = $nome_campo;
				}else{
					$new_name = '';
				}
				switch ($input['edit-campo-tipo-campo'][$key]) {
					case 'I':
						$tipo = 'VARCHAR';
						$valor_tipo = '(255)';
						break;
					case 'N':
						$tipo = 'DECIMAL';
						$valor_tipo = '(15,2)';
						break;
					case 'T':
						$tipo = 'TEXT';
						$valor_tipo = '';
						break;
					case 'D':
						$tipo = 'DATE';
						$valor_tipo = '';
						break;
					case 'DT':
						$tipo = 'DATETIME';
						$valor_tipo = '';
						break;
					case 'S':
						$tipo = 'TINYINT';
						$valor_tipo = '';
						break;
				}
				DB::statement('ALTER TABLE '.$modulo->nome_tabela.' CHANGE COLUMN '.$input['old-campo-nome'][$key].' '.$nome_campo.' '.$tipo.' '.$valor_tipo.' DEFAULT NULL');

				$campoObject = \App\CampoModulo::where('nome', $input['old-campo-nome'][$key])->first();

				$campoInfo = array(
					'nome' => $nome_campo,
					'valor_padrao' => $input['edit-campo-valor-padrao'][$key],
					'listagem' => $input['edit-campo-listagem'][$key],
					'required' => $input['edit-campo-required'][$key],
					'label' => $input['edit-campo-label'][$key],
					'tipo_campo' => $input['edit-campo-tipo-campo'][$key],
					'ordem' => $input['edit-campo-ordem'][$key],
					'id_modulo' => $modulo->id,
				);
				\App\CampoModulo::editar($campoInfo, $campoObject->id);
			}

		}

		if(isset($input['campo-nome'])){
			foreach ($input['campo-nome'] as $key => $nome_campo) {
				switch ($input['campo-tipo-campo'][$key]) {
					case 'I':
						$tipo = 'VARCHAR';
						$valor_tipo = '(255)';
						break;
					case 'N':
						$tipo = 'DECIMAL';
						$valor_tipo = '(15,2)';
						break;
					case 'T':
						$tipo = 'TEXT';
						$valor_tipo = '';
						break;
					case 'D':
						$tipo = 'DATE';
						$valor_tipo = '';
						break;
					case 'DT':
						$tipo = 'DATETIME';
						$valor_tipo = '';
						break;
				}
				DB::statement('ALTER TABLE '.$modulo->nome_tabela.' ADD '.$nome_campo.' '.$tipo.' '.$valor_tipo.' DEFAULT NULL');

				$campoInfo = array(
					'nome' => $nome_campo,
					'valor_padrao' => $input['campo-valor-padrao'][$key],
					'listagem' => $input['campo-listagem'][$key],
					'required' => $input['campo-required'][$key],
					'label' => $input['campo-label'][$key],
					'tipo_campo' => $input['campo-tipo-campo'][$key],
					'ordem' => $input['campo-ordem'][$key],
					'id_modulo' => $modulo->id,
				);
				\App\CampoModulo::criar($campoInfo);
			}
		}


		return true;

	}

	public function rrmdir($dir) {
	  if (is_dir($dir)) {
		 $objects = scandir($dir);
		 foreach ($objects as $object) {
			if ($object != "." && $object != "..") {
			  if (is_dir($dir."/".$object))
				 $this->rrmdir($dir."/".$object);
			  else
				 unlink($dir."/".$object);
			}
		 }
		 rmdir($dir);
	  }
	}

}
