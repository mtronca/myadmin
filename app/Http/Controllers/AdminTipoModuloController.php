<?php 
 
namespace App\Http\Controllers; 
 
use Illuminate\Http\Request; 
 
use App\Http\Requests; 
 
class AdminTipoModuloController extends Controller 
{ 
    public function __construct(){ 
    $this->middleware('auth'); 
  } 
 
  public function index(){ 
    $data['tipos'] = \App\TipoModulo::get(); 
    return view('admin/tipo-modulo',$data); 
  } 
 
  public function add(){ 
    $data = array(); 
    return view('admin/form-tipo-modulo', $data); 
  } 
 
  public function edit($id){ 
    $data['tipo'] = \App\TipoModulo::find($id); 
    return view('admin/form-tipo-modulo',$data); 
  } 
 
  public function save(Request $request){ 
    try{ 
      $post = $request->input(); 
      if($request->input('id')){ 
        \App\TipoModulo::editar($post, $request->input('id')); 
      }else{ 
        \App\TipoModulo::criar($post); 
      } 
      \Session::flash('type', 'success'); 
            \Session::flash('message', "Alteracoes salvas com sucesso!"); 
      return redirect('admin/tipo-modulo'); 
    }catch(Exception $e){ 
      \Session::flash('type', 'error'); 
            \Session::flash('message', $e->getMessage()); 
            return redirect()->back(); 
    } 
     
     
  } 
 
  public function delete($id){ 
    try{ 
      \App\TipoModulo::deletar($id); 
 
      \Session::flash('type', 'success'); 
            \Session::flash('message', "Registro removido com sucesso!"); 
      return redirect('admin/tipo-modulo'); 
    }catch(Exception $e){ 
      \Session::flash('type', 'error'); 
            \Session::flash('message', "Nao foi possivel remover o registro!"); 
            return redirect()->back(); 
    } 
     
     
  } 
 
} 
