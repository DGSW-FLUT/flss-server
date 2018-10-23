<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InteractionController
{
    private $request = null;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function uploadData()
    {
        $file = $this->request->file('file');
        if (!$file)
            return null;
        $path = $file->move('interaction', uniqid().$file->getClientOriginalName())->getFilename();
        return $path;
    }
    public function uploadFile() {
        return $this->uploadData();
    }
}