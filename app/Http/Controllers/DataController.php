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
use App\Post;

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

    public function uploadData()
    {
        $file = $this->request->file('video');

        $path = $file->move('video', uniqid().$file->getClientOriginalName())->getFilename();

        return $path;
    }

    public function getPostList(){
        $cid = $this->request->query('cid');
        $readOnly = $this->request->query('readOnly');

        $post = new Post();
        return $post->getAllList($cid,$readOnly);
    }

    public function getDataList(){
        $cid = $this->request->query('cid');
        $readOnly = $this->request->query('readOnly');

        return Cloud::getAllList($cid,$readOnly);
    }

    public function getDataByTitle(){
        $cid = $this->request->query('cid');
        $readOnly = $this->request->query('readOnly');
        $title = $this->request->query('title');

        return Cloud::getDataByTitle($cid,$title,$readOnly);
    }
    public function getPostByName(){
        $name = $this->request->query('name');
        $cid = $this->request->query('cid');

        $post = new Post();
        return $post->getDataByName($cid,$name);
    }

    public function getPostByTitle(){
        $title = $this->request->query('title');
        $cid = $this->request->query('cid');

        $post = new Post();
        return $post->getDataByTitle($cid,$title);
    }

    public function addPost(){
        $cid = $this->request->input('cid');
        $name = $this->request->input('name');
        $title = $this->request->input('title');
        $uid = $this->request->input('uid');
        $content = $this->request->input('content');
        $readOnly = $this->request->input('readOnly');

        if($this->request->hasFile('video')){
            $path = $this->uploadData();
            $this->Cloud =  new Cloud($name,$path,$cid,$readOnly);
        } else {
            $link = $this->request->input('link');
            $this->Cloud =  new Cloud($name,$link,$cid,$readOnly);
        }

        $mid = $this->Cloud->insertDB();

        $post = new Post();
        $post->setAll($title,$uid,$mid,$cid,$content,$readOnly);
        return $post->insertDB();
    }

    public function changeReadOnly(){
        $pid = $this->request->input('pid');
        $readOnly = $this->request->input('readOnly');

        $post = new Post();
        return $post->changeReadOnly($pid,$readOnly);
    }
}