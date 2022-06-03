<?php

namespace Yume\Kama\Obi\Cache;

interface CacheInterface
{
    public function pool( String $key ): CachePoolInterface;
}

?>