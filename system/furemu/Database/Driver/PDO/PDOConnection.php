<?php

namespace Yume\Fure\Database\Driver\PDO;

use Yume\Fure\AoE;
use Yume\Fure\Database;

use ArrayAccess;

use PDO;

/*
 * PDOConnection
 *
 * @extends PDO
 *
 * @package Yume\Fure\Database\Driver\PDO
 */
class PDOConnection extends PDO implements Database\DatabaseDriverInterface
{
    use Database\DatabaseDriverTrait;
    
    /*
     * @inherit Yume\Fure\Database\DatabaseDriverInterface
     *
     */
    public function __construct( protected String $connection, protected AoE\Data $options, protected AoE\Data $configs )
    {
        // Create Data Source Name.
        $this->dsn = PDOBuilder::dsn( $this->configs );
        
        // Check if the connection has additional options.
        if( $this->configs->__isset( "options" ) )
        {
            $this->configs->options = [
                ...$this->options->options,
                ...$this->configs->options
            ];
        } else {
            $this->configs->options = $this->options->options;
        }
        
        // Call parent class PDO constructor.
        parent::__construct(
            
            // PDO Data Source Name.
            dsn: $this->dsn, 
            
            // PDO Options/ Attributes.
            options: $this->configs->options,
            
            // PDO Database Username & Password.
            username: $this->configs->connect->{ "database.user" },
            password: $this->configs->connect->{ "database.pass" }
        );
        
    }
    
}

?>