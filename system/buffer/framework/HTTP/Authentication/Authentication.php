<?php

namespace Yume\Kama\Obi\HTTP\Authentication;

use Yume\Kama\Obi\Database;
use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\HTTP;
use Yume\Kama\Obi\Model;

/*
 * Authentication utility class.
 *
 * @package Yume\Kama\Obi\HTTP\Authentication
 */
class Authentication extends HTTP\HTTP
{
    
    /*
     * Login Password & Username.
     *
     * @access Private
     *
     * @values String
     */
    private ? String $username, $password;
    
    protected Object $model;
    
    /*
     * ....
     *
     * @access Protected
     *
     * @values Bool
     */
    protected Bool $checked, $logged = False;
    
    /*
     * The Authentication class instance.
     *
     * @access Public
     *
     * @params ...
     *
     * @return Static
     */
    public function __construct()
    {
        $this->username = Null;
        $this->password = Null;
        
        if( isset( $_SERVER['PHP_AUTH_USER'] ) === False )
        {
            if( isset( $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ) )
            {
                $_SERVER['HTTP_AUTHORIZATION'] = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
            }
            if( isset( $_SERVER['HTTP_AUTHORIZATION'] ) && strtolower( substr( $_SERVER['HTTP_AUTHORIZATION'] , 0 , 6 ) ) === "basic " )
            {
                if( count( $array = explode( ":" , base64_decode( substr( $_SERVER['HTTP_AUTHORIZATION'], 6 ) ) ) ) > 1 )
                {
                    $_SERVER['PHP_AUTH_USER'] = $array[0];
                    $_SERVER['PHP_AUTH_PW'] = $array[1];
                }
            }
        }
        if( isset( $_SERVER['PHP_AUTH_USER'] ) )
        {
            $username = $_SERVER['PHP_AUTH_USER'];
            $password = $_SERVER['PHP_AUTH_PW'];
        } else {
            if( parent::config( "authentication" )['session']['allow'] )
            {
                $username = HTTP\Session\Session::get( parent::config( "authentication.session.index.0" ) );
                $password = HTTP\Session\Session::get( parent::config( "authentication.session.index.1" ) );
            }
            if( $username === Null || $password === Null )
            {
                if( parent::config( "authentication" )['cookie']['allow'] )
                {
                    $username = HTTP\Cookie\Cookie::get( parent::config( "authentication.cookie.index.0" ) );
                    $password = HTTP\Cookie\Cookie::get( parent::config( "authentication.cookie.index.1" ) );
                }
            }
        }
        $this->check( $username, $password );
    }
    
    /*
     * ....
     *
     * @access Public
     *
     * @return Static
     */
    public function save()
    {
        if( parent::config( "authentication.cookie.allow" ) )
        {
            HTTP\Cookie\Cookie::set( parent::config( "authentication.cookie.index.0" ) )->value( $this->username )->save();
            HTTP\Cookie\Cookie::set( parent::config( "authentication.cookie.index.1" ) )->value( $this->password )->save();
        }
        if( parent::config( "authentication.session.allow" ) )
        {
            HTTP\Session\Session::set( parent::config( "authentication.session.index.0" ), $this->username );
            HTTP\Session\Session::set( parent::config( "authentication.session.index.1" ), $this->password );
        }
        return( $this );
    }
    
    /*
     * ....
     *
     * @access Public
     *
     * @return Bool
     */
    public function auth(): Bool
    {
        if( $this->checked !== False )
        {
            return( $this->logged );
        }
        return( $this->logged );
    }
    
    /*
     * Validate Login Username & Password.
     *
     * @access Public
     *
     * @params String <user>
     * @params String <pass>
     *
     * @return Bool
     */
    public function valid( String $user, String $pass ): Bool
    {
        
    }
    
    /*
     * Encode login password.
     *
     * @access Public
     *
     * @params String <password>
     *
     * @return String
     */
    private function encode( String $pass ): String
    {
        return( md5( hash( "sha512", $pass ) ) );
    }
    
    /*
     * Remove string slash.
     *
     * @access Public, Static
     *
     * @params String <string>
     *
     * @return String
     */
    private function strips( String $string )
    {
        return( HTTP\Filter\RegExp::replace( "/\t|\x09|\n|\x0A|\r|\x0D|\0|\x00|\v|\x0B|\'|\"|\\\/", $string, "" ) );
    }
    
    /*
     * Check authenticated user credentials.
     *
     * @access Private
     *
     * @params String, Null <username>
     * @params String, Null <password>
     *
     * @return Void
     */
    private function check( ? String $username, ? String $password ): Void
    {
        if( $username !== Null && $password !== Null )
        {
            // Model
        }
        $this->checked = True;
    }
    
}

?>