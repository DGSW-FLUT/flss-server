<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\ClassRoom;

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
        $classRoom = new ClassRoom();
//        return response()->json($classRoom->getClassList($token, $uid), Response::HTTP_OK);
        return response()->json($classRoom->getClassList($token, $uid), Response::HTTP_OK);
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
        $classRoom = new ClassRoom();
        return response()->json($classRoom->getClassMember($token, $cid), Response::HTTP_OK);
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
        $classRoom = new ClassRoom();
        return response()->json($classRoom->getClassInfo($token, $cid), Response::HTTP_OK);
//        return $classRoom->getClassInfo($token, $cid);
    }



}