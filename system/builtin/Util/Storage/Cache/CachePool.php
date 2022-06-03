<?php

namespace Yume\Kama\Obi\Cache;

class CachePool implements CachePoolInterface
{
    
    public function __construct( public Readonly Cache $cache, public Readonly String $pool )
    {
        $cache->path->create( $pool );
    }
    
}

?>