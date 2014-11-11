<?php
/**

 */

class TextController extends BaseController
{

    public function getIndex($bookName=false, $chapter=false, $verse=false)
    {
        if ($bookName) {
            $bookId = Book::where('nev', $bookName)->first()->konyv_id;
        } else {
            $bookId = Input::get('book');
        }
        if (!$chapter) {
            $chapter = Input::get('chapter');
            if (!$chapter) {
                $chapter = 1;
            }
        }
        if (!$verse) {
            $verse = Input::get('verse');
        }
        $book = Book::findById($bookId);
        $words = Word::findChapterWords($bookId, $chapter)->filter(function($dictWord) {
          $dictWord->unic = html_entity_decode($dictWord->unic, null, 'UTF-8');
          $dictWord->szal = html_entity_decode($dictWord->szal, null, 'UTF-8');
          return $dictWord;
        });
        return View::make("text.displayChapter", [
            "book" => $book,
            "chapter" => $chapter,
            "words" => $words,
            "verse" => $verse
        ]);
    }

    public function getDetails($wordId) {
        $word = Word::find($wordId);
        return View::make("text.detailsModal", [
            "word" => $word
        ]);
    }

}