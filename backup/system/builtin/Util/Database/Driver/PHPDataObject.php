<?php

namespace Yume\Kama\Obi\Database\Driver;

use Yume\Kama\Obi\Database;
use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\Trouble;

use PDO;

class PHPDataObject extends PDO
{
    
    /*
     * Data Source Name Database.
     *
     * @access Protected
     *
     * @values String
     */
    protected String $dsn;
    
    /*
     * PHPDataObject class instance.
     *
     * @access Public
     *
     * @params Yume\Kama\Obi\AoE\Data <config>
     *
     * @return Static
     */
    public function __construct( String $server, AoE\Data $config )
    {
        
        /*
         * The pdo options.
         *
         * Get options for database drivers.
         *
         * If the connection does not define
         * options for the driver, then it will
         * take the default options for the driver.
         *
         */
        if( $config->database->driver->__isset( 'options' ) )
        {
            $options = $config->database->driver->options;
        } else {
            $options = Database\Database::config( "drivers" )->PDO->options;
        }
        
        /*
         * The pdo attributes.
         *
         * Get attribute for database drivers.
         *
         * If the connection does not define
         * attribute for the driver, then it will
         * take the default attribute for the driver.
         *
         */
        if( $config->database->driver->__isset( 'attributes' ) )
        {
            $attributes = $config->database->driver->attributes;
        } else {
            $attributes = Database\Database::config( "drivers" )->PDO->attributes;
        }
        
        /*
         * The database credentials.
         *
         * @username String, Null
         * @password String, Null
         */
        $username = $config->database->private->username;
        $password = $config->database->private->password;
        
        /*
         * Call parent class PDO constructor.
         *
         * @params String <dsn>
         * @params String, Null <username>
         * @params String, Null <password>
         * @params Array, Null <options>
         */
        parent::__construct( $this->dsn = PHPDataObjectDSN::create( $server, $config ), $username, $password, $options );
        
        foreach( $attributes As $attribute => $value )
        {
            parent::setAttribute( $attribute, $value );
        }
        
    }
    
    /*
     * Return Data Source Name Database.
     *
     * @access Public
     *
     * @return String
     */
    final public function getDsn(): String
    {
        return( $this->dsn );
    }
    
}

?>