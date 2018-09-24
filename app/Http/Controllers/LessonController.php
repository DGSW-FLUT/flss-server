<?php

namespace App\Http\Controllers;

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

    public function uploadVideo()
    {
        if ($this->request->hasFile('video'))
        {
            $file = $this->request->file('video');
            $file->move('video', uniqid().$file->getClientOriginalName())->getPath();
            return "success";
        } else {
            return "video not found";
        }
    }
}