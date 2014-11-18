<?php
/**

 */

class Word extends Eloquent {

    protected $table = 'konyvek';
    protected $primaryKey='fh';

    public static function findChapterWords($bookId, $chapter) {
        $chapterAddress = (int) sprintf("%d%02d0000",$bookId, $chapter);
        $words = Word::where('fh', '>', $chapterAddress)->where('fh', '<', $chapterAddress + 8500)->with('dictEntry')->orderBy('fh')->get();
        return $words;
    }

    public function dictEntry() {
        return $this->hasOne('DictEntry', 'gk', 'gk');
    }

} 