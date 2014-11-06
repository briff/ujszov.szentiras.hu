<?php
/**

 */

class Word extends Eloquent {

    protected $table = 'konyvek';
    protected $primaryKey='fh';

    public static function findChapterWords($bookId, $chapter) {
        $chapterAddress = (int) sprintf("%d%02d0000",$bookId, $chapter);
        $words = Word::where('fh', '>', $chapterAddress)->where('fh', '<', $chapterAddress + 8500)->orderBy('fh')->get();
        return $words;
    }

} 