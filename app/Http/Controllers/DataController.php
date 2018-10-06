<?php
/**
 * Created by PhpStorm.
 * User: Jin
 * Date: 2018-10-06
 * Time: 오후 1:37
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cloud;

class DataController
{
    private $request = null;

    private $Cloud = null;
    /**
     * DataController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function uploadData($Cid)
    {
        $file = $this->request->file('video');

        $path = $file->move('video', uniqid().$file->getClientOriginalName())->getFilename();

        return $path;
    }

    public function getDataList(){
        $cid = $this->request->query('cid');
        return Cloud::getAllList($cid);
    }

    public function addData(){
        $cid = $this->request->input('cid');
        $name = $this->request->input('name');

        if($this->request->hasFile('video')){
            $path = $this->uploadData('Cid');
            $this->Cloud =  new Cloud($name,$path,$cid);
        } else {
            $link = $this->request->input('link');
            $this->Cloud =  new Cloud($name,$link,$cid);
        }

        return $this->Cloud->insertDB();
    }
}