<?php

namespace Yume\Kama\Obi\Database;

use Yume\Kama\Obi\Reflection;

class Model
{
    /*
     * Database Connection.
     *
     * @values \Yume\Kama\Obi\Database\Database
     */
    protected $database;
    
    use \Yume\Kama\Obi\Database\Traits\Table;
    
    public function __construct()
    {
        // Create or get the database connection.
        $this->database = new Database( $this->connection );
    }
    
}

?>