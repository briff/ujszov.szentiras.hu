<?php

namespace App\Http\Controllers;

use App\Model\Word;
use DB;

class WordUpdater extends AbstractUpdater {

    protected function truncate()
    {
        Word::truncate();
    }

    protected function storeLines($lines)
    {
        $entries = array_map(function ($line) {
            return $this->createWord($line);
        }, $lines);
        DB::table("{$this->tablePrefix}konyvek")->insert($entries);
    }

    private function createWord($line)
    {
        $word = [];
        $i = 0;

        $word['lh'] = $line[$i++];
        $word['fh'] = $line[$i++];
        $word['igecsop'] = $line[$i++];
        $word['unic'] = $line[$i++];
        $word['grae'] = $line[$i++];
        $word['rk'] = $line[$i++];
        $word['ef'] = $line[$i++];
        $word['lj'] = $line[$i++];
        $word['mj'] = $line[$i++];
        $word['szf'] = $line[$i++];
        $word['elem'] = $line[$i++];
        $word['bk'] = $line[$i++];
        $word['felelos'] = $line[$i++];
        $word['gk'] = $line[$i++];
        $word['szal'] = $line[$i++];
        $word['hj'] = $line[$i++];

        return $word;
    }


    protected function validateLine($line)
    {
        $valid = count($line) >= 17;
        if ($valid) {
            $valid = preg_match("/\d+\w?/", $line[1]);
        }
        return $valid;
    }
}