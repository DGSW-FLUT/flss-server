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
}