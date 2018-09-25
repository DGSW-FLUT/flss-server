<?php


/** @var \Laravel\Lumen\Routing\Router $router */
$router->get('/', 'TestController');
$router->post('/', 'TestController');

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['prefix' => 'auth'], function () use ($router) {
        $router->get('get_token', function () use ($router) {
            return response()->make(include 'get_token.html', 200);
        });
        $router->get('classting', 'OAuthController@classting');
        $router->get('classting_handle', 'OAuthController@classtingHandle');
    });

    $router->group(['prefix'=>'class'], function () use ($router){
        /*
         * 가입 된 클래스의 리스트
         * parem (uid, token)
         */
        $router->get('joined', 'ClassController@getClassList');

        /*
         * 한 클래스에 포함된 멤버 리스트
         * parem (cid, token)
         */
        $router->get('member', 'ClassController@getClassMember');

        /*
         * 한 클래스의 세부정보
         * parem (cid, token)
         */
        $router->get('info', 'ClassController@getClassInfo');


    });

    $router->group(['prefix'=>'lesson'], function () use ($router) {
        $router->post('upload', 'LessonController@AddLesson');
    });
    
});