<?php

namespace Yume\Kama\Obi\Cache;

use Function Yume\Func\{
    config,
    path
};

use Yume\Kama\Obi\{
    Fairu,
    Keisitu,
    Security
};

abstract class Cache implements CacheInterface
{
    
    public static function init() {}
    
    public static function get( String $key ): CacheItemInterface
    {
        
    }
    
    public static function multiGet( Array $keys ): Iterator
    {
        
    }
    
    public static function save( CacheItemInterface $item ): Bool
    {
        
    }
    
    public static function multiSave( Iterator $items ): Bool
    {
        
    }
    
}

?>