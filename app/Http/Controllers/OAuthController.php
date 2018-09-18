<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OAuthController
{
    private $request = null;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    public function classting()
    {
        $redirect_uri = 'https://oauth.classting.com/v1/oauth2/authorize';
        $redirect_uri .= '?client_id=' . $_ENV["CLASSTING_CLIENT_ID"];
        $redirect_uri .= '&redirect_uri=' . $_ENV['SERVER_HOST'] . '/auth/get_token';
        $redirect_uri .= '&response_type=' . 'token';
        return redirect($redirect_uri);
    }
    // 학생의 글 조회 -> 
    
    public function classtingHandle()
    {
        $token = $this->request->query('access_token');
        
        return response()->json(['token' => $token], Response::HTTP_OK);
    }
}