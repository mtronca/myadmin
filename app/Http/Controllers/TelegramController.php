<?php

namespace App\Http\Controllers;

use Telegram\Bot\Api;

class TelegramController extends Controller {

    protected $telegram;

    public function __construct()
    {
        $this->telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        //dd($this->telegram->getUpdates());
    }

    public function getUpdates()
    {
        $updates = $this->telegram->getUpdates();
        dd($updates);
        return response()->json($updates);
    }

    public function getSendMessage()
    {
        return view('send-message');
    }

    public function postSendMessage()
    {
        $rules = [
            'message' => 'required'
        ];

        $validator = \Validator::make(\Input::all(), $rules);

        if($validator->fails())
        {
            return redirect()->back()
                ->with('status', 'danger')
                ->with('message', 'Message is required');
        }
        if($this->telegram->sendMessage([
            'chat_id' => 237795139, // Chat Privado Murilo
            'text' => \Input::get('message')
        ])){
            \Session::flash('type', 'success');
            \Session::flash('message', "Mensagem enviada com sucesso!");
        }else{
            \Session::flash('type', 'error');
            \Session::flash('message', "Não foi possível enviar a mensagem.");
        }

        return \Redirect::back();
    }
}
