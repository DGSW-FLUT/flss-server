<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Cloud;
use App\Portfolio;

class PortfolioController
{
    private $request = null;

    private $Cloud;
    /**
     * ClassController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
     * FormData에서부터 pdf를 받아옵니다.
     * @param  number
     * @return bool|string
     */
    public function uploadVideo($Cid)
    {
        if ($this->request->hasFile('portfolio'))
        {
            $file = $this->request->file('portfolio');
            $path = $file->move('portfoliofile', uniqid().$file->getClientOriginalName())->getFilename();
            $this->Cloud = new Cloud($file->getClientOriginalName(), $path, $Cid, 'student');
            return $this->Cloud->insertDB();
        } else {
            return false;
        }
    }
    public function addPortfolio() {
        $UserId = $this->request->input('uid');
        $ClassId = $this->request->input('cid');
        $Mid = $this->uploadVideo($ClassId);
        if ($Mid) {
            $portfolio = new Portfolio($UserId, $Mid);
            return $portfolio->insertDB();
        }
        return 'Insert Error';
    }
    public function getPortfolioList() {
        $ClassId = $this->request->query('cid');
        if (!$ClassId)
            return 'Cid가 전달되지 않았습니다.';
        return Portfolio::getPortfolioList($ClassId);
    }
}