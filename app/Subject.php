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
            ->get(['Sid'])->toArray();
        if (count($id) > 0)
            return get_object_vars($id[0])['Sid'];
        return DB::table('Subject')->insertGetId(['Name'=>$this->name]);
    }

    public function addYearSubjectDB($year, $semes){

        $this->YSid = DB::table('YearSubject')
        ->where('SYear', $year)
        ->where('Semes', $semes)
        ->where('Sid', $this->addSubjectDB())
        ->get(['YSid'])->toArray();
        if (count($this->YSid) == 0)
            return $this->YSid = DB::table('YearSubject')->insertGetId(['Syear'=>$year, 'Semes'=>$semes, 'Sid'=>$this->addSubjectDB()]);
        else
            return $this->YSid = get_object_vars($this->YSid[0])['YSid'];
    }

}