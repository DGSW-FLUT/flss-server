<?php
/**
 * Created by PhpStorm.
 * User: Jin
 * Date: 2018-10-23
 * Time: 오후 5:10
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Notice;
class NoticeController
{
    private $request = null;

    /**
     * NoticeController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function addNotice(){
        $cid = $this->request->input('cid');
        $notice = $this->request->input('notice');

        return Notice::addNotice($cid, $notice);
    }

    public function showNotice(){
        $cid = $this->request->query('cid');

        return Notice::showNotice($cid);
    }
}