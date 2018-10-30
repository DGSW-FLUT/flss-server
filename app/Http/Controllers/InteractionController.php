<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interaction;
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
        $path = $file->move('interactionItem', uniqid().$file->getClientOriginalName())->getFilename();
        return $path;
    }
    public function uploadFile() {
        return $this->uploadData();
    }

    public function createInteraction() {
        $cid = $this->request->query("cid");
        $topic = $this->request->query("topic");
        $action = new Interaction($topic, $cid);
        return $action->insertDB();
    }

    public function getInteraction() {
        $cid = $this->request->query("cid");
        return Interaction::getInteractionList($cid);
    }
}