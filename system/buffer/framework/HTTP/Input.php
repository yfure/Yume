<?php

namespace Yume\Kama\Obi\HTTP;

use Yume\Kama\Obi\AoE;

use Egulias\EmailValidator;

/*
 * Input utility class.
 *
 * @package Yume\Kama\Obi\HTTP
 */
abstract class Input extends Request
{
    
    public const EMAIL = 8027;
    public const UNAME = 5282;
    public const PASSW = 2272;
    public const PHONE = 6273;
    
    /*
     * Returns the value of the POST request,
     * received by the server, and validates it.
     *
     * Note that validating only equalizes based
     * on the regexp pattern and it doesn't
     * replace any characters.
     *
     * @access Public, Static
     *
     * @params String <key>
     * @params String <pattern>
     *
     * @return Mixed
     */
    final public static function post( String $key, Int $flags = 0 ): Mixed
    {
        if( isset( $_POST[$key] ) && empty( $_POST[$key] ) !== True )
        {
            if( $flags !== 0 )
            {
                if( $flags === self::EMAIL )
                {
                    if( AoE\App::$object->__isset( 'emailValidator' ) === False )
                    {
                        AoE\App::$object->emailValidator = new EmailValidator\EmailValidator();
                    }
                    $valid = AoE\App::$object->emailValidator->isValid( $_POST[$key], new EmailValidator\Validation\RFCValidation() );
                }
                if( $flags === self::UNAME )
                {
                    $valid = ( Bool ) preg_match( "/^([a-z_][a-z0-9_\.]{1,28}[a-z0-9_])$/", $_POST[$key] );
                }
                if( $flags === self::PASSW )
                {
                    $valid = ( Bool ) preg_match( "/(((?=.*[a-z])(?=.*[a-zA-Z]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[a-zA-Z])(?=.*[0-9])))(?=.{6,})/", $_POST[$key] );
                }
                return([
                     
                     // Data request.
                     'value' => $_POST[$key],
                     
                     // Validate request value.
                     'valid' => $valid
                     
                ]);
            }
            return( $_POST[$key] );
        }
        return( Null );
    }
    
}

?>