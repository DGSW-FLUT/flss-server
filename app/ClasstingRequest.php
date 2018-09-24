<?php

namespace App;
/**
 * Class ClasstingRequest
 */
class ClasstingRequest
{
    private $ACCESS_TOKEN;
    private $CLASSTING_URL = "https://api.classting.com:443";

    /**
     * ClasstingRequest 생성자.
     * @param $ACCESS_TOKEN string Access Token
     */
    public function __construct($ACCESS_TOKEN)
    {
        $this->ACCESS_TOKEN = $ACCESS_TOKEN;
    }

    /**
     * Classting에 Request를 보냅니다.
     * @param $url string 클래스팅 url (v2/* 부터 시작)
     *
     * @return mixed 값 리턴
     */
    public function Ting_Get($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->CLASSTING_URL.$url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Authorization : Bearer '.$this->ACCESS_TOKEN
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($curl);
        echo $output;
        curl_close($curl);
        $decode = json_decode($output);
        if ($decode == null){
            return null;
        }
        return get_object_vars($output);

    }

}
//Example
//$cr = new ClasstingRequest("f0a7537ae99b66e29f04e1b410719495dbf662eeb61f4357a1568e2d23238b6a");
//echo $cr->Ting_Get("/v2/users/me");