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
class Cloud
{
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
            if (DB::table('Cloud')->insert(['Name' => $this->getName(), 'Link' => $this->getLink()]))
                return get_object_vars(DB::select('select LAST_INSERT_ID()')[0])['LAST_INSERT_ID()'];
            else
                return false;
        else
            if (DB::table('Cloud')->insert(['Name' => $this->getName(), 'File' => $this->getLink()]))
                return get_object_vars(DB::select('select LAST_INSERT_ID()')[0])['LAST_INSERT_ID()'];
            else
                return false;

    }

    public function toArray()
    {
        return get_object_vars($this);
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