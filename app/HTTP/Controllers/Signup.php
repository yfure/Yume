<?php

namespace Yume\App\HTTP\Controllers;

use Yume\App\Models;
use Yume\App\Views;

use Yume\Fure\HTTP;

/*
 * Signup Controller
 *
 * @extends Yume\App\HTTP\Controllers\Api
 *
 * @package Yume\App\HTTP\Controllers
 */
class Signup extends Api
{
    
    /*
     * If csrftoken is invalid or expired.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const CSRFTOKEN_ERROR = 5778;
    
    /*
     * If user is exists.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const DUPLICATE_ERROR = 5785;
    
    /*
     * If failed insert user into database.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const INSERTION_ERROR = 5788;
    
    /*
     * If user has been loged.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const SESSIONID_ERROR = 5798;
    
    /*
     * Main method of Signup controller.
     *
     * @access Public
     *
     * @return Array
     */
    public function main()
    {
        // Check if user has been loged.
        if( HTTP\Cookies\Cookie::get( "sessionid" ) )
        {
            return([
                "error" => self::SESSIONID_ERROR,
                "status" => "failed",
                "message" => "Something wrong."
            ]);
        } else {
            
            // Check if csrftoken signup is valid.
            if( HTTP\CSRFToken\CSRFToken::validate( "signup" ) )
            {
                
            }
            return([
                "error" => self::CSRFTOKEN_ERROR,
                "status" => "failed",
                "message" => "Invalid request."
            ]);
        }
    }
    
    /*
     * Generate new csrftoken for signup.
     *
     * @access Protected
     *
     * @return String
     */
    protected function csrftoken(): String
    {
        return( HTTP\CSRFToken\CSRFToken::generate( "signup" ) );
    }
    
}

?>