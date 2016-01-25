<?php

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

        $word['lh'] = $line[0];
        $word['fh'] = $line[1];
        $word['feh'] = $line[2];
        $word['fkh'] = $line[3];
        $word['unic'] = $line[4];
        $word['grae'] = $line[5];
        $word['rk'] = $line[6];
        $word['ef'] = $line[7];
        $word['lj'] = $line[8];
        $word['mj'] = $line[9];
        $word['szf'] = $line[10];
        $word['elem'] = $line[11];
        $word['bk'] = $line[12];
        $word['felelos'] = $line[13];
        $word['gk'] = $line[14];
        $word['hj'] = $line[15];
        $word['szal'] = $line[16];

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