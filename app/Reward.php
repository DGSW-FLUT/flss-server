<?php
/**
 * Created by PhpStorm.
 * User: Jin
 * Date: 2018-10-07
 * Time: 오전 12:06
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Exception;

class RewardModel
{
    protected $cid;

    protected $uid;

    protected $role;

    protected $count;

    protected $name;
    public function __construct()
    {

    }

    public function setAllFromArray($student, $cid)
    {

        if (is_object($student)) {
            $student = get_object_vars($student);
        }
        if (isset($student['id']))
            $this->uid = $student['id'];
        else
            $this->uid = $student['id'];

        $this->name = $student['name'];
        $this->role = $student['role'];
        $this->cid = $cid;
        $this->count = 0;
    }


    public static function getClassesFromObjectArray($students, $cid)
    {

        foreach ($students as $student) {
            $r = new RewardModel();
            $r->setAllFromArray($student, $cid);
            $studentlist[] = $r;
        }
        return $studentlist;
    }


    /**
     * 해당 model을 DB에 넣습니다.
     * @return bool
     */
    public function insertDB()
    {
        $uid = DB::table('UserReward')
            ->where('Uid', '=', $this->uid)
            ->pluck('Uid');

        if (count($uid) == 0 && $this->role == 'student') {

            return DB::table('UserReward')->insertGetId([
                'Cid' => $this->cid,
                'Uid' => $this->uid,
                'Count' => $this->count,
                'Name' => $this->name
            ]);
        }

        return false;
    }

    public static function getStudentList($cid){
        return DB::table('UserReward')->select()->where('Cid','=',$cid)->get();
    }

    public function addPoint($uid, $count){
        return DB::table('UserReward')->where('Uid', '=', $uid)->update(['Count' => $count]);
    }
}
class Reward
{
    public function addStudent($token,$cid){
        $request = new ClasstingRequest($token);
        $datas = $request->Ting_Get('/v2/classes/' . $cid . '/members');

        if ($datas == null)
            return null;
        $models = RewardModel::getClassesFromObjectArray($datas, $cid);

        foreach ($models as $model) {
            $model->insertDB();
        }
        return 1;
    }

    public function getStudent($cid){
        return RewardModel::getStudentList($cid);
    }

    public function addStudentPoint($uid, $point){
        $reward = new RewardModel();
        try{
            for($i = 0; $i < count($uid); $i++){
                $reward->addPoint($uid[$i],$point[$i]);
            }
            return 1;
        }catch(Exception $e){
            return $reward->addPoint($uid,$point);
        }
    }
}