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
     * Classroom Year
     * 클래스 년도
     * @var int
     */
    protected $year;

    /*
     * Classroom Name
     * 클래스 이름
     * @var string
     */
    protected $name;

    /*
     * Classroom Open Class Boolean
     * 클래스 공개 여부
     * @var boolean
     */
    protected $is_openclass;

    /*
     * Classroom Create Time
     * 클래스 생성 일자
     * @var DateTime
     */
    protected $created_at;

    /*
     * Classroom Profile Image url
     * 클래스 이미지 url
     * @var string
     * */
    protected $profile_image;

    /*
     * Classroom School Name
     * 클래스가 속한 학교
     * @var string
     * */
    protected $school_name;

//    /*
//     * Classroom Member Count
//     * 클래스에 포함된 멤버 수
//     * @var int
//     * */
//    protected $member_count;
//
//    public function __construct($id, $url, $year, $name, $is_openclass, $created_at, $member_count, $profile_image, $school_name)
//    {
//        $this->id = $id;
//        $this->url = $url;
//        $this->year = $year;
//        $this->name = $name;
//        $this->is_openclass = $is_openclass;
//        $this->created_at = $created_at;
//        $this->member_count = $member_count;
//        $this->profile_image = $profile_image;
//        $this->school_name = $school_name;
//    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
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
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @param int $year
     */
    public function setYear(int $year): void
    {
        $this->year = $year;
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
    public function getisOpenclass()
    {
        return $this->is_openclass;
    }

    /**
     * @param mixed $is_openclass
     */
    public function setIsOpenclass($is_openclass): void
    {
        $this->is_openclass = $is_openclass;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at): void
    {
        $this->created_at = $created_at;
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

    /**
     * @return mixed
     */
    public function getSchoolName()
    {
        return $this->school_name;
    }

    /**
     * @param mixed $school_name
     */
    public function setSchoolName($school_name): void
    {
        $this->school_name = $school_name;
    }

    /**
     * @return mixed
     */
    public function getMemberCount()
    {
        return $this->member_count;
    }

    /**
     * @param mixed $member_count
     */
    public function setMemberCount($member_count): void
    {
        $this->member_count = $member_count;
    }


}

class ClassRoom extends Model
{

    public function getClassInfoDB($token, $id)
    {
        $data = DB::select('select * from Class where cid = ?', [$id]);
        return $data;
    }

    /**
     * @param ClassModel $classModel
     */
    public function addClassModel(ClassModel $classModel): bool
    {
        $count = DB::table('Class')->where('CTid', '=', $classModel->getId())->count();
        if ($count == 0)
        {
            return DB::table('Class')->insert([
                'CTid' => $classModel->getId(),
                'Name' => $classModel->getName(),
                'URL' => $classModel->getUrl(),
                'Profile' => $classModel->getProfileImage()
            ]);
        }
        return false;
  }

    public function addClassInfo($classInfo)
    {
        $classModel = new ClassModel();
        $classModel->setId((int)$classInfo['id']);
        $classModel->setName($classInfo['name']);
        $classModel->setUrl($classInfo['url']);
        $classModel->setProfileImage($classInfo['profile_image']);
        $this->addClassModel($classModel);
        return $classModel;
    }

    public function getClassInfo($token, $classId)
    {
        $request = new ClasstingRequest($token);
        $data = $request->Ting_Get('/v2/classes/' . $classId);
        $this->addClassInfo($data);
        return $data;
    }

    public function getClassMember($token, $classId)
    {
        $request = new ClasstingRequest($token);
        return $request->Ting_Get('/v2/classes/' . $classId . '/members');
    }

    public function getClassList($token, $userId)
    {
        $request = new ClasstingRequest($token);
        return $request->Ting_Get('/v2/users/' . $userId . '/joined_classes');
    }

}

?>