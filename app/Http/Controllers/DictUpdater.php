<?php
/**

 */

namespace App\Http\Controllers;

class DictUpdater extends AbstractUpdater {

    private function createDictEntry($line)
    {
        $entry = [];
        $entry['gk'] = $line[0];
        $entry['szal'] = $line[1];
        $entry['szf'] = $line[2];
        $entry['valt'] = $line[3];
        $entry['mj'] = $line[4];
        $entry['elem'] = $line[5];
        $entry['strong'] = $line[6];
        $entry['bk'] = $line[7];
        return $entry;
    }

    protected function truncate()
    {
        DictEntry::truncate();
    }

    protected function storeLines($lines)
    {
        $entries = array_map(function ($line) {
            return $this->createDictEntry($line);
        }, $lines);
        DB::table("{$this->tablePrefix}szot")->insert($entries);
    }

    protected function validateLine($line)
    {
        $valid = count($line) >= 8;
        return $valid;
    }
}