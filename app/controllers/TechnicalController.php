<?php

class TechnicalController extends \BaseController
{

    public function __construct()
    {
        $this->beforeFilter('auth.basic');
    }

        /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        return View::make('technical.index');
    }

    public function getConvert()
    {
        $sourcePath = base_path(Config::get('settings.sourceDir'));
        $contents = $this->readDirContents($sourcePath);
        return View::make('technical.convert')->with(
            ['sourcePath' => $sourcePath,
                'contents' => $contents]
        );
    }

    public function postConvert()
    {
        $sourcePath = base_path(Config::get('settings.sourceDir')) . '/' . Input::get("fajl");
        $type = Input::get("tipus");
        if ($type == "szotar") {
            $tableName = "szot";
        } else if ($type == "konyvek") {
            $tableName = "konyvek";
        }
        $general = Input::has("general");
        if ($general) {
            Log::info("Korabbi adatok torlese");
            DB::connection()->table($tableName)->truncate();
        }
        $file = fopen($sourcePath, "r");
        $this->fajlolvas($file, $type, $general);
        return View::make("technical.convert_done");
    }

    private function getBookLineBindings($line)
    {
        return [
            'lh' => $line[0],
            'fh' => $line[1],
            'feh' => $line[2],
            'fkh' => $line[3],
            'unic' => $line[4],
            'grae' => $line[5],
            'rk' => $line[6],
            'ef' => $line[7],
            'lj' => $line[8],
            'mj' => $line[9],
            'szf' => $line[10],
            'elem' => $line[11],
            'bk' => $line[12],
            'felelos' => $line[13],
            'gk' => $line[14],
            'hj' => $line[15],
            'szal' => $line[16]
        ];
    }

    private function saveBookLine($line, $insert = false)
    {
        $this->initWithEmptyString($line, 16);
        if ($insert) {
            DB::connection()->table("konyvek")->insert(
                $this->getBookLineBindings($line)
            );
        } else {
            DB::connection()->table("konyvek")->update($this->getBookLineBindings($line));
        }
    }

    private function saveDictLine($line, $insert = false)
    {
        $this->initWithEmptyString($line, 7);
        if ($insert) {
            DB::connection()->table("szot")->insert(
                $this->getDictLineBindings($line)
            );
        } else {
            DB::connection()->table("szot")->update($this->getDictLineBindings($line));
        }
    }

    private function initWithEmptyString($line, $maxColumnIndex)
    {
        for ($i = 0; $i <= $maxColumnIndex; $i++) {
            if (!isset($line[$i])) {
                $line[$i] = "";
            }
        }
    }

    private function getDictLineBindings($line)
    {
        return [
            "gk" => $line[0],
            "szal" => $line[1],
            "szf" => $line[2],
            "valt" => $line[3],
            "mj" => $line[4],
            "elem" => $line[5],
            "strong" => $line[6],
            "bk" => $line[7]
        ];
    }

    private function fajlolvas($file, $tipus, $general)
    {
        while (($line = fgetcsv($file, 0, "\t"))) {
            for ($i = 0; $i < count($line); $i++) {
                $line[$i] = str_replace(["\\", "'"], ["\\" . "\\", "\\'"], $line[$i]);
            }
            if ($tipus == "konyvek") {
                $this->saveBookLine($line, $general);
            } else {
                $this->saveDictLine($line, $general);
            }
        }
    }

    private function readDirContents($path)
    {
        $contents = [];
        $dir = opendir($path);
        while (($element = readdir($dir)) !== false) {
            if ($element == "." || $element == "..") continue;
            if (is_dir("$path/$element")) {
                $contents[] = ['name' => "$element", 'children' => $this->readDirContents("$path/$element")];
            } else {
                $contents[] = ['name' => "$element"];
            }
        }
        closedir($dir);
        return $contents;
    }

    public function getModerate() {
        $messages = Message::orderBy('ssz', 'desc')->paginate(50);
        return View::make('technical.moderate', [ 'messages' => $messages] );
    }

    public function postModerate() {
        $id = Input::get('id');
        $message = Message::find($id);
        $message->hidden = true;
        $message->save();
        return $this->getModerate();
    }

};
