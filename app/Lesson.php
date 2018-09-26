<?php
/**
 * Created by PhpStorm.
 * User: tbvja
 * Date: 2018-09-26
 * Time: 오후 1:14
 */


namespace App;


use Illuminate\Support\Facades\DB;

class Lesson implements iDBModel
{



    /**
     * @var Cloud
     */
    protected $Video;

    /**
     * @var ClassModel
     */
    protected $Class;

    /**
     * @var string
     */
    protected $Name;

    /**
     * @var string
     */
    protected $Explain;

    /**
     * @var Subject
     */
    protected $Subject;

    /**
     * @var string
     */
    protected $Unit;

    /**
     * @var UserModel
     */
    protected $Owner;

    public function __construct()
    {
    
    }

    public function insertDB() : int
    {
        return DB::table('Lesson')->insertGetId($this->toArray());
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    //region GetterSetter
    /**
     * @return Cloud
     */
    public function getVideo(): Cloud
    {
        return $this->Video;
    }

    /**
     * @param Cloud $Video
     */
    public function setVideo(Cloud $Video): void
    {
        $this->Video = $Video;
    }

    /**
     * @return ClassModel
     */
    public function getClass(): ClassModel
    {
        return $this->Class;
    }

    /**
     * @param ClassModel $Class
     */
    public function setClass(ClassModel $Class): void
    {
        $this->Class = $Class;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->Name;
    }

    /**
     * @param string $Name
     */
    public function setName(string $Name): void
    {
        $this->Name = $Name;
    }

    /**
     * @return string
     */
    public function getExplain(): string
    {
        return $this->Explain;
    }

    /**
     * @param string $Explain
     */
    public function setExplain(string $Explain): void
    {
        $this->Explain = $Explain;
    }

    /**
     * @return Subject
     */
    public function getSubject(): Subject
    {
        return $this->Subject;
    }

    /**
     * @param Subject $Subject
     */
    public function setSubject(Subject $Subject): void
    {
        $this->Subject = $Subject;
    }

    /**
     * @return string
     */
    public function getUnit(): string
    {
        return $this->Unit;
    }

    /**
     * @param string $Unit
     */
    public function setUnit(string $Unit): void
    {
        $this->Unit = $Unit;
    }

    /**
     * @return UserModel
     */
    public function getOwner(): UserModel
    {
        return $this->Owner;
    }

    /**
     * @param UserModel $Owner
     */
    public function setOwner(UserModel $Owner): void
    {
        $this->Owner = $Owner;
    }
    //endregion

}