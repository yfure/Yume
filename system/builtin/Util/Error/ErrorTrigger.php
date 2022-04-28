<?php

namespace Yume\Util\Error;

use function Yume\Func\view;

use Yume\Util\Himei;

/*
 * ErrorTrigger utility class.
 *
 * @package Yume\Util\Error
 */
abstract class ErrorTrigger extends ErrorProvider implements ErrorInterface
{
    
    /*
     * Predefined Error Constant.
     *
     * @values Array
     */
    public static $error = [
        E_ERROR => "E_ERROR",
        E_WARNING => "E_WARNING",
        E_PARSE => "E_PARSE",
        E_NOTICE => "E_NOTICE",
        E_CORE_ERROR => "E_CORE_ERROR",
        E_CORE_WARNING => "E_CORE_WARNING",
        E_COMPILE_ERROR => "E_COMPILE_ERROR",
        E_COMPILE_WARNING => "E_COMPILE_WARNING",
        E_USER_ERROR => "E_USER_ERROR",
        E_USER_WARNING => "E_USER_WARNING",
        E_USER_NOTICE => "E_USER_NOTICE",
        E_STRICT => "E_STRICT",
        E_RECOVERABLE_ERROR => "E_RECOVERABLE_ERROR",
        E_DEPRECATED => "E_DEPRECATED",
        E_USER_DEPRECATED => "E_USER_DEPRECATED",
        E_ALL => "E_ALL"
    ];
    
    /*
     * Default error handler function.
     *
     * @access Public, Static
     *
     * @params Int <code>
     * @params String <strg>
     * @params String <file>
     * @params Int <line>
     *
     * @return Void
     */
    public static function handler( Int $code, String $string, String $file = Null, Int $line = 0 ): Void
    {
        
        $error = [
            'error' => [
                
                'code' => $code,
                'line' => $line,
                
                // Get Error Level or Type.
                'type' => $level = self::level( $code ),
                
                // Replace Base Path string.
                'file' => $file = str_replace( BASE_PATH, "", $file ),
                'message' => $message = str_replace( BASE_PATH, "", $string )
                
            ]
        ];
        
        // Write error.
        parent::write( "/triggers/", $error );
        
        if( Himei\Application::$object->__isset( 'response' ) && Himei\Application::$object->response === "json" )
        {
            exit( json_encode( $error, JSON_PRETTY_PRINT ) );
        } else {
            exit( view( "/system/builtin/Util/Error/views/trigger/", $error ) );
        }
        
    }
    
    /*
     * Get error level.
     *
     * @access Public, Static
     *
     * @params Int <code>
     *
     * @return String
     */
    public static function level( Int $code ): String
    {
        foreach( self::$error As $errno => $level )
        {
            if( $errno === $code )
            {
                return( $level );
            }
        }
        return( "E_UNDEFINED" );
    }
    
}

?>
