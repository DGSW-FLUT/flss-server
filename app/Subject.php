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

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function addSubjectDB(){
        DB::table('Subject')->insert(['Name'=>$this->name]);
    }

    public function addYearSubjectDB($year, $semes){
        $this->addSubjectDB();
        $Sid = get_object_vars(DB::select('select Sid from Subject where Name = ?', [$this->name])[0])['Sid'];
        DB::table('YearSubject')->insert(['Syear'=>$year, 'Semes'=>$semes, 'Sid'=>$Sid]);
        return get_object_vars(DB::select('select YSid from YearSubject where Syear = ? and Semes = ? and Sid = ?', [$year, $semes, $Sid])[0])['YSid'];
    }
}