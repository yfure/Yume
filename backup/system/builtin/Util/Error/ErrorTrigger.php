<?php

namespace Yume\Kama\Obi\Error;

use function Yume\Func\view;

use Yume\Kama\Obi\AoE;

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
    public static function handler( Int $code, String $strg, String $file = Null, Int $line = 0 ): Void
    {
        // Replace BasePath
        $strg = str_replace( BASE_PATH, "", $strg );
        $file = str_replace( BASE_PATH, "", $file );
        
        // Get Error Level.
        $levl = self::level( $code );
        
        $data = [
            'code' => $code,
            'strg' => $strg,
            'file' => $file,
            'line' => $line,
            'levl' => $levl
        ];
        
        // Write error.
        parent::write( "/triggers/", $data );
        
        // View Error.
        $view = "/system/builtin/Util/Error/views/trigger/";
        
        if( isCommandLineInterface )
        {
            $view .= "cli";
        } else
            $view .= "web";
        
        // Display error.
        echo( view( $view, $data ) );
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