<?php

namespace App\Http\Controllers;

use App\Cloud;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LessonController
{
    private $request = null;

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

            $cloud = new Cloud($file->getClientOriginalName(), $path);
            return $cloud->insertDB();

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
        $Chapter = $this->request->query('chapter');
        $Explain = $this->request->query('explain');
        $Link = $this->request->query('link');
        if($Link)
        {
        }
        else if ($Mid = $this->uploadVideo()){
            if ($Mid)
            {

                return "success";
            }
        }
        else
            return "video not found";



    }


}