<?php


/** @var \Laravel\Lumen\Routing\Router $router */
$router->post('/', function () use ($router) {
    return response()->setContent("sdfsd")->send();
});
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

        $router->get('testList', 'LessonController@getTestList');
        /*
         * Lesson 삭제
         * param (lno)
         * */
        $router->get('delete', 'LessonController@deleteClassList');

        $router->post('addQuiz', 'LessonController@addQuiz');

        $router->get('showQuiz', 'LessonController@showQuiz');

        $router->get('showQuestion', 'LessonController@showQuestion');

        $router->post('solveQuiz', 'LessonController@solveQuiz');

        $router->get('resultQuiz', 'LessonController@resultQuiz');
    });

    $router->group(['prefix'=>'data'], function () use ($router){
        $router->post('addPost', 'DataController@addPost');
        $router->get('getPostByName', 'DataController@getPostByName');
        $router->get('getPostByTitle', 'DataController@getPostByTitle');
        $router->get('getPostList', 'DataController@getPostList');
        $router->get('getDataList', 'DataController@getDataList');
        $router->get('getDataByTitle', 'DataController@getDataByTitle');
        $router->post('changeReadOnly', 'DataController@changeReadOnly');
    });

    $router->group(['prefix'=>'reward'], function () use ($router){
        $router->get('getUser', 'RewardController@getStudent');
        $router->post('addPoint', 'RewardController@addPoint');
    });

    $router->group(['prefix'=>'design'], function () use ($router){
        $router->post('addDesign', 'DesignController@addDesign');
        $router->post('addFile', 'DesignController@addFile');
        $router->get('designList', 'DesignController@showList');
        $router->get('oneDesign', 'DesignController@showOne');
    });

    $router->group(['prefix'=>'portfolio'], function () use ($router) {
        $router->post('add', 'PortfolioController@addPortfolio');
        $router->get('list', 'PortfolioController@getPortfolioList');
    });

    $router->group(['prefix'=>'interaction'], function () use ($router) {
        $router->post('add', 'InteractionController@uploadFile');
    });

    $router->group(['prefix'=>'notice'], function () use ($router) {
        $router->post('addNotice', 'NoticeController@addNotice');
        $router->get('showNotice', 'NoticeController@showNotice');
    });
});

$router->get('/{route:.*}', function () use ($router) {
    ob_start();
    $html = include('main.html');
    $html = ob_get_clean();
    return response()->make($html, 200);
});
