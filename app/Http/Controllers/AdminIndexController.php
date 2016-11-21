<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;

class AdminIndexController extends Controller
{
	public function __construct(){
		$this->middleware('auth'/*, array('only' => array(
				'edit',
				'save'
			))*/);
	}

	public function index(){
		$data = array();
		return view('admin/index',$data);
	}


}
