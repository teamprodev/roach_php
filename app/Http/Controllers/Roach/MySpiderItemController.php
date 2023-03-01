<?php

namespace App\Http\Controllers\Roach;

use App\Models\Spider;
use RoachPHP\ItemPipeline\ItemInterface;
use RoachPHP\ItemPipeline\Processors\ItemProcessorInterface;

class MySpiderItemController implements ItemProcessorInterface
{

    public function configure(array $options): void
    {
    }

    public function processItem(ItemInterface $item): ItemInterface
    {
        $spider = new Spider();
        $spider->title = $item->get('title');
        $spider->subtitle = $item->get('subtitle');
        $spider->save();
        return $item;
    }
}
