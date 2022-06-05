<?php

namespace Yume\Kama\Obi\AoE\Buffer;

use Yume\Kama\Obi\Reflector;

trait Refresh
{
    public function refresh( Int $filter = Null ): Static
    {
        // 
        return( Reflector\Zaisan::refresh( $this ) );
    }
}

?>