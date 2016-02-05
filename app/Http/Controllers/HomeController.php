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
        $firstBook = Book::findById(201);
        $firstChapterLength = Book::getChapterLength($firstBook->nev, 1);
        return View::make('welcome',
            [
                'books' => $books,
                'book' => $firstBook,
                'currentChapter' => 1,
                'currentVerse' => 1,
                'currentBookLength' => $firstBook->hossz,
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

    public function getCorpus($corpusId) {
        $books = Book::where('konyv_id', '>', $corpusId*100)->where('konyv_id', '<', $corpusId*100+100)->orderBy('konyv_id')->get();
        return Response::json( ['books' => $books]);
    }

}
