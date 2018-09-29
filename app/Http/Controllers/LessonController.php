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
    public function uploadVideo($Cid)
    {
        if ($this->request->hasFile('video'))
        {
            $file = $this->request->file('video');

            $path = $file->move('video', uniqid().$file->getClientOriginalName())->getFilename();

            $this->Cloud = new Cloud($file->getClientOriginalName(), $path, $Cid);
            return $this->Cloud->insertDB();

        } else {
            return false;
        }
    }



    public function AddLesson() {
        // Get Body Parameter
        $UserId = $this->request->input('uid');
        $ClassId = $this->request->input('cid');
        $Title = $this->request->input('title');
        $Subject = $this->request->input('subject');
        $Grade = $this->request->input('grade');
        $Semester = $this->request->input('semester');
        $Unit = $this->request->input('unit');
        $Explain = $this->request->input('explain');
        $Link = $this->request->input('link');
        if($Link)
        {
            $this->Cloud = new Cloud($Title, $Link, $ClassId);
            $this->Cloud->insertDB();
        }
        else if (!$this->uploadVideo($ClassId)){
            return "video not found";
        }


        $Sub = new Subject($Subject);
        $Sub->addYearSubjectDB($Grade, $Semester);

        $lesson = new Lesson();
        $lesson->setAll($this->Cloud, $ClassId, $Title, $Explain, $Sub, $Unit, $UserId);
        return $lesson->insertDB();
    }

    public function getLessonList() {
        $Cid = $this->request->query('cid');
        return Lesson::getLessonList($Cid);
    }

    public function deleteClassList(){
        $Lno = $this->request->query('lno');
        $lesson = new Lesson();
        $lesson->setLno($Lno);
        return $lesson->deleteLessonDB();
    }




}