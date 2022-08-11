<?php

namespace Yume\Fure\Database;

use Yume\Fure\AoE;

/*
 * DatabaseModel
 *
 * @package Yume\Fure\Database
 */
abstract class DatabaseModel implements DatabaseModelInterface
{
    
    /*
     * Database Connection name.
     *
     * @access Protected
     *
     * @values String
     */
    protected $connection;
    
    /*
     * Database Connection instance.
     *
     * @access Protected
     *
     * @values String
     */
    protected $database;
    
    /*
     * Allow to perform automatic increment.
     *
     * @access Protected
     *
     * @values Bool
     */
    protected $increment = False;
    
    /*
     * Column Maximum increment value length.
     *
     * @access Protected
     *
     * @values Int
     */
    protected $incrementMax = 10;
    
    /*
     * Column incement value type.
     *
     * @access Protected
     *
     * @values String
     */
    protected $incrementValue;
    
    /*
     * Table primary key name.
     *
     * @access Protected
     *
     * @values String
     */
    protected $primaryKey;
    
    /*
     * Table name.
     *
     * @access Protected
     *
     * @values String
     */
    protected $table;
    
    /*
     * Column prefix name.
     *
     * @access Protected
     *
     * @values String
     */
    protected $tableColumnPrefix;
    
    /*
     * Column names without prefix name.
     *
     * @access Protected
     *
     * @values Array
     */
    protected $tableColumnUnprefix = [];
    
    /*
     * Allow autofil for timestamp.
     *
     * @access Protected
     *
     * @values Bool
     */
    protected $created = False;
    protected $updated = False;
    
    /*
     * Construct method of class DatabaseModel
     *
     * @access Public Instance
     *
     * @return Void
     */
    public function __construct( Array $columns = [] )
    {
        // Check if connection name is default database connection.
        if( $this->connection === Null )
        {
            $this->connection = Database::config( "default.connection" );
        };
        
        // Create new database connection.
        $this->database = Database::connect( $this->connection );
    }
    
    /*
     * Destroy the database connection.
     *
     * @access Public
     *
     * @return Void
     */
    public function __destruct()
    {
        $this->database = Null;
    }
    
    /*
     * @inherit Yume\Fure\Database\DatabaseModelInterface
     *
     */
    public function getConnection(): String
    {
        return( $this->connection );
    }
    
    /*
     * @inherit Yume\Fure\Database\DatabaseModelInterface
     *
     */
    public function getDatabase(): DatabaseDriverInterface
    {
        return( $this->database );
    }
    
    /*
     * @inherit Yume\Fure\Database\DatabaseModelInterface
     *
     */
    public function getIncrement(): Bool
    {
        return( $this->increment );
    }
    
    /*
     * @inherit Yume\Fure\Database\DatabaseModelInterface
     *
     */
    public function getIncrementMax(): Int
    {
        return( $this->incrementMax );
    }
    
    /*
     * @inherit Yume\Fure\Database\DatabaseModelInterface
     *
     */
    public function getIncrementValue(): ? String
    {
        return( $this->incrementValue );
    }
    
    /*
     * @inherit Yume\Fure\Database\DatabaseModelInterface
     *
     */
    public function getPrimaryKey(): ? String
    {
        return( $this->primaryKey );
    }
    
    /*
     * @inherit Yume\Fure\Database\DatabaseModelInterface
     *
     */
    public function getTable(): String
    {
        return( $this->table );
    }
    
    /*
     * @inherit Yume\Fure\Database\DatabaseModelInterface
     *
     */
    public function getTableColumnPrefix(): ? String
    {
        return( $this->tableColumnPrefix );
    }
    
    /*
     * @inherit Yume\Fure\Database\DatabaseModelInterface
     *
     */
    public function getTableColumnUnprefix(): Array
    {
        return( $this->tableColumnUnprefix );
    }
    
    /*
     * @inherit Yume\Fure\Database\DatabaseModelInterface
     *
     */
    public function getCreated(): Bool
    {
        return( $this->created );
    }
    
    /*
     * @inherit Yume\Fure\Database\DatabaseModelInterface
     *
     */
    public function getUpdated(): Bool
    {
        return( $this->updated );
    }
    
}

?>