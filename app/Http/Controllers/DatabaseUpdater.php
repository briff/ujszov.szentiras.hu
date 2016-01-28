<?php
/**

 */

namespace App\Http\Controllers;

use App\Model\UpdaterJob;
use Log;

use App\Commands\Command;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class DatabaseUpdater extends Command implements SelfHandling, ShouldBeQueued {

    use InteractsWithQueue, SerializesModels;

    private $data;
    private $updater;

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
            $this->updater = new WordUpdater($path, $general, $this->job->getJobId());
        } else {
            $this->updater = new DictUpdater($path, $general, $this->job->getJobId());
        }
        $this->updater->fire();
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

    public function failed() {
        $job = UpdaterJob::find($this->updater->getJobId());
        $job->failed = true;
        $job->save();
    }
} 