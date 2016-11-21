<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;


class InstitucionalController extends Controller
{

    public function index(){
    	$data['banner_interno'] = \App\BannerInterno::find(1);
    	$data['institucional'] = \App\Institucional::find(1);
    	$data['institucional']->imagens = \App\Institucional::getImagens();
    	
    	return view('institucional', $data);
    }

}
