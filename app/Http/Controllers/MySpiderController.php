<?php

namespace App\Http\Controllers;

use App\Spiders\MySpider;
use RoachPHP\Roach;

class MySpiderController
{
    public function parse()
    {
        Roach::startSpider(MySpider::class);
    }
}
