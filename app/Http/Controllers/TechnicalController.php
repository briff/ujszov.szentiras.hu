<?php

namespace App\Http\Controllers;

use App\Model\Message;
use App\Model\UpdaterJob;
use Request;
use Response;
use View;
use Queue;

class TechnicalController extends Controller
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
        $jobs = UpdaterJob::orderBy('created_at', 'desc')->get();
        $jobData = $jobs->map(function ($job) {
            return [
                'id' => $job->id,
                'created_at' => $job->created_at,
                'completed' => $job->completed,
                'failed' => $job->failed,
                'messages' => $job->getMessages()->count(),
                'lines' => $job->lines
            ];

        });
        return View::make('technical.index',
            ['jobs' => $jobData]);
    }

    public function getConvert()
    {
        return View::make('technical.convert');
    }

    public function getMessages($id)
    {
        $job = UpdaterJob::find($id);
        return View::make('technical.messages', ['messages' => $job->getMessages()->getResults()]);
    }

    public function getStatus($id)
    {
        $job = UpdaterJob::find($id);
        $messages = $job->getMessages()->count();
        return Response::json(
            [
                'id' => (int)$id,
                'lines' => (int)$job->lines,
                'completed' => (boolean)$job->completed,
                'messages' => (int)$messages,
                'failed' => (boolean)$job->failed
            ]);
    }

    public function getQueueJobStatus($queueJobId)
    {
        $job = UpdaterJob::where('queue_job_id', $queueJobId)->first();
        if ($job) {
            return $this->getStatus($job->id);
        } else {
            return Response::json([]);
        }
    }

    public function postUpload() {
        $uploadedFile = Request::file('file');
        $uploadedFile = $uploadedFile->move(storage_path());
        $type = DatabaseUpdater::getFileType($uploadedFile);
        return Response::json(['type' => $type, 'fileName'=>$uploadedFile->getFilename()]);
    }

    public function postConvert()
    {
        $jobId = Queue::push(new DatabaseUpdater(Request::all()));
        return Response::json(['jobId' => $jobId]);
    }

    public function getModerate() {
        $messages = Message::orderBy('ssz', 'desc')->paginate(50);
        return View::make('technical.moderate', [ 'messages' => $messages] );
    }

    public function postModerate() {
        $id = Request::input('id');
        $message = Message::find($id);
        $message->hidden = true;
        $message->save();
        return $this->getModerate();
    }

};
