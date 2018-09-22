<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model {
    /**
     * ClassRoom Identifier Number 
     * @var int
     */
    protected $id;

    /**
     * Classroom Url
     * @var string
     */
    protected $url;

    /**
     * Classroom Year
     * @var int
     */
    protected $year;
    
    /*
     * Classroom Name
     * @var string
     */
    protected $name;

    /*
     * Classroom Open Class Boolean
     * @var boolean
     */
    protected $is_openclass;

    /*
     * Classroom Create Time
     * @var DateTime
     */
    protected $created_at;

    /*
     * Classroom Profile Image url
     * @var string
     * */
    protected $profile_image;

    /*
     * Classroom School Name
     * @var string
     * */
    protected $school_name;

    /*
     * Classroom Member Count
     * @var int
     * */
    protected $member_count;

    public function __construct($id, $url, $year, $name, $is_openclass, $created_at, $member_count, $profile_image, $school_name)
    {
        $this->setId($id);
        $this->setUrl($url);
        $this->setYear($year);
        $this->setName($name);
        $this->setIsOpenclass($is_openclass);
        $this->setCreatedAt($created_at);
        $this->setMemberCount($member_count);
        $this->setProfileImage($profile_image);
        $this->setSchoolName($school_name);
    }

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
?>