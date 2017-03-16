<?php
/**

 */

namespace App\Http\Controllers;

use App\Commands\Command;
use Log;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;

class DatabaseUpdater extends Command {

    use InteractsWithQueue, SerializesModels;

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     */
    public function handle()
    {
        $jsonData = json_encode($this->data);
        Log::info("fired database updater with data {$jsonData}");
        $path = storage_path($this->data['file']);
        $general = $this->data['general'] == 'true';
        $type = self::getFileType($path);
        if ($type == "konyvek") {
            $updater = new WordUpdater($path, $general, $this->job->getJobId());
        } else {
            $updater = new DictUpdater($path, $general, $this->job->getJobId());
        }
        $updater->fire();
        unlink($path);
    }

    /**
     * @param $fileName
     * @return string
     */
    public static function getFileType($fileName)
    {
        $file = fopen($fileName, 'r');
        $firstLine = fgetcsv($file);
        fclose($file);
        if (preg_match("/^\d+.*/", $firstLine[0]) > 0) {
            $type = "szot";
            return $type;
        } else {
            $type = "konyvek";
            return $type;
        }
    }

}