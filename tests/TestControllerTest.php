<?php

use Illuminate\Http\Response;

class TestControllerTest extends TestCase
{

    public function test__invoke()
    {
        $json = [
            'a' => 'b',
            'b' => 'c'
        ];
        $this->post('/', $json);
        
        $this->seeStatusCode(Response::HTTP_OK);
        $this->seeJsonStructure([
            '*' => [
                
            ]
        ]);
    }
}
