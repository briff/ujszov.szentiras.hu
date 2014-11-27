<?php

/**

 */
class TextController extends BaseController
{

    public function getByWordId($wordId) {
        $ref = $this->createWordRef(Word::find($wordId));
        return Redirect::to("/text/{$ref['bookName']}/{$ref['chapter']}/{$ref['verse']}#!{$wordId}");
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

    private function replaceSpecialParts($text)
    {
        $replaced = htmlspecialchars(html_entity_decode($text, null, 'UTF-8'));
        $replaced = preg_replace("/([\x{0590}-\x{05FF}]+)/u", "<span lang='he'>$1</span>", $replaced);
        $replaced = preg_replace('/([[:upper:]]{2,}[[:alpha:]]*_?[[:alpha:]]*\d*|Úszsz)/u', "<abbr class='literature'>$1</abbr>", $replaced);
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
            $dictWord->szf = $this->formatLexicalClass($dictWord->szf);
            $dictWord->elem = $this->formatMorphs($dictWord->elem);
            return $dictWord;
        });
        return $words;
    }

    public function formatLexicalClass($classString) {
        return preg_replace("/([[:alpha:]\.]+)/", "<abbr class='morph'>$1</abbr>", $classString);
    }

    public function formatMorphs($morphString) {
        $result = "";
        $declinationAnalysis = [];
        preg_match("/(\w+\(\w+\)\.)/", $morphString, $declinationAnalysis);
        $morphString = preg_replace("/\w+\(\w+\)\./", "", $morphString);
        $sentenceAnalysis = [];
        $sentencePattern = "/(\((?:\w|[ \.])+\))/";
        preg_match($sentencePattern, $morphString, $sentenceAnalysis);
        $morphString = preg_replace($sentencePattern, "", $morphString);
        $newMorphString = preg_replace("/(\w+\.)/", "<abbr class='morph'>$1</abbr> ", $morphString);
        for ($i = 1; $i<count($declinationAnalysis); $i++) {
            $newMorphString .= "<abbr class='morph'>{$declinationAnalysis[$i]}</abbr>";
        }
        for ($i = 1; $i<count($sentenceAnalysis); $i++) {
            $newMorphString .= "<abbr class='morph'>{$sentenceAnalysis[$i]}</abbr>";
        }
        return $newMorphString;
    }

    public function getVerseText($bookName, $chapter, $verse)
    {
        $words = $this->getChapterText(Book::find($bookName)->konyv_id, $chapter);
        $words = $words->filter(function ($word) use ($verse) {
            return $word->verse == $verse;
        });
        return Response::json($words->values());
    }

    public function getConcordance($wordId)
    {

        return Response::json($this->findConcordance($wordId));
    }

    private function createWordRef($word) {
        if ($word !== null) {
            $wordId = $word->fh;
            $ref['id'] = $wordId;
            $matches = [];
            preg_match("/^(\d{1,2}?)(\d{2})(\d{2})(\d{2})$/", $wordId, $matches);
            $ref['bookId'] = (int) $matches[1];
            $ref['bookName'] = Book::findById($ref['bookId'])->nev;
            $ref['chapter'] = (int) $matches[2];
            $ref['verse'] = (int) $matches[3];
            $ref['wordNum'] = (int) $matches[4];
            return $ref;
        } else {
            return null;
        }
    }

    private function findConcordance($wordId) {
        $concordance = [];
        $word = Word::find($wordId);
        $concordance['first'] = $this->createWordRef(Word::where('szal', $word->szal)->groupBy('szal')->first());
        $concordance['previous'] = $this->createWordRef(Word::where('szal', $word->szal)->where('fh', '<', $wordId)->orderBy('fh', 'desc')->first());
        $concordance['next'] = $this->createWordRef(Word::where('szal', $word->szal)->where('fh', '>', $wordId)->orderBy('fh')->first());
        $concordance['nextAlphabetic'] = $this->createWordRef(Word::find($word->fkh));
        $concordance['previousAlphabetic'] = $this->createWordRef(Word::find($word->feh));
        return $concordance;
    }
}