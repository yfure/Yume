<?php

namespace Yume\Func;

use Throwable;

use Yume\Kama\Obi\Exception;
use Yume\Kama\Obi\Reflection;

/*
 * Handle exception and errors.
 *
 * @params Exception <object>
 *
 * @return Void
 */
function printStackTrace( Array | Throwable $object )
{
    // Get Stack Trace configuration.
    $configs = config( "app" )['pstrace'];
    
    // Check permission.
    if( $configs['allow'] ) {
        
        // Get Driver Interface.
        $interface = Reflection\ReflectionInstance::interface( $configs['driver'] );
        
        // Check if the Interface exists.
        if( isset( $interface[PSTrace\PrintStackTraceInterface::class] ) ) {
            
            // Get Result.
            return( Reflection\ReflectionInstance::construct( $configs['driver'], [ $object, $configs['traces'] ] ) )?->getResult();
        }
        
    }
    return False;
}

/*
 * ....
 *
 * @params Array <id>
 * @params String <in>
 *
 * @return String
 */
function printStackTraceAnsi( Array $id, String $in ): String
{
    return "\e[{$id[0]};{$id[1]}m{$in}";
}

/*
 * ....
 *
 * @params Int <id>
 * @params String <in>
 *
 * @return String
 */
function printStackTraceSpan( Int $id, String $in ): String
{
    if( $id !== 4492 && $id !== 7746 ) {
        $in = preg_replace_callback( pattern: "/(\.|\||\\\|\*|\/)/", subject: $in, callback: function( $m ) {
            
            // ....
            return printStackTraceSpan( 7746, $m[1] );
        });
    }
    return "<span class=\"hx{$id}\">{$in}</span>";
}

?>