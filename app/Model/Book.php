<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

/**

 */

class Book extends Model {

    protected $table = 'konyvnevek';
    protected $primaryKey = 'nev';
    public $incrementing = false;


    /**
     * @param int $id
     * @return Book
     */
    public static function findById($id) {
        return self::where('konyv_id', $id)->where('tipus', 'default')->first();
    }

    public static function getBookLength($name) {
        return self::find($name)->hossz;
    }

    public static function getChapterLength($bookName, $chapter) {
        $latestWord = Word::where('lh', 'like', "{$bookName} {$chapter},%")->orderBy('fh', 'desc')->first()->lh;
        $wordReferencePattern = "/.*? (\d+),(\d+)\w*,\d+/";
        $matches = [];
        preg_match($wordReferencePattern, $latestWord, $matches);
        return (int) $matches[2];
    }

    function __toString()
    {
        return "{$this->nev} (id:{$this->konyv_id})";
    }


} 