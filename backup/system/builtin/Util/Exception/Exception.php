<?php

namespace Yume\Kama\Obi\Exception;

use Throwable;

class Exception extends \Exception implements \Trouble
{
    
    /*
     * To identify if error code is undefined.
     *
     * @access Public, Static
     *
     * @values Int
     */
    const UNDEFINED = 0;
    
    /*
     * @inheritdoc Yume\Kama\Obi\Exception\ExceptionInterface
     *
     */
    public function __construct( Object | String $class, String $message, Int $code = 0, ? Throwable $prev = Null )
    {
        
        // Remove class prefix namespace.
        $class = self::removePrefixClass( $class );
        
        // Call the parent constructor.
        parent::_construct( "{$class}::\"{$message}\";", $code, $prev );
        
    }
    
    /*
     * Remove class prefix namespace.
     *
     * @access Public
     *
     * @params Object, String <class>
     *
     * @return String
     */
    public function removePrefixClass(): String
    {
        if( is_object( $class ) )
        {
            $class = $class::class;
        }
        return( str_replace( \Yume\Kama\Obi::class, "", $class ) );
    }
    
}

?>