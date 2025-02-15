<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

/**

 */
class Word extends Model
{

    protected $table = 'konyvek';
    protected $primaryKey = 'fh';
    protected $guarded = [];

    public static function findChapterWords($bookId, $chapter, $withEntry = true)
    {
        $chapterAddress = sprintf("%d%03d", $bookId, $chapter);
        $words = Word::where('fh', 'like', "{$chapterAddress}%");
        $words = $words->with('dictEntry');
        $words = $words->orderBy('fh')->get();
        return $words;
    }

    public function dictEntry()
    {
        return $this->hasOne(DictEntry::class, 'gk', 'gk');
    }

} 