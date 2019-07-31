<?php

namespace App\Observers;

use App\Models\Link;
use Cache;

class LinkObserver
{
    // 在保存时清空 cache_key 的缓存
    public function saved(Link $link)
    {
        Cache::forget($link->cache_key);
    }
}
