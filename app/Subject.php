<?php

namespace app;
use Illuminate\Support\Facades\DB;

/**
 * Created by PhpStorm.
 * User: tbvja
 * Date: 2018-09-26
 * Time: 오전 1:55
 */

class Subject
{
    public $name;

    public $YSid;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function addSubjectDB(){
        return DB::table('Subject')->insertGetId(['Name'=>$this->name]);
    }

    public function addYearSubjectDB($year, $semes){
        return $YSid = DB::table('YearSubject')->insertGetId(['Syear'=>$year, 'Semes'=>$semes, 'Sid'=>$this->addSubjectDB()]);

    }

}