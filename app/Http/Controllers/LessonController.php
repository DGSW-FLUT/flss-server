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
            $this->Cloud = new Cloud($Title, $Link, $ClassId);
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