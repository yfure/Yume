<?php

namespace Yume\Kama\Obi\AoE;

use Yume\Kama\Obi\Reflection;

trait Refresh
{
    public function refresh( Int $filter = Null ): Static
    {
        // 
        return( Reflection\ReflectionProperty::refresh( $this ) );
    }
}

?>