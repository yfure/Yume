<?php

namespace Yume\Kama\Obi\Error\Memew\Sutakku;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\Reflector;

use Throwable;

/*
 * Sutakku
 *
 * The Sutakku class is a class that defines
 * the order in which exceptions are thrown.
 *
 * @package Yume\Kama\Obi\Error\Memew\Sutakku
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
     * @access Public: Instance
     *
     * @params Throwable $object
     *
     * @return Static
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
                    $this->previs[$name] = new Sutakku( $previous );
                    $this->previs[$name] = $this->previs[$name]->getStacks();
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
     * @inherit Yume\Kama\Obi\Error\Memew\SutakkuInterface
     *
     */
    public function getObject(): Throwable
    {
        return( $this->object );
    }
    
    /*
     * @inherit Yume\Kama\Obi\Error\Memew\SutakkuInterface
     *
     */
    public function getStacks(): Array
    {
        return( $this->stacks );
    }
    
    /*
     * @inherit Yume\Kama\Obi\Error\Memew\SutakkuInterface
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
            $traces  = AoE\App::config( "trouble.exception.scheme" );
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
                    
                    // Throwable class name.
                    "Class" => $this->object::class,
                    
                    // List of Traits used.
                    "Trait" => Reflector\Kurasu::getTraits( $this->object, True ),
                    
                    // Throwable parent class name.
                    "Parent" => Reflector\Kurasu::getParentTree( $this->object ),
                    
                    // Throwable message.
                    "Message" => path( $this->object->getMessage(), True ),
                    
                    // Get the previous exception.
                    "Previous" => $this->object->getPrevious() !== Null ? $this->previs : [],
                    
                    // List of Interfaces implemented.
                    "Interface" => Reflector\Kurasu::getInterfaces( $this->object, True ),
                    
                    default => call_user_func( fn() => method_exists( $this->object, $method = format( "get{}", $value ) ) ? $this->object->{ $method }() : "Undefined" )
                    
                };
                
            }
        }
        
        return( $scheme );
    }
    
}

?>