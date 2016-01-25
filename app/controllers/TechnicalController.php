<?php

use Symfony\Component\HttpFoundation\File\File;

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
        return View::make('technical.convert');
    }

    public function postUpload() {
        $uploadedFile = Input::file('file');
        $uploadedFile = $uploadedFile->move(storage_path());
        $type = DatabaseUpdater::getFileType($uploadedFile);
        return Response::json(['type' => $type, 'fileName'=>$uploadedFile->getFilename()]);
    }

    public function postConvert()
    {

        $jobId = Queue::push('DatabaseUpdater', Input::get('data'));
        return Response::json(['jobId' => $jobId]);
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
