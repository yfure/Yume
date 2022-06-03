<?php

namespace Yume\Kama\Obi\Error;

use Yume\Kama\Obi\Exception;
use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\Reflection;

use Throwable;

abstract class ErrorTracer extends ErrorProvider implements ErrorInterface
{
    public static function handler( Throwable $e ): Void
    {
        $prev = [];
        
        if( AoE\App::config( "error.tracer.allow" ) )
        {
            if( $e->getPrevious() !== Null )
            {
                
                /** Keep throwing exceptions. **/
                $prev[] = $e;
                
                /** .... */
                while( $e = $e->getPrevious() ) { $prev[] = $e; }
            } else {
                
                /** If previous is empty. **/
                $prev = $e;
            }
            
            $driver = Reflection\ReflectionInstance::reflect( AoE\App::config( "error.tracer.driver" ) );
            
            if( $driver->implementsInterface( Exception\PSTrace\PSTraceInterface::class ) )
            {
                $driver->newInstanceArgs([ $prev, AoE\App::config( "error.tracer.traces" ) ])->out();
            }
        }
    }
    
    
    
}

?>