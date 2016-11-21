<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;


class DicasController extends Controller
{

    public function index(){
        $data['banner_interno'] = \App\BannerInterno::find(2);
    	$data['categorias'] = \App\Dicas::getListaCategorias();
    	foreach($data['categorias'] as $categoria){
    		$categoria->dicas = \App\Dicas::where('id_categoria',$categoria->id)->get();
    	}
    	$data['oquefazer'] = \App\Paginas::find(2);
    	return view('dicas', $data);
    }

    public function detalhe($slug){
        $data['banner_interno'] = \App\BannerInterno::find(2);
    	$data['dica'] = \App\Dicas::getBySlug($slug);

        /* SEO */
        $data['meta_keywords'] = $item->meta_keywords;
        $data['meta_descricao'] = $item->meta_descricao;
    	
    	return view('dicas-detalhe', $data);
    }
}
