<?php

namespace App\Services\Admin;

use App\Services\Admin\BankService;
use App\Services\Admin\GroupService;
use App\Services\Admin\TestService;
use App\Services\Admin\QuizService;

class BackstageServices{
    protected $items=['totalSales', 'totalVisits', 'totalFavorites','todayOrders', 'thisMonthOrders'];  

    function __construct( protected TotalSalesService $totalSales,
                          protected TotalVisitsService $totalVisits,
                          protected TotalFavoritesService $totalFavorites,
                          protected TodayOrdersService $todayOrders,
                          protected ThisMonthOrdersService $thisMonthOrders ){}

    function getInfos()
    {
        $infos=[]; //裝每個功能回傳的資料
        foreach($this->items as $item)
        {
            $infos[$item]=$this->$item->infos();
        }
        return $infos;
    }
}