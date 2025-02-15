<?php

namespace App\Http\Controllers;

use App\Model\Book;

class WordController extends Controller
{

    private $step = 1000;
    
    private $textController;

    /**
     */
    public function __construct() {
        $this->textController = \App::make('App\Http\Controllers\TextController');
    }

    public function getIndex() {

        $start = 10;
        $end = 200000;
        $step = 1000;

        $allEntries = collect(); // Initialize an empty collection to store entries

    for ($rangeStart = $start; $rangeStart <= $end; $rangeStart += $step) {
        $rangeEnd = $rangeStart + $step - 1;

        // Ensure the last range doesn't exceed the maximum value
        if ($rangeEnd > $end) {
            $rangeEnd = $end;
        }

    // Fetch first entries within the current range
    $firstEntry = \App\Model\DictEntry::where('strong', '!=', '')
        ->whereBetween('gk', [$rangeStart, $rangeEnd])
        ->orderBy('gk', 'asc')
        ->first();
    $lastEntry = \App\Model\DictEntry::where('strong', '!=', '')
        ->whereBetween('gk', [$rangeStart, $rangeEnd])
        ->orderBy('gk', 'desc')
        ->first();        

    // You can process $entries here as needed
    // For demonstration, let's merge them into $allEntries
        if (!empty($firstEntry) && !empty($lastEntry)) {
            $allEntries[]  = ['first' => $firstEntry, 'last' => $lastEntry];
        } else {
            break;
        }
    }

    // After processing all ranges, return the view with the collected entries
    return view('words', ['words' => $allEntries]);    
}

  public function getSection($from, $to) {
        $entries = \App\Model\DictEntry
            ::whereBetween('gk', [$from, $from+$this->step])
            ->orderBy('gk', 'asc')
            ->get();
        return view('wordsections', ['words' => $entries]);
    }

    public function getSearch($gk) {
        $word = \App\Model\DictEntry::where('gk', $gk)->first();

        $occurrences = \App\Model\Word
        ::where('gk', $gk)
        ->limit(100)
        ->get();
        $results = [];
        foreach ($occurrences as $occurrence) {
            $wordRef = $this->textController->createWordRef($occurrence);
            $text = $this->textController->getVerseTextArray($wordRef['bookName'], $wordRef['chapter'], $wordRef['verse']);
            $results[] = ['ref' => $wordRef, 'text' => $text];
        }

        return view('wordoccurrences', ['words' => $results, 'word' => $word]);
    }

    public function getByMj() {
        $mj = request('mj');
        $entries = \App\Model\DictEntry::where('mj', 'like', "%$mj%")->limit(100)->get();
        return view('wordsections', ['words' => $entries]);
    }

}
