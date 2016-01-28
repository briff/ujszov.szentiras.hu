<?php

namespace App\Http\Controllers;

use App\Model\Book;
use \View;

class HomeController extends Controller
{

    public function getIndex()
    {
        $books = Book::where('tipus', 'default')->orderBy('konyv_id')->get();
        $firstBookLength = Book::getBookLength('Mt');
        $firstChapterLength = Book::getChapterLength('Mt', 1);
        return View::make('welcome',
            [
                'books' => $books,
                'currentBook' => 1,
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
