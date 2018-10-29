<?php
/**
 * Created by PhpStorm.
 * User: Jin
 * Date: 2018-10-29
 * Time: 오후 5:34
 */

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class CommentController
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;

    }

    public function addComment(){
        $owner = $this->request->input('uid');
        $type = $this->request->input('type');
        $post = $this->request->input('post');
        $content = $this->request->input('content');

        $comment = new Comment();
        $comment->setAll($owner,$type,$post,$content);
        return $comment->addComment();
    }

    public function showComment(){
        $type = $this->request->query('type');
        $post = $this->request->query('post');

        $comment = new Comment();
        return $comment->showComment($type, $post);
    }
}