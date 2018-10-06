<?php
/**
 * Created by PhpStorm.
 * User: tbvja
 * Date: 2018-09-25
 * Time: 오후 9:44
 */

namespace App;


use Illuminate\Support\Facades\DB;
use App\iDBModel;

/**
 * Flss 파일 저장소
 * @package App
 */
class Cloud implements iDBModel
{

    /**
     * Cloud 테이블 pk (ai)
     * @var int
     */
    protected $Mid;
    /**
     * 파일 링크 (유튜브, 로컬 파일 경로)
     * @var string
     */
    protected $Link;

    /**
     * 파일 이름
     * @var string
     */
    protected $Name;

    /**
     * 클래스 id (파일들은 한 클래스에 귀속되어 있다)
     * @var int
     */
    protected $Cid;

    /**
     * Cloud constructor.
     * @param string $Name
     * @param string $link
     * @param int $Cid
     */
    public function __construct(string $Name = null, string $link = null, int $Cid = null)
    {
        $this->setName($Name);
        $this->setLink($link);
        $this->setCid($Cid);
    }

    public function insertDB()
    {
        echo $this->getLink();
        if (strpos($this->getLink(), '://') != false )
            return $this->Mid = DB::table('Cloud')->insertGetId(['Name' => $this->getName(), 'Link' => $this->getLink(), 'Cid' => $this->getCid()]);
        else
            return $this->Mid = DB::table('Cloud')->insertGetId(['Name' => $this->getName(), 'File' => $this->getLink(), 'Cid' => $this->getCid()]);

    }

    public static function getAllList($cid){
        return DB::table('Cloud')->select()->where('Cid','=',$cid)->get();
    }

    public function toArray() : array
    {
        return get_object_vars($this);
    }

    /**
     * @return int
     */
    public function getMid(): int
    {
        return $this->Mid;
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
     * @return string|null
     */
    public function getLink()
    {
        return $this->Link;
    }

    /**
     * @param mixed $Link
     */
    public function setLink(string $Link): void
    {
        $this->Link = $Link;
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


}