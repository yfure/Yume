<?php

namespace Yume\Kama\Obi\Database;

use PDO;

class Driver extends PDO
{
    
    public $attributes = [];
    
    // Overrideable methods inherited from PDO class.
    public function __construct( Array $configs )
    {
        // Call parent constructor.
        parent::__construct(
            
            // Create PHP Document Object Dsn.
            $this->dsn( $configs ),
            
            // Database Username.
            $configs['username'],
            
            // Database Password.
            $configs['password'],
            
            // PDO Options
            $configs['options']
        );
        
        // Get PDO Driver Attributes.
        $this->attributes = Database::config( "attributes" );
        
        foreach( $this->attributes As $attr => $val )
        {
            // Set PDO Driver Attributes.
            $this->setAttribute( $attr, $val );
        }
    }
    
    public function dsn( Array $configs ): String
    {
        return( "{$configs['type']}:host={$configs['host']};port={$configs['port']};dbname={$configs['database']};" );
    }
    
}

?>