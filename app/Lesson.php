<?php

namespace App;

use Illuminate\Support\Facades\DB;
use App\iDBModel;

class Lesson implements iDBModel
{

    /**
     * @var int Lesson no (optional)
     */
    protected $Lno;

    /**
     * @var Cloud
     */
    protected $Video;

    /**
     * @var int
     */
    protected $Cid;

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
     * @var int
     */
    protected $Owner;

    /**
     * Lesson 전부 설정.
     * @param Cloud $Video
     * @param int $cid
     * @param string $Name
     * @param string $Explain
     * @param Subject $Subject
     * @param string $Unit
     * @param int $Owner
     */
    public function setAll(Cloud $Video, int $cid, string $Name, string $Explain, Subject $Subject, string $Unit, int $Owner)
    {
        $this->Video = $Video;
        $this->Cid = $cid;
        $this->Name = $Name;
        $this->Explain = $Explain;
        $this->Subject = $Subject;
        $this->Unit = $Unit;
        $this->Owner = $Owner;
    }

    /**
     * @return int
     */
    public function deleteLessonDB(){
        return DB::table('Lesson')->delete(['Lno'=>$this->Lno]);
    }



    public function insertDB() : int
    {
        return DB::table('Lesson')->insertGetId($this->toArray());
    }

    public function toArray(): array
    {
        $arrays = get_object_vars($this);
        $arrays['Vid'] = $this->Video->getMid();
        $arrays['YSid'] = $this->Subject->YSid;
        unset($arrays['Video']);
        unset($arrays['Subject']);

        return $arrays;
    }

    public static function getLessonList($cid) : array{
        return DB::table('Lesson')->select()->where('Cid', '=', $cid)->get()->toArray();
    }

    /**
     * @return int
     */
    public function getLno(): int
    {
        return $this->Lno;
    }

    /**
     * @param int $Lno
     */
    public function setLno(int $Lno): void
    {
        $this->Lno = $Lno;

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
     * @return int
     */
    public function getCid(): int
    {
        return $this->Cid;
    }

    /**
     * @param int $Cid
     */
    public function setCid(int $Cid): void
    {
        $this->Cid = $Cid;
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
     * @return int
     */
    public function getOwner(): int
    {
        return $this->Owner;
    }

    /**
     * @param int $Owner
     */
    public function setOwner(int $Owner): void
    {
        $this->Owner = $Owner;
    }
    //endregion

}