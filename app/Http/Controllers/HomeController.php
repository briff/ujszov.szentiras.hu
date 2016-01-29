<?php

namespace App\Http\Controllers;

use App\Model\Book;
use Response;
use \View;

class HomeController extends Controller
{

    public function getIndex()
    {
        $books = Book::
            where('tipus', 'default')
            ->where('konyv_id','>=',200)
            ->where('konyv_id', '<', 300)
            ->orderBy('konyv_id')->get()->toArray();
        $firstBookLength = Book::getBookLength('Mt');
        $firstChapterLength = Book::getChapterLength('Mt', 1);
        return View::make('welcome',
            [
                'books' => $books,
                'currentBook' => 201,
                'currentChapter' => 1,
                'currentVerse' => 1,
                'currentBookLength' => $firstBookLength,
                'currentChapterLength' => $firstChapterLength
            ]);
    }

    public function getHelp()
    {
        return View::make('help');
    }

    public function getRovjegyz()
    {
        return View::make('rovjegyz');
    }

    public function getLinkek()
    {
        return View::make('linkek');
    }

    public function getDownload()
    {
        return View::make('download');
    }

    public function getChapterLength($bookId, $chapter) {
        $book = Book::findById($bookId);
        return Response::json(
            [
                'bookLength' => Book::getBookLength($book->nev),
                'chapterLength' => Book::getChapterLength($book->nev, $chapter)
            ]
        );
    }

}
