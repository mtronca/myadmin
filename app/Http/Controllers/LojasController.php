<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;


class LojasController extends Controller
{

    public function index(){
    	$data['banner_interno'] = \App\BannerInterno::find(4);
    	$data['lojas'] = \App\Lojas::find(1);
    	$data['lojas']->imagens = \App\Lojas::getImagens();
    	return view('lojas', $data);
    }
}
