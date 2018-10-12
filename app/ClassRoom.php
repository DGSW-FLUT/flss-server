<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\iDBModel;

class ClassModel implements iDBModel
{

    protected $cid;
    /**
     * ClassRoom Identifier Number
     * 클래스 ID
     * @var string
     */
    protected $id;

    /**
     * Classroom Url
     * 클래스 URL (클래스팅의 url)
     * @var string
     */
    protected $url;


    /**
     * Classroom Name
     * 클래스 이름
     * @var string
     */
    protected $name;

    /**
     *
     * Classroom Profile Image url
     * 클래스 이미지 url
     * @var string
     */
    protected $profile_image;

    /**
     * ClassModel setAll.
     * @param string $id
     * @param string $url
     * @param string $name
     * @param string $profile_image
     */
    public function setAll(string $id, string $url, string $name, string $profile_image)
    {
        $this->id = $id;
        $this->url = $url;
        $this->name = $name;
        $this->profile_image = $profile_image;
    }

    public function setFromDB($id)
    {
        $data = DB::table("Class")->select()->where('CTid', '=', $id)->orWhere('Cid', '=', $id)->get()->toArray();

        if ($data && $data[0]) {
            $this->setAllFromArray($data[0]);

            return true;
        }
        return false;
    }

    /**
     * ClassModel setFromArray
     * @param array|object $classroom
     */
    public function setAllFromArray($classroom)
    {

        if (is_object($classroom)) {
            $classroom = get_object_vars($classroom);
        }
        if (isset($classroom['id']))
            $this->id = $classroom['id'];
        else
            $this->id = $classroom['CTid'];

        if (isset($classroom['url']))
            $this->url = $classroom['url'];
        else
            $this->url = $classroom['URL'];

        if (isset($classroom['name']))
            $this->name = $classroom['name'];
        else
            $this->name = $classroom['Name'];

        if (isset($classroom['profile_image']))
            $this->profile_image = $classroom['profile_image'];
        else
            $this->profile_image = $classroom['Profile'];
    }

    /**
     * 클래스 배열에서 클래스 모델의 배열로 변환합니다.
     * @param mixed $classrooms 컬랙션
     * @return array
     */
    public static function getClassesFromObjectArray($classrooms)
    {

        foreach ($classrooms as $classroom) {
            $c = new ClassModel();
            $c->setAllFromArray($classroom);
            $classes[] = $c;
        }
        return $classes;
    }


    /**
     * 해당 model을 DB에 넣습니다.
     * @return bool
     */
    public function insertDB()
    {
        $cid = DB::table('Class')
            ->where('CTid', '=', $this->getId())
            ->pluck('Cid');
        if (count($cid) == 0) {
            $this->cid = $this->id = DB::table('Class')->insertGetId([
                'CTid' => $this->getId(),
                'Name' => $this->getName(),
                'URL' => $this->getUrl(),
                'Profile' => $this->getProfileImage()
            ]);
            return true;
        } else {
            $this->cid = $cid[0];
            return true;
        }
    }


    public function toJSON()
    {
        return json_encode($this->toArray());
    }

    public function toArray() : array{
        return get_object_vars($this);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     *
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }


    /**
     * @return mixed
     */
    public function getProfileImage()
    {
        return $this->profile_image;
    }

    /**
     * @param mixed $profile_image
     */
    public function setProfileImage($profile_image): void
    {
        $this->profile_image = $profile_image;
    }
}

class ClassRoom extends Model
{

    /**
     * 한 class의 세부정보를 가지고 옵니다.
     * @param int $cid
     * @return array
     */
    public function getClassDB(int $cid)
    {
        $classes = DB::table('Class')
            ->select()
            ->where('CTid', '=', $cid)
            ->orwhere('Cid', '=', $cid)
            ->get();
        return ClassModel::getClassesFromObjectArray($classes);
    }

    /**
     * @param $classInfo
     * @return ClassModel
     */
    public function addClassInfo($classInfo)
    {
        $classModel = new ClassModel();
        $classModel->setAllFromArray($classInfo);
        $classModel->insertDB();
        return $classModel;
    }


    /**
     * @param $token
     * @param $classId
     * @return mixed
     */
    public function getClassInfo($token, $classId)
    {
        $request = new ClasstingRequest($token);
        $model = new ClassModel();

        if (!$model->setFromDB($classId)) {
            $data = $request->Ting_Get('/v2/classes/' . $classId);
            if ($data == null)
                return null;
            $model->setAllFromArray($data);
            $model->insertDB();
        }
        return $model->toArray();
    }

    /**
     * @param $token
     * @param $classId
     * @return mixed
     */
    public function getClassMember($token, $classId)
    {
        $request = new ClasstingRequest($token);
        return $request->Ting_Get('/v2/classes/' . $classId . '/members');
    }

    /**
     * @param $token
     * @param $userId
     * @return array
     */
    public function getClassList($token, $userId)
    {
        $request = new ClasstingRequest($token);
        $datas = $request->Ting_Get('/v2/users/' . $userId . '/joined_classes');
        if ($datas == null)
            return null;

        $models = ClassModel::getClassesFromObjectArray($datas);

        foreach ($models as $model) {
            $model->insertDB();
            $classes[] = $model->toArray();
        }

        return $classes;

    }

}

?>