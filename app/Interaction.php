<?php
/**
 * Created by PhpStorm.
 * User: tbvja
 * Date: 2018-10-29
 * Time: 오전 8:37
 */

namespace App;

use Illuminate\Support\Facades\DB;
class Interaction implements iDBModel
{
    public $topic;
    public $cid;

    public function __construct($topic, $cid)
    {
        $this->topic = $topic;
        $this->cid = $cid;
    }

    public function insertDB()
    {
        return DB::table("Interaction")
            ->insertGetId(['Topic' => $this->topic, 'Cid' => $this->cid]);
    }

    public function toArray(): array
    {
        return null;
    }

    public static function getInteractionList($cid) {
        return DB::table("Interaction")
            ->select()
            ->where('Cid', '=', $cid)
            ->get()
            ->toArray();
    }
}