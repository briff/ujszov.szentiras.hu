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

    public function getRovjegyz() {
        return View::make('rovjegyz');
    }

    public function getLinkek() {
        return View::make('linkek');
    }

    public function getDownload() {
        return View::make('download');
    }

}
