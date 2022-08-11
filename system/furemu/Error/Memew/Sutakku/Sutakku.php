<?php

namespace Yume\Fure\Error\Memew\Sutakku;

use Yume\Fure\AoE;
use Yume\Fure\Reflector;
use Yume\Fure\Error;
use Yume\Fure\Threader;

use Throwable;

/*
 * Sutakku
 *
 * The Sutakku class is a class that defines
 * the order in which exceptions are thrown.
 *
 * @package Yume\Fure\Error\Memew\Sutakku
 */
class Sutakku implements SutakkuInterface
{
    
    /*
     * The Exception thrown.
     *
     * @access Private
     *
     * @values Throwable
     */
    private $object;
    
    /*
     * The Exception stack trace.
     *
     * @access Private
     *
     * @values Array
     */
    private $stacks = [];
    
    /*
     * The Exception previous.
     *
     * @access Private
     *
     * @values Array
     */
    private $previs;
    
    /*
     * Construct method of class Sutakku.
     *
     * @access Public Instance
     *
     * @params Throwable $object
     *
     * @return Void
     */
    public function __construct( Array | Throwable $object )
    {
        if( is_array( $object ) )
        {
            $i = 0;
            
            foreach( $object As $name => $previous )
            {
                if( $i !== 0 )
                {
                    $this->previs[$name] = ( new Sutakku( $previous ) )->getStacks();
                } else {
                    $this->object = $previous;
                }
                $i++;
            }
        } else {
            $this->object = $object;
        }
        
        $this->stacks = $this->stack();
        
    }
    
    /*
     * @inherit Yume\Fure\Error\Memew\SutakkuInterface
     *
     */
    public function getObject(): Throwable
    {
        return( $this->object );
    }
    
    /*
     * @inherit Yume\Fure\Error\Memew\SutakkuInterface
     *
     */
    public function getStacks(): Array
    {
        return( $this->stacks );
    }
    
    /*
     * @inherit Yume\Fure\Error\Memew\SutakkuInterface
     *
     */
    public function getPrevis(): ? Array
    {
        return( $this->previs );
    }
    
    /*
     * Get stack.
     *
     * @access Public
     *
     * @params String $trace
     *
     * @return Mixed
     */
    private function stack( ? Array $traces = Null )
    {
        if( $traces === Null )
        {
            /*
             * Get default scheme.
             *
             * @values Array
             */
            $traces  = Threader\App::config( "trouble.exception.scheme" );
        }
        
        $scheme = [];
        
        foreach( $traces As $key => $value )
        {
            if( is_array( $value ) )
            {
                $scheme[$key] = $this->stack( $value );
            } else {
                
                $scheme[$value] = match( $value )
                {
                    // The source of the thrown Throwable.
                    "File" => path( $this->object->getFile(), True ),
                    
                    // Handle traces.
                    "Trace" => call_user_func( function()
                    {
                        // Get all traces.
                        $traces = $this->object->getTrace();
                        
                        // Checks if the exception thrown is of class Error Trigger Exception.
                        if( $this->object Instanceof Error\TriggerError )
                        {
                            /*
                             * Unset the first & second trace value
                             *
                             * If you are thinking why is this done because, the first trace will contain
                             * the information where the TriggerError class exception was thrown whereas
                             * the second trace contains the information where the Error Handler Function
                             * was called because, basically the error handled has been re-thrown by the
                             * Error Handler Function and not necessarily the first and second traces
                             * in the track list.
                             */
                            unset( $traces[0] );
                            unset( $traces[1] );
                        }
                        
                        // Check if traces are allowed to be displayed.
                        if( Threader\App::config( "trouble.exception.trace.all" ) )
                        {
                            // Mapping error traces.
                            $traces = array_map( array: $traces, callback: function( $trace )
                            {
                                // Check if argument values are allowed to be displayed
                                if( Threader\App::config( "trouble.exception.trace.arg" ) !== True )
                                {
                                    // Clear all argument values.
                                    $trace['args'] = [];
                                }
                                
                                if( isset( $trace['file'] ) )
                                {
                                    // Clear field names from BASE PATH.
                                    $trace['file'] = path( $trace['file'], True );
                                }
                                
                                // Return trace.
                                return( $trace );
                            });
                        } else {
                            
                            // No traces diplay.
                            return([]);
                        }
                        return( $traces );
                    }),
                    
                    // Throwable class name.
                    "Class" => $this->object::class,
                    
                    // List of Traits used.
                    "Trait" => Reflector\ReflectClass::getTraits( $this->object, True ),
                    
                    // Throwable parent class name.
                    "Parent" => Reflector\ReflectClass::getParentTree( $this->object ),
                    
                    // Throwable message.
                    "Message" => path( $this->object->getMessage(), True ),
                    
                    // Get the previous exception.
                    "Previous" => call_user_func( function()
                    {
                        // Check if exception class has previous.
                        if( $this->object->getPrevious() !== Null && $this->previs !== Null )
                        {
                            return( array_map( array: $this->previs, callback: function( $prev )
                            {
                                // Remove traces.
                                $prev['Trace'] = f( "@inherit {}", $this->object::class );
                                
                                // ...
                                return( $prev );
                            }));
                        }
                        return([]);
                    }),
                    
                    // List of Interfaces implemented.
                    "Interface" => Reflector\ReflectClass::getInterfaces( $this->object, True ),
                    
                    default => call_user_func_array( args: [ $key, $value ], callback: function( $key, $value )
                    {
                        // Check if the method is available.
                        if( method_exists( $this->object, $method = f( "get{}", $value ) ) )
                        {
                            // Return method value.
                            return( $this->object->{ $method }() );
                        }
                        return( "Undefined" );
                    })
                    
                };
                
            }
        }
        
        return( $scheme );
    }
    
}

?>