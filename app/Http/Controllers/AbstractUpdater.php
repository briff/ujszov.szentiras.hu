<?php
/**

 */

namespace App\Http\Controllers;

abstract class AbstractUpdater {

    protected $tablePrefix;
    protected $filePath;
    protected $general;

    const CHUNK_SIZE = 1000;
    private $job;

    /**
     * @param string $filePath
     * @param boolean $general
     */
    public function __construct($filePath, $general) {
        $this->filePath = $filePath;
        $this->general = $general;
        $this->tablePrefix = Config::get('database.connections.mysql.prefix');
    }

    public function fire() {
        if ($this->general) {
            Log::debug("truncating table", [ $this ]);
            $this->truncate();
        }
        $this->job = new UpdaterJob();
        $this->job->lines = 0;
        $this->job->completed = false;
        $this->job->save();
        $this->processFile();
        $this->job->completed = true;
        $this->job->save();
    }

    protected abstract function truncate();

    protected abstract function storeLines($lines);

    protected abstract function validateLine($line);

    private function processFile()
    {
        gc_enable();
        $file = fopen($this->filePath, 'r');
        $chunk = [];
        $queryLogEnabled = DB::connection()->logging();
        DB::connection()->disableQueryLog();
        while (($line = fgetcsv($file, 0, "\t"))) {
            if ($this->validateLine($line)) {
                $chunk[] = $line;
            } else {
                Log::warning("Bad line", $line);
            }
            if (count($chunk) == self::CHUNK_SIZE) {
                $this->storeLines($chunk);
                $this->job->lines += self::CHUNK_SIZE;
                Log::debug("processed rows: {$this->job->lines}");
                $chunk = [];
                $this->job->save();
            }
        }
        if (count($chunk) > 0) {
            Log::debug("processing last chunk");
            $this->storeLines($chunk);
            $this->job->lines += count($chunk);
            $this->job->save();
        }
        fclose($file);
        if ($queryLogEnabled) {
            DB::connection()->enableQueryLog();
        }
    }

}