<?php

namespace Yume\Kama\Obi\Reflection;

use Yume\Kama\Obi\HTTP;

/*
 * ReflectionParameter utility class.
 *
 * @package Yume\Kama\Obi\Reflection
 */
abstract ReflectionParameter
{
    
    /*
     * Create parameter for constructor, function, & method.
     *
     * @access Public, Static
     *
     * @params Array <params>
     * @params Array <values>
     *
     * @return Array
     */
    public static function parameter( Array $params, Array $values = [] ): Array
    {
        if( isset( $values[0] ) === False )
        {
            foreach( $params As $param )
            {
                
            }
        }
        return( $values );
    }
    
}

?>