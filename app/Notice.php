<?php
/**
 * Created by PhpStorm.
 * User: Jin
 * Date: 2018-10-23
 * Time: 오후 5:15
 */

namespace App;

use Illuminate\Support\Facades\DB;
use Exception;
class Notice
{
    public static function addContents($cid, $column, $contents){
        try {
            DB::table('Notice')->updateOrInsert(['Cid' => $cid], [
                'Cid' => $cid,
                $column => $contents
            ]);
            return 1;
        } catch (Exception $e){
            return -1;
        }
    }

    public static function showNotice($cid){
        try {
            return DB::table('Notice')->where('Cid', '=', $cid)->pluck('Contents')[0];
        } catch (Exception $e) {
            return -1;
        }
    }
}