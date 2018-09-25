<?php
/**
 * Created by PhpStorm.
 * User: Jin
 * Date: 2018-09-24
 * Time: 오후 9:48
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\UserInfo;

class UserController
{
    private $request = null;


    /**
     * UserController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    /**
     * 사용자의 정보를 얻습니다.
     * Http Parameter
     * token (ex:f0a7537ae99b66e29f04e1b410719495dbf662eeb61f4357a1568e2d23238b6a)
     */
    public function getUserInfo()
    {
        $token = $this->request->query('token');
        $user = new UserInfo();
        return response()->json($user->getUser($token), Response::HTTP_OK);
    }
}