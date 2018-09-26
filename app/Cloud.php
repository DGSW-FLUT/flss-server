<?php
/**
 * Created by PhpStorm.
 * User: tbvja
 * Date: 2018-09-25
 * Time: 오후 9:44
 */

namespace App;


use Illuminate\Support\Facades\DB;

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
     * Cloud constructor.
     * @param string $Name
     * @param string $link
     */
    public function __construct(string $Name = null, string $link = null)
    {
        $this->setName($Name);
        $this->setLink($link);
    }

    public function insertDB()
    {

        if (strpos($this->getLink(), 'http://') != false)
            return $Mid = DB::table('Cloud')->insertGetId(['Name' => $this->getName(), 'Link' => $this->getLink()]);
        else
            return $Mid = DB::table('Cloud')->insertGetId(['Name' => $this->getName(), 'File' => $this->getLink()]);

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