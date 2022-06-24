<?php

namespace Yume\Kama\Obi\AoE\Buffer;

trait Closure
{
    
    /*
     * Overloading in PHP provides means to
     * Dynamically create properties and methods.
     *
     * @access Public
     *
     * @params String <method>
     * @params Array <args>
     *
     * @return Mixed
     */
    public function __call( String $method, ? Array $args = Null )
    {
        return( call_user_func_array( $this->{ $method }, $args ) );
    }
    
}

?>