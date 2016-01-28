<?php
/**

 */

namespace App\Http\Controllers;

class DatabaseUpdater {

    /**
     * @param \Illuminate\Queue\Jobs\Job $job
     * @param $data
     */
    public function fire($job, $data)
    {
        $jsonData = json_encode($data);
        Log::info("fired database updater with data {$jsonData}");
        $path = storage_path($data['file']);
        $general = $data['general'] == 'true';
        $type = self::getFileType($path);
        if ($type == "konyvek") {
            $updater = new WordUpdater($path, $general);
        } else {
            $updater = new DictUpdater($path, $general);
        }
        $updater->fire();
        $job->delete();
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