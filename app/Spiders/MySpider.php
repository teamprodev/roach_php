<?php

namespace App\Spiders;

use App\Http\Controllers\Roach\MySpiderItemController;
use DateTime;
use Generator;
use RoachPHP\Downloader\Middleware\RequestDeduplicationMiddleware;
use RoachPHP\Extensions\LoggerExtension;
use RoachPHP\Extensions\StatsCollectorExtension;
use RoachPHP\Http\Request;
use RoachPHP\Http\Response;
use RoachPHP\Spider\BasicSpider;
use RoachPHP\Spider\ParseResult;

class MySpider extends BasicSpider
{
//    public array $startUrls = [
//        'https://www.amazon.com/'
//    ];

    public array $downloaderMiddleware = [
        RequestDeduplicationMiddleware::class,

    ];

    public array $spiderMiddleware = [
        //
    ];

    public array $itemProcessors = [
        MySpiderItemController::class
    ];

    public array $extensions = [
        LoggerExtension::class,
        StatsCollectorExtension::class,
    ];

    public int $concurrency = 2;

    public int $requestDelay = 1;

    /**
     * @return Generator<ParseResult>
     */
    public function parse(Response $response): Generator
    {
        $title = $response->filter('h4')->text();
        $subtitle = $response
            ->filter('main > div:nth-child(2) p:first-of-type')
            ->text();

        yield $this->item([
            'title' => $title,
            'subtitle' => $subtitle,
        ]);
    }

    /** @return Request[] */
    protected function initialRequests(): array
    {
        return [
            new Request(
                'GET',
                "https://roach-php.dev/docs/downloader-middleware",
                [$this, 'parse']
            ),
        ];
    }

}
