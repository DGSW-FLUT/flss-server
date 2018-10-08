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
        $router->get('userinfo', 'UserController@getUserInfo');
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

        /*
         * Lesson 추가
         * param (uid,cid,title,subject,grade,semester,unit,chapter,explain)
         * form data (video)
         * */
        $router->post('add', 'LessonController@AddLesson');

        /*
         * Lesson list 불러오기
         * param (cid)
         * */
        $router->get('list', 'LessonController@getLessonList');

        /*
         * Lesson 삭제
         * param (lno)
         * */
        $router->get('delete', 'LessonController@deleteClassList');

        $router->post('addQuiz', 'LessonController@addQuiz');

        $router->get('showQuiz', 'LessonController@showQuiz');

        $router->post('solveQuiz', 'LessonController@solveQuiz');
    });

    $router->group(['prefix'=>'data'], function () use ($router){
        $router->get('getData', 'DataController@getDataList');
        $router->post('addData', 'DataController@addData');
    });

    $router->group(['prefix'=>'reward'], function () use ($router){
        $router->get('getUser', 'RewardController@getStudent');
        $router->get('addPoint', 'RewardController@addPoint');
    });
});