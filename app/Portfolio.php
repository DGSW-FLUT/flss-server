<?php
/**
 * Created by PhpStorm.
 * User: tbvja
 * Date: 2018-10-22
 * Time: 오후 10:33
 */

namespace App;

use Illuminate\Support\Facades\DB;

class Portfolio
{
    public $Uid;
    public $Mid;
    public function __construct($Uid, $Mid)
    {
        $this->Mid = $Mid;
        $this->Uid= $Uid;
    }
    public function insertDB() {
        return DB::table('Portfolio')
            ->insertGetId(get_object_vars($this));
    }
    public static function getPortfolioList($Cid) {
        return DB::table('Portfolio')
            ->select()
            ->join('Cloud', 'Portfolio.Mid', '=', 'Cloud.Mid')
            ->join('User', 'Portfolio.Uid', '=', 'User.Uid')
            ->where('Cloud.Cid', '=', $Cid)
            ->get('*')
            ->toArray();
    }
}