<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\Redis;

class TotalVisitsService
{
    public function infos()
    {
        return [
            'site_total_visits' => Redis::get('site_total_visits') ?? 0
        ];
    }
}


