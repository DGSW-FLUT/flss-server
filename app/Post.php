<?php
/**
 * Created by PhpStorm.
 * User: Jin
 * Date: 2018-10-09
 * Time: 오전 4:32
 */

namespace App;

use Illuminate\Support\Facades\DB;

class Post
{
    protected $title;

    protected $uid;

    protected $mid;

    protected $cid;

    protected $content;

    protected $readOnly;

    public function setAll($title, $uid, $mid, $cid, $content, $readOnly){
        $this->title = $title;
        $this->uid = $uid;
        $this->mid = $mid;
        $this->cid = $cid;
        $this->content = $content;
        $this->readOnly = $readOnly;
    }

    public function insertDB(){
        return DB::table('Post')->insert([
            'Title' => $this->title,
            'Uid' => $this->uid,
            'Mid' => $this->mid,
            'Cid' => $this->cid,
            'Content' => $this->content,
            'ReadOnly' => $this->readOnly
        ]);
    }

    public function getAllList($cid,$readOnly){
        if($readOnly == "teacher"){
            return DB::table('Post')->select()->where('Cid', '=', $cid)->get();
        } else {
            return DB::table('Post')->select()->where('Cid', '=', $cid)->where('ReadOnly', '=', 'student')->get();
        }
    }

    public function getDataByName($cid, $name){
        $uid = DB::table('User')->where('name', '=', $name)->pluck('Uid');

        return DB::table('Post')->select()->where('Uid', '=', $uid)->where('Cid', '=', $cid)->get();
    }

    public function getDataByTitle($cid, $title){
        return DB::table('Post')->select()->where('Title','=', "%".$title."%")->where('Cid', '=', $cid)->get();
    }
}