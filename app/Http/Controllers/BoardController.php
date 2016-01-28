<?php
/**

 */

namespace App\Http\Controllers;

use App\Model\Message;
use Input;
use View;

class BoardController extends Controller {

    public function getIndex() {
        $messages = Message::where('hidden', false)->orderBy('ssz', 'desc')->paginate(50);
        return View::make('board.messageList', [
            'messages' => $messages
        ]);
    }

    public function postIndex() {
        $message = new Message();
        if (Input::get('password') == 'esik') {
            $message['nev'] = Input::get('name');
            $message['e-mail'] = Input::get('email');
            $text = htmlspecialchars(Input::get('text'));
            $message['uzenet'] = preg_replace('/\n/', '<br>', $text);
            if (!empty($message['nev'])) {
                $message->save();
            }
        }
        return $this->getIndex();
    }

} 