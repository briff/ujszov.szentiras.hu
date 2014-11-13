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

} 