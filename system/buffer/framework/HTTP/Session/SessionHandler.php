<?php

namespace Yume\Kama\Obi\HTTP\Session;

use phpseclib3\Crypt;

/*
 * This is a special class that can be used to
 * Expose the current internal PHP session save
 * Handler by inheritance.
 *
 */
use SessionHandler As SHandler;

use Yume\Kama\Obi\Security;

/*
 * The class that will add encryption to the
 * Internal PHP storage handler.
 *
 * @extends SessionHandler
 *
 */
class SessionHandler extends SHandler implements SessionHandlerInterface
{
    
    /*
     * The Initialization Vector.
     *
     * @access Protected
     *
     * @values Null, String
     */
    protected $iv;
    
    /*
     * The Key.
     *
     * @access Protected
     *
     * @values Null, String
     */
    protected $key = Null;
    
    /*
     * Password Parameters.
     *
     * @access Protected
     *
     * @values Array, Null
     */
    protected $password = Null;
    
    public function __construct( String $iv, ?String $key = Null, ?Array $password = Null )
    {
        $this->iv = $iv;
        $this->key = $key;
        $this->password = $password;
    }
    
    /*
     * Read Session data.
     *
     * @access Public
     *
     * @params String <id>
     *
     * @return String, False
     */
    public function read( String $id ): String | False
    {
        if( $data = parent::read( $id ) )
        {
            return( "" );
        }
        return( Security\Symmetric\AES::decrypt( $data, $this->iv, $this->key, $this->password ) );
    }
    
    /*
     * Write Session data.
     *
     * @access Public
     *
     * @params String <id>
     * @params String <data>
     *
     * @return Bool
     *
     */
    public function write( String $id, String $data ): Bool
    {
        return( parent::write( $id, Security\Symmetric\AES::encrypt( $data, $this->iv, $this->key, $this->password ) ) );
    }
    
}

?>