<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Middleware\ClasstingRequest;

class ClassController
{
    private $request = null;


    /**
     * ClassController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    /**
     * 사용자가 가입된 클래스 리스트를 얻습니다.
     * Http Parameter
     * token (ex:f0a7537ae99b66e29f04e1b410719495dbf662eeb61f4357a1568e2d23238b6a)
     * uid (userid) (ex: 15346033538806780)
     */
    public function getClassList()
    {
        $token = $this->request->query('token');
        $uid = $this->request->query('uid');

        $request = new ClasstingRequest($token);
        $data = $request->Ting_Get('/v2/users/'.$uid.'/joined_classes');
        return response()->json($data, Response::HTTP_OK);
    }

    /*
     * 한 클래스의 멤버 정보를 얻습니다.
     * Http Parameter
     * token
     * cid (classid)
     * */
    public function getClassMember(){
        $token = $this->request->query('token');
        $cid = $this->request->query('cid');

        $request = new ClasstingRequest($token);
        $data = $request->Ting_Get('/v2/classes/'.$cid.'/members');
        return response()->json($data, Response::HTTP_OK);
    }

    /*
     * 한 클래스의 정보를 얻습니다.
     * Http Parameter
     * token
     * cid (classid)
     * */
    public function getClassInfo(){
        $token = $this->request->query('token');
        $cid = $this->request->query('cid');

        $request = new ClasstingRequest($token);
        $data = $request->Ting_Get('/v2/classes/'.$cid);
        return response()->json($data, Response::HTTP_OK);
    }

}