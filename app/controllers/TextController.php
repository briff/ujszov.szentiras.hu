<?php

/**

 */
class TextController extends BaseController
{

    public function getVerseText($bookName, $chapter, $verse) {
        $words = $this->getChapterText(Book::find($bookName)->konyv_id, $chapter);
        $words = $words->filter(function ($word) use ($verse) {
            return $word->verse == $verse;
        });
        return Response::json($words->values());
    }

    public function getIndex($bookName = false, $chapter = false, $verse = false)
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
        $words = $this->getChapterText($bookId, $chapter);
        $book = Book::findById($bookId);
        $books = Book::where('tipus', 'default')->orderBy('konyv_id')->get();
        $bookLength = Book::getBookLength($book->nev);
        $chapterLength = Book::getChapterLength($book->nev, $chapter);
        return View::make("text.displayChapter", [
            "book" => $book,
            "chapter" => $chapter,
            "words" => $words,
            "verse" => $verse,
            'books' => $books,
            'currentBook' => $book->konyv_id,
            'currentChapter' => $chapter,
            'currentVerse' => $verse,
            'currentBookLength' => $bookLength,
            'currentChapterLength' => $chapterLength
        ]);
    }

    private function replaceSpecialParts($text) {
        $replaced = htmlspecialchars(html_entity_decode($text, null, 'UTF-8'));
        $replaced = preg_replace("/([\x{0590}-\x{05FF}]+)/u", "<span lang='he'>$1</span>", $replaced);
        $replaced = preg_replace('/([[:upper:]]{2,}[[:alpha:]]*_?[[:alpha:]]*\d*|Úszsz)/u', "<abbr>$1</abbr>", $replaced);
        $replaced = preg_replace("/((Mt|Mk|Lk|Jn) (\d+),(\d+))/", "<a href='/text/$2/$3/$4' class='ref' data-poload='/text/verse-text/$2/$3/$4'>$2&nbsp;$3,$4</a>", $replaced);
        return $replaced;
    }

    public function getDetails($wordId)
    {
        $word = Word::find($wordId);
        return View::make("text.detailsModal", [
            "word" => $word
        ]);
    }

    private function getChapterText($bookId, $chapter)
    {
        $words = Word::findChapterWords($bookId, $chapter)->map(function ($dictWord) {
            $dictWord->unic = preg_replace("/ *¬/u", "˺", preg_replace("/⌐ */u", "˹", html_entity_decode($dictWord->unic, null, 'UTF-8')));
            $dictWord->szal = html_entity_decode($dictWord->szal, null, 'UTF-8');
            $dictWord->dictMeaning = $this->replaceSpecialParts($dictWord->dictEntry->mj);
            $dictWord->dictValt = $this->replaceSpecialParts($dictWord->dictEntry->valt);
            $dictWord->lj = $this->replaceSpecialParts($dictWord->lj);
            $dictWord->verse = preg_split('/,/', $dictWord->lh)[1];
            return $dictWord;
        });
        return $words;
    }

}