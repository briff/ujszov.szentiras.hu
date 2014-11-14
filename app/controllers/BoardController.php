<?php
/**

 */

class BoardController extends BaseController {

    public function getIndex() {
        $messages = Message::orderBy('datum', 'desc')->paginate(50);
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
            $message['datum'] = date("Y.m.d. H:i:s");
            $message->save();
        }
        return $this->getIndex();
    }

} 