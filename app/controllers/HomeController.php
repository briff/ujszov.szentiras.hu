<?php

class HomeController extends BaseController {

	public function getIndex()
	{
        $books = Book::where('tipus', 'default')->orderBy('konyv_id')->get();
        return View::make('welcome', [ 'books' => $books]);
	}

    public function getHelp() {
        return View::make('help');
    }

}
