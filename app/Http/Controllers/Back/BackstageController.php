<?php

namespace App\Http\Controllers\Back;
use App\Http\Controllers\Controller; // 引用基類
use App\Services\Admin\BackstageServices;
class BackstageController extends Controller
{
    protected $backstage;

    public function __construct(BackstageServices $backstage)
    {
        $this->backstage = $backstage;
    }

    public function index()
    {
        $infos = $this->backstage->getInfos();
        return view('admin.index', compact('infos'));
    }
}
