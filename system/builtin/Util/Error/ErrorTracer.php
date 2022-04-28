<?php

namespace Yume\Util\Error;

use Yume\Util\Exception;
use Yume\Util\Himei;
use Yume\Util\Reflection;

use Throwable;

abstract class ErrorTracer extends ErrorProvider implements ErrorInterface
{
    public static function handler( Throwable $e ): Void
    {
        $prev = [];
        
        if( Himei\Application::config( "error.tracer.allow" ) )
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
            
            $driver = Reflection\ReflectionInstance::reflect( Himei\Application::config( "error.tracer.driver" ) );
            
            if( $driver->implementsInterface( Exception\PSTrace\PSTraceInterface::class ) )
            {
                
                parent::write( "/traces/", ( $driver = $driver->newInstanceArgs([ $prev, Himei\Application::config( "error.tracer.traces" ) ]) )->getTraces() );
                
                $driver->out();
                
            }
        }
    }
    
    
    
}

?>
