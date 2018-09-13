<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TestController extends Controller
{
    private $request = null;

    /**
     * Create a new controller instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Response all of request data.
     * 
     * @return Response
     */
    public function __invoke() {
        $json = [
            "headers" => $this->request->header(),
            "query" => $this->request->query(),
            "body" => $this->request->post()
        ];
        
        return response()->json($json, Response::HTTP_OK);
    }
}
