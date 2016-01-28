<?php
/**

 */

namespace App\Http\Controllers;

use App\Model\Message;

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
            $message['uzenet'] = htmlspecialchars(Input::get('text'));
            if (!empty($message['nev'])) {
                $message->save();
            }
        }
        return $this->getIndex();
    }

} 