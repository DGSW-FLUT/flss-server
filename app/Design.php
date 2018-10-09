<?php
/**
 * Created by PhpStorm.
 * User: Jin
 * Date: 2018-10-09
 * Time: 오전 6:45
 */

namespace App;

use Illuminate\Support\Facades\DB;

class Design
{
    public function addDesign($cid,$title){
        return DB::table('Design')->insertGetId([
            'Cid' => $cid,
            'Title' => $title
        ]);
    }

    public function addFile($did,$mid){
        return DB::table('ClassAttach')->insert([
            'Did' => $did,
            'Mid' => $mid
        ]);
    }

    public function designList($cid){
        return DB::table('Design')->select()->where('Cid','=',$cid)->get();
    }

    public function oneDesign($did){
        return DB::table('ClassAttach')->select()->where('Did','=',$did)->get();
    }
}