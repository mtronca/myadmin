<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class CustomerController extends Controller
{
    public function __construct(){
      $this->middleware('auth');
      $this->middleware('murilo');
    }
    public function index(){
      $data = array();
      $data['customers'] = \App\Customer::get();
      return view('customer', $data);
    }
}
