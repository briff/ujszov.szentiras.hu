<?php
/**

 */

class TextController extends BaseController
{

    public function getIndex()
    {
        $bookId = Input::get('book');
        $chapter = Input::get('chapter');
        $verse = Input::get('verse');
        $book = Book::findById($bookId);
        $words = Word::findChapterWords($bookId, $chapter);
        return View::make("text.displayChapter", [
            "book" => $book,
            "chapter" => $chapter,
            "words" => $words
        ]);

    }

}