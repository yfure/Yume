<?php

namespace Yume\Util\Himei;

use Yume\Util\Reflection;

trait Refresh
{
    public function refresh( Int $filter = Null ): Static
    {
        // 
        return( Reflection\ReflectionProperty::refresh( $this ) );
    }
}

?>
