<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ClassModel
{
    /**
     * ClassRoom Identifier Number
     * 클래스 ID
     * @var int
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
     * @param int $id
     * @param string $url
     * @param string $name
     * @param string $profile_image
     */
    public function setAll(int $id, string $url, string $name, string $profile_image)
    {
        $this->id = $id;
        $this->url = $url;
        $this->name = $name;
        $this->profile_image = $profile_image;
    }

    /**
     * ClassModel setFromArray
     * @param array $classroom
     */
    public function setAllFromArray(array $classroom)
    {
        $this->id = (int)$classroom['id'];
        $this->url = $classroom['url'];
        $this->name = $classroom['name'];
        $this->profile_image = $classroom['profile_image'];
    }

    /**
     * 클래스 배열에서 클래스 모델의 배열로 변환합니다.
     * @param mixed $classrooms 컬랙션
     * @return array
     */
    public static function getClassesFromObjectArray($classrooms)
    {
        $classes[] = new ClassModel();
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
    public function insertDB() {
        $count = DB::table('Class')
            ->where('CTid', '=', $this->getId())
            ->count();
        if ($count == 0) {
            return DB::table('Class')->insert([
                'CTid' => $this->getId(),
                'Name' => $this->getName(),
                'URL' => $this->getUrl(),
                'Profile' => $this->getProfileImage()
            ]);
        }
        return false;
    }

    public function toJSON(){
        return json_encode(get_object_vars($this));
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     *
     * @param int $id
     */
    public function setId(int $id): void
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
        $data = $request->Ting_Get('/v2/classes/' . $classId);
        $this->addClassInfo($data);
        return $data;
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
     * @return mixed
     */
    public function getClassList($token, $userId)
    {
        $request = new ClasstingRequest($token);
        $datas = $request->Ting_Get('/v2/users/' . $userId . '/joined_classes');
        $models = ClassModel::getClassesFromObjectArray($datas);
        foreach($models as $model){
            $model->insertDB();
        }

    }

}

?>