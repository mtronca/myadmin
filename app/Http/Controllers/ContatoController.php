<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Http\Requests;
use Telegram\Bot\Api;

class ContatoController extends Controller
{
    protected $telegram;

    public function __construct(){
        $this->telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
    }

    public function index(){
        $data['banner_interno'] = \App\BannerInterno::find(5);
    	$data['contato'] = \App\Contato::find(1);
    	return view('contato', $data);
    }

    public function send(Request $request){
    	$post = $request->input();

    	$contato = \App\Contato::find(1);

    	try{ 
            if(Mail::send('emails.contato', $post, function ($m) use ($contato){
                $m->from(env('MAIL_USERNAME'), 'Solar de Garopaba (Site)');
                $m->to($contato->email_receptor)->subject('Contato do Site');
            })){
                $this->telegram->sendMessage([
                    'chat_id' => env("CHAT_ID"),
                    'text' => 'Um contato foi realizado em Solar de Garopaba (Site)',
                ]);
                \App\Contato::criarRegistro($post);
                $json = array(
                    'status' => true,
                    'message' => 'E-mail enviado com sucesso.'
                );

            }else{
                $json = array(
                    'status' => false,
                    'message' => 'Não foi possível enviar o e-mail. Tente novamente.'
                );

            }
        }catch(Exception $e){
            $json = array(
                'status' => false,
                'message' => $e->getMessage()
            );

        }

        echo json_encode($json);
    }
}
