<?php

namespace Yume\Kama\Obi\Database\Driver\PDO;

use Yume\Kama\Obi\Database;
use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\Trouble;

use PDO;

abstract class PDOProvider extends PDO
{
    
    /*
     * Data Source Name Database.
     *
     * @access Protected
     *
     * @values String
     */
    protected $dsn;
    
    /*
     * Database sql query.
     *
     * @access Protected
     *
     * @values String
     */
    protected $query;
    
    /*
     * Database query parameter.
     *
     * @access Protected
     *
     * @values Array
     */
    protected $params = [];
    
    /*
     * Database server name.
     *
     * @access Protected
     *
     * @values String
     */
    protected $server;
    
    /*
     * PHPDataObject class instance.
     *
     * @access Public
     *
     * @params Array <config>
     *
     * @return Static
     */
    public function __construct( private String $name, private Array $config )
    {
        
        /*
         * The pdo options.
         *
         * Get options for database drivers.
         */
        $options = isset( $config['driver']['options'] ) ? $config['driver']['options'] : [];
        
        /*
         * The pdo attributes.
         *
         * Get attribute for database drivers.
         */
        $attributes = isset( $config['driver']['attributes'] ) ? $config['driver']['attributes'] : [];
        
        /*
         * The database credentials.
         *
         * @username String, Null
         * @password String, Null
         */
        $username = $config['database']['private']['username'];
        $password = $config['database']['private']['password'];
        
        /*
         * Call parent class PDO constructor.
         *
         * @params String <dsn>
         * @params String, Null <username>
         * @params String, Null <password>
         * @params Array, Null <options>
         */
        parent::__construct( $this->dsn = $this->dsn( $config ), $username, $password, $options );
        
        foreach( $attributes As $attribute => $value )
        {
            parent::setAttribute( $attribute, $value );
        }
        
    }
    
    /*
     * Disconnect Database connection.
     *
     * @access Public
     *
     * @return Void
     */
    public function __destruct()
    {
        Database\Connection::disconnect( $this->name );
    }
    
    /*
     * Create new Data Source Name by database.
     * And Return Data Source Name Database.
     *
     * @access Public
     *
     * @params Array <config>
     *
     * @return String
     */
    final public function dsn( Array $config = [] ): String
    {
        if( $this->dsn === Null )
        {
            $this->dsn = PDODSN::{ $this->server() }( $config );
        }
        return( $this->dsn );
    }
    
    final public function stmt(): Bool | Null | PDOStatement
    {
        return( $this->stmt );
    }
    
    final public function execute( ? Array $params = Null ): Bool
    {
        return( $this->prepare() )->execute( $this->params );
    }
    
    final public function prepare( ? String $query = Null, Array $options = [] ): Bool | PDOStatement
    {
        return( $this->stmt = parent::prepare( $query !== Null ? $query : $this->query, $options ) );
    }
    
    /*
     * Return database connection name.
     *
     * @access Public
     *
     * @return String
     */
    final public function name(): String
    {
        return( $this->name );
    }
    
    /*
     * Return database server name.
     *
     * @access Public
     *
     * @return String
     */
    final public function server(): String
    {
        return( $this->server );
    }
    
    /*
     * Return database config.
     *
     * @access Public
     *
     * @return Array
     */
    final public function config(): Array
    {
        return( $this->config );
    }
    
    /*
     * Delete existing records in a table.
     *
     * @access Public
     *
     * @params String <table>
     *
     * @return ...
     */
    abstract public function delete( String $table );
    
    /*
     * Insert new records in a table.
     *
     * @access Public
     *
     * @params String <table>
     * @params Array <column>
     *
     * @return ...
     */
    abstract public function insert( String $table, Array $column );
    
    /*
     * Select data from a database.
     *
     * @access Public
     *
     * @params String <table>
     * @params Array <column>
     *
     * @return ...
     */
    abstract public function select( String $table, Array $column );
    
    /*
     * Modify the existing records in a table.
     *
     * @access Public
     *
     * @params String <table>
     * @params Array <column>
     *
     * @return ...
     */
    abstract public function update( String $table, Array $column );
    
}

?>