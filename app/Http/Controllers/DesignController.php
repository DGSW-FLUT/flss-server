<?php
/**
 * Created by PhpStorm.
 * User: Jin
 * Date: 2018-10-09
 * Time: 오전 6:41
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Design;
use App\Cloud;

class DesignController
{
    private $request = null;
    private $Cloud = null;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function uploadData()
    {
        $file = $this->request->file('video');

        $path = $file->move('video', uniqid().$file->getClientOriginalName())->getFilename();

        return $path;
    }

    public function addDesign(){
        $title = $this->request->input('title');
        $cid = $this->request->input('cid');

        $design = new Design();
        return $design->addDesign($cid,$title);
    }

    public function addFile(){
        $did = $this->request->input('did');
        $name = $this->request->input('name');
        $cid = $this->request->input('cid');

        if($this->request->has('file')){
            $path = $this->uploadData();
            $this->Cloud = new Cloud($name,$path,$cid,'teacher');
            $mid = $this->Cloud->insertDB();
        }else if($this->request->has('link')){
            $link = $this->request->input('link');
            $this->Cloud = new Cloud($name,$link,$cid,'teacher');
            $mid = $this->Cloud->insertDB();
        }else{
            $mid = $this->request->input('Mid');
        }

        $design = new Design();
        return $design->addFile($did,$mid);
    }
}