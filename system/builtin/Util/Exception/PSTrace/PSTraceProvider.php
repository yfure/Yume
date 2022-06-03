<?php

namespace Yume\Kama\Obi\Exception\PSTrace;

use Yume\Kama\Obi\HTTP;
use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\Reflection;
use Yume\Kama\Obi\HTTP\Route;

use Throwable;

final class PSTraceProvider implements PSTraceInterface
{
    
    protected $prev;
    
    /*
     * The Exception Stack Traces.
     *
     * @values Array
     */
    protected $traces;
    
    /*
     * The Throwable Class Thrown.
     *
     * @values Throwable
     */
    protected $object;
    
    /*
     * Trace value as String.
     *
     * @values String
     */
    protected $result;
    
    /*
     * @inheritdoc PSTraceInterface
     *
     */
    public function __construct( Array | Throwable $object, Array $traces )
    {
        
        $this->traces = $traces;
        
        $this->object = $object;
        
        // Parameter value is previous.
        if( is_array( $this->object ) ) {
            
            // Save previous.
            $this->prev = $this->object;
            
            // Save thrown object.
            $this->object = $this->object[0];
            
            // Unset the first exception object.
            unset( $this->prev[0] );
            
            foreach( $this->prev As $i => $prev )
            {
                // Set new element.
                $this->prev[$prev::class] = ( new PSTraceProvider( $prev, $traces ) )->getTraces();
                
                // Unset the current element.
                unset( $this->prev[$i] );
            }
        }
        
        /** Register Keywords. */
        PSTraceKeywords::register();
        
        /** Create Exception Stack. */
        $this->traces = $this->stack( $this->traces );
        
        if( isCommandLineInterface )
        {
            $this->result = new PSTraceCli( $this );
        } else {
            if( AoE\App::$object->__isset( 'response' ) )
            {
                if( AoE\App::$object->response === "json" )
                {
                    $this->result = new PSTraceApi( $this );
                } else {
                    $this->result = new PSTraceWeb( $this );
                }
            } else {
                $this->result = new PSTraceWeb( $this );
            }
        }
    }
    
    public function out(): Void
    {
        echo $this->getResult();
    }
    
    /*
     * @inheritdoc PSTraceInterface
     */
    public function getPrev(): ? Array
    {
        return( $this->prev );
    }
    
    /*
     * @inheritdoc PSTraceInterface
     */
    public function getTraces(): ? Array
    {
        return( $this->traces );
    }
    
    /*
     * @inheritdoc PSTraceInterface
     */
    public function getObject(): ? Throwable
    {
        return( $this->object );
    }
    
    /*
     * @inheritdoc PSTraceInterface
     */
    public function getResult(): ? String
    {
        return( $this->result )?->result;
    }
    
    private function stack( Array $pre ): Array
    {
        foreach( $pre As $key => $val )
        {
            if( is_array( $val ) )
            {
                $pre[HTTP\Filter\RegExp::replace( "/(\@)/", $key, "" )] = $this->stack( $val );
            } else {
                
                $pre[HTTP\Filter\RegExp::replace( "/(\@)/", $val, "" )] = call_user_func( function() use( $val ) {
                    
                    $key = HTTP\Filter\RegExp::replace( "/(\@)/", $val, "" );
                    
                    if( method_exists( $this->object, $method = "get{$key}" ) )
                    {
                        if( $key === "Previous" )
                        {
                            if( $this->prev !== Null )
                            {
                                return( $this->prev );
                            }
                        }
                        return( Reflection\ReflectionMethod::invoke( $this->object, $method ) );
                    } else {
                        if( $key === "Class" )
                        {
                            return( $this->object::class );
                        }
                        if( $key === "Trait" )
                        {
                            return( Reflection\ReflectionInstance::getTraits( $this->object ) );
                        }
                        if( $key === "Parent" )
                        {
                            return( Reflection\ReflectionInstance::getParent( $this->object ) );
                        }
                        if( $key === "Interface" )
                        {
                            $interfaces = Reflection\ReflectionInstance::getInterfaces( $this->object );
                            
                            foreach( $interfaces As $i => $interface )
                            {
                                unset( $interfaces[$i] );
                                
                                $interfaces[] = $i;
                            }
                            return( $interfaces );
                        }
                    }
                    return Null;
                });
            }
            unset( $pre[$key] );
        }
        return( $pre );
    }
    
}

?>