<?php

namespace App\Http\Controllers;

use App\Cloud;
use App\Lesson;
use App\Subject;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LessonController
{
    private $request = null;

    /**
     * @var Cloud
     */
    private $Cloud = null;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    /**
     * FormData에서부터 비디오를 받아옵니다.
     *
     * @return bool|string
     */
    public function uploadVideo()
    {
        if ($this->request->hasFile('video'))
        {
            $file = $this->request->file('video');

            $path = $file->move('video', uniqid().$file->getClientOriginalName())->getFilename();

            $this->Cloud = new Cloud($file->getClientOriginalName(), $path);
            return $this->Cloud->insertDB();

        } else {
            return false;
        }
    }



    public function AddLesson() {
        // Get Body Parameter
        $UserId = $this->request->query('uid');
        $ClassId = $this->request->query('cid');
        $Title = $this->request->query('title');
        $Subject = $this->request->query('subject');
        $Grade = $this->request->query('grade');
        $Semester = $this->request->query('semester');
        $Unit = $this->request->query('unit');
        $Explain = $this->request->query('explain');
        $Link = $this->request->query('link');
        if($Link)
        {
            $this->Cloud = new Cloud($Title, $Link);
        }
        else if (!$this->uploadVideo()){
            return "video not found";
        }


        $Sub = new Subject($Subject);
        $Sub->addYearSubjectDB($Grade, $Semester);

        $lesson = new Lesson($this->Cloud, $ClassId, $Title, $Explain, $Sub, $Unit, $UserId);
        return $lesson->insertDB();
    }

    public function getLessonList() {
        $Cid = $this->request->query('cid');

        return Lesson::getLessonList($Cid);
    }

}