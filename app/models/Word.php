<?php

/**

 */
class Word extends Eloquent
{

    protected $table = 'konyvek';
    protected $primaryKey = 'fh';
    protected $guarded = [];

    public static function findChapterWords($bookId, $chapter)
    {
        $chapterAddress = sprintf("%d%03d", $bookId, $chapter);
        $words = Word::where('fh', 'like', "{$chapterAddress}%")->with('dictEntry')->orderBy('fh')->get();
        return $words;
    }

    public function dictEntry()
    {
        return $this->hasOne('DictEntry', 'gk', 'gk');
    }

} 