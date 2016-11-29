<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Http\Requests;

class <NOME_MODULO>Controller extends Controller
{
	private $modulo;
	private $fields;

    public function __construct(){
		$this->modulo = \App\Gerador::find(<ID_MODULO>);
		$this->fields = \App\CampoModulo::where('id_modulo',<ID_MODULO>)->get();
	}

	public function index(){
		$data = array();
		return view('<ROTA_MODULO>',$data);
	}
}
