<?php
/**
 * Created by PhpStorm.
 * User: Jin
 * Date: 2018-10-29
 * Time: 오후 5:45
 */

namespace App;

use Illuminate\Support\Facades\DB;

class Comment
{
    private $uid;

    private $type;

    private $content;

    private $post;

    public function __construct()
    {
    }

    public function addComment(){
        return DB::table('Comment')->insertGetId([
            'Uid' => $this->uid,
            'type' => $this->type,
            'post' => $this->post,
            'content' => $this->content
        ]);
    }

    public function setAll($uid, $type, $content, $post){
        $this->uid = $uid;
        $this->type = $type;
        $this->content = $content;
        $this->post = $post;
    }

    public function showComment($type, $post){
        return DB::table('Comment')->select()
            ->join('User','User.Uid','=','Comment.Uid')
            ->where('type','=',$type)
            ->where('post','=',$post)
            ->get();
    }
}