<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Mail;
use Telegram\Bot\Api;

class ApartamentosController extends Controller
{
    protected $telegram;

    public function __construct(){
        $this->telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
    }

    public function index(){
        $data['banner_interno'] = \App\BannerInterno::find(3);
        $data['texto_apartamentos'] = \App\Paginas::find(3);
    	$data['apartamentos'] = \App\Apartamentos::get();
    	foreach($data['apartamentos'] as $apartamento){
            $apartamento->caracteristicas = \App\Apartamentos::getCaracteristicas($apartamento->id);
        }
    	return view('apartamentos', $data);
    }

    public function detalhe($slug){
        $data['banner_interno'] = \App\BannerInterno::find(3);
    	$data['apartamento'] = \App\Apartamentos::getBySlug($slug);
        $item = $data['apartamento'];

        /* SEO */
        $data['meta_keywords'] = $item->meta_keywords;
        $data['meta_descricao'] = $item->meta_descricao;

        $data['apartamento']->caracteristicas = \App\Apartamentos::getCaracteristicas($item->id);
    	$data['apartamento']->reservas = \App\Apartamentos::getReservas($item->id);
        $data['apartamento']->imagens = \App\Apartamentos::getImagens($item->id);

    	return view('apartamentos-detalhe', $data);
    }

    public function solicitar(Request $request){

        try{

            $post = $request->input();
            $a = $post['data_entrada'];
            $post['data_entrada'] = substr($a,6,4).'-'.substr($a,3,2).'-'.substr($a,0,2);
            $a = $post['data_saida'];
            $post['data_saida'] = substr($a,6,4).'-'.substr($a,3,2).'-'.substr($a,0,2);

            if($post['data_entrada'] <= $post['data_saida']){
                if($post['data_entrada'] >= date('Y-m-d')){
                    \App\Apartamentos::salvar_solicitacao($post);

                    $contato = \App\Contato::find(1);
                    Mail::send('emails.solicitacao', $post, function ($m) use ($contato){
                        $m->from(env('MAIL_USERNAME'), 'Solar de Garopaba (Site)');
                        $m->to($contato->email_receptor)->subject('Solicitação de Reserva');
                    });

                    $this->telegram->sendMessage([
                        'chat_id' => env("CHAT_ID"),
                        'text' => 'Uma solicitação de reserva foi realizada em Solar de Garopaba (Site). ID do Apartamento: '.$post['id_apartamento'].', Nome do Apartamento: '.$post['nome_apartamento'],
                    ]);

                    $json = array(
                        'status' => true,
                        'message' => 'Solicitação enviada com sucesso !',
                    ); 
                }else{
                    $json = array(
                        'status' => false,
                        'message' => 'A data de entrada deve ser posterior à data atual.',
                    );
                }
                
            }else{
                $json = array(
                    'status' => false,
                    'message' => 'A data de saída deve ser posterior à data de entrada.',
                );
            }
        }catch(Exception $e){
             $json = array(
                'status' => false,
                'message' => $e->getMessage(),
            );
        }

        echo json_encode($json);
        exit;
    }

}
