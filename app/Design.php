<?php
/**
 * Created by PhpStorm.
 * User: Jin
 * Date: 2018-10-09
 * Time: 오전 6:45
 */

namespace App;

use Illuminate\Support\Facades\DB;
use Exception;
class Design
{
    public function addDesign($cid,$title){
        return DB::table('Design')->insertGetId([
            'Cid' => $cid,
            'Title' => $title
        ]);
    }

    public function addFile($did,$mid){
        try {
            DB::table('ClassAttach')->insert([
                'Did' => $did,
                'Mid' => $mid
            ]);
            return 1;
        } catch(Exception $e){
            return 0;
        }
    }

    public function designList($cid){
        return DB::table('Design')->select()->where('Cid','=',$cid)->get();
    }

    public function oneDesign($did){
        return DB::table('ClassAttach')->select()
            ->join('Design','Design.Did','=','ClassAttach.Did')
            ->join('Cloud','Cloud.Mid','=','ClassAttach.Mid')
            ->where('ClassAttach.Did','=',$did)->get();
    }
}