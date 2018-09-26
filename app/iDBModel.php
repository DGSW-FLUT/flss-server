<?php
/**
 * Created by PhpStorm.
 * User: tbvja
 * Date: 2018-09-26
 * Time: 오후 3:35
 */

namespace App;


interface iDBModel
{
    public function insertDB();
    public function toArray() : array;

}