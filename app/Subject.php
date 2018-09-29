<?php

namespace App;

use Illuminate\Support\Facades\DB;
use App\iDBModel;

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
        $id = DB::table('Subject')
            ->where('Name', $this->name)
            ->get(['Sid'])[0]->Sid;

        if ($id)
            return $id;
        return DB::table('Subject')->insertGetId(['Name'=>$this->name]);
    }

    public function addYearSubjectDB($year, $semes){

        $this->YSid = DB::table('YearSubject')
        ->where('SYear', $year)
        ->where('Semes', $semes)
        ->where('Sid', $this->addSubjectDB())
        ->get(['YSid'])[0]->YSid;
        if (!$this->YSid)
            return $YSid = DB::table('YearSubject')->insertGetId(['Syear'=>$year, 'Semes'=>$semes, 'Sid'=>$this->addSubjectDB()]);
    }

}