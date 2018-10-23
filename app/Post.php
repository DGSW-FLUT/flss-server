<?php
/**
 * Created by PhpStorm.
 * User: Jin
 * Date: 2018-10-09
 * Time: 오전 4:32
 */

namespace App;

use Illuminate\Support\Facades\DB;
use Exception;

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

    public function changeReadOnly($pid,$readOnly){
        try {
            DB::table('Post')->where('Pid', '=', $pid)->update(['ReadOnly' => $readOnly]);

            $mid = DB::table('Post')->where('Pid', '=', $pid)->pluck('Mid');

            DB::table('Cloud')->where('Mid', '=', $mid)->update(['ReadOnly' => $readOnly]);
            return 1;
        } catch (Exception $e){
            return 0;
        }
    }
    public function insertDB(){
        try {
            DB::table('Post')->insert([
                'Title' => $this->title,
                'Uid' => $this->uid,
                'Mid' => $this->mid,
                'Cid' => $this->cid,
                'Content' => $this->content,
                'ReadOnly' => $this->readOnly
            ]);
            return 1;
        } catch (Exception $e){
            return 0;
        }
    }

    public function getAllList($cid,$readOnly){
        if($readOnly == "teacher"){
            return DB::table('Post')
                ->select('Post.Pid','User.Uid','User.Name','Cloud.Mid','Cloud.File','Cloud.Name as FileName','Post.Title','Post.Content','Post.UploadTime')
                ->join('Cloud', 'Cloud.Mid', '=', 'Post.Mid')
                ->join('User', 'User.Uid', '=', 'Post.Uid')
                ->orderByDesc('UploadTime')
                ->where('Post.Cid', '=', $cid)->get();
        } else {
            return DB::table('Post')
                ->select('Post.Pid','User.Uid','User.Name','Cloud.Mid','Cloud.File','Cloud.Name as FileName','Post.Title','Post.Content','Post.UploadTime')
                ->join('Cloud', 'Cloud.Mid', '=', 'Post.Mid')
                ->join('User', 'User.Uid', '=', 'Post.Uid')
                ->orderByDesc('UploadTime')
                ->where('Post.Cid', '=', $cid)
                ->where('Post.ReadOnly', '=', 'student')->get();
        }
    }

    public function getDataByName($cid, $name){
        $uid = DB::table('User')->where('name', '=', $name)->pluck('Uid');

        try {
            if (count($uid) > 1) {
                return DB::table('Post')
                    ->select('Post.Pid','User.Uid','User.Name','Cloud.Mid','Cloud.File','Cloud.Name as FileName','Post.Title','Post.Content','Post.UploadTime')
                    ->join('Cloud', 'Cloud.Mid', '=', 'Post.Mid')
                    ->join('User', 'User.Uid', '=', 'Post.Uid')
                    ->orderByDesc('UploadTime')
                    ->whereRaw('Post.Uid IN (select Uid from User where Name = "' . $name . '")')
                    ->where('Post.Cid', '=', $cid)->get();
            } else {
                return DB::table('Post')
                    ->select('Post.Pid','User.Uid','User.Name','Cloud.Mid','Cloud.File','Cloud.Name as FileName','Post.Title','Post.Content','Post.UploadTime')
                    ->join('Cloud', 'Cloud.Mid', '=', 'Post.Mid')
                    ->join('User', 'User.Uid', '=', 'Post.Uid')
                    ->orderByDesc('UploadTime')
                    ->where('Post.Uid', '=', $uid)
                    ->where('Post.Cid', '=', $cid)->get();
            }
        }catch (Exception $e){
            return -1;
        }
    }

    public function getDataByTitle($cid, $title){
        return DB::table('Post')->select()
            ->join('Cloud', 'Cloud.Mid', '=', 'Post.Mid')
            ->orderByDesc('UploadTime')
            ->where('Post.Title','=', "%".$title."%")
            ->where('Post.Cid', '=', $cid)->get();
    }
}