<?php

namespace Yume\Kama\Obi\Exception\PSTrace;

class PSTraceCliColor
{
    public function create( Mixed $val, String $type )
    {
        return( "{$this->type( $type )}{$val}\e[0m" );
    }
    
    public function type( String $type )
    {
        return( $type === "val" ? "\e[1;37m" : "\e[0m" );
    }
    
}

?>