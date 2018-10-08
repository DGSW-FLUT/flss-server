<?php
/**
 * Created by PhpStorm.
 * User: Jin
 * Date: 2018-10-07
 * Time: 오전 12:02
 */

namespace App\Http\Controllers;

use App\Reward;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RewardController
{
    private $request = null;
    private $userReward;

    /**
     * RewardController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getStudent(){
        $token = $this->request->query('token');
        $cid = $this->request->query('cid');

        $userReward = new Reward();
        $userReward->addStudent($token,$cid);

        return $userReward->getStudent($cid);
    }

    public function addPoint(){
        $uid = $this->request->query('uid');
        $point = $this->request->query('point');

        $userReward = new Reward();
        return $userReward->addStudentPoint($uid,$point);
    }
}