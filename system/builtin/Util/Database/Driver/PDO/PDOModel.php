<?php

namespace Yume\Kama\Obi\Database\Driver\PDO;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\Database;
use Yume\Kama\Obi\Trouble;

/*
 * PDO Driver Model utility class.
 *
 * @package Yume\Kama\Obi\Database\Driver\PDO
 */
class PDOModel extends Database\Model\ModelProvider implements Database\Model\ModelInterface
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
    protected $incrementMax = 20;
    
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
     * Column names without prefix
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
    protected $created;
    protected $updated;
    
    /*
     * PDO Model Driver Constructor.
     *
     * @access Public
     *
     * @return Static
     */
    public function __construct()
    {
        $this->database = Database\Database::connect( $this->connection );
    }
    
    public function delete()
    {
    }
    
    /*
     * Add|Create a new record to the table.
     *
     * @access Public
     *
     * @params Array <column>
     *
     * @return Bool
     */
    public function insert( Array $column ): Bool
    {
        if( isset( $column[$this->primaryKey] ) === False )
        {
            if( $this->increment )
            {
                if( $this->incrementMax === 0 )
                {
                    throw new Trouble\Exception\DatabaseModelError( "" );
                }
                $column = AoE\Arrayable::insert([ 0, $this->primaryKey ], $column, match( $this->incrementValue )
                {
                    
                    // Generate random long numbers.
                    "Number" => AoE\Numberable::length( $this->incrementMax ),
                    
                    // Generate random long string.
                    "String" => AoE\Stringable::random( $this->incrementMax ),
                    
                    // UnexpectedValueIncrementType
                    default => throw new Trouble\Exception\DatabaseModelError( "Invalid Increment type {$this->incrementValue}" )
                    
                });
            }
        }
        if( isset( $column['created'] ) === False && $this->created )
        {
            $column['created'] = AoE\App::$object->dateTime->getTimestamp();
        }
        return( $this->database->insert( $this->table, $this->prefix( $column ) ) )->execute();
    }
    
    public function select( Array | String $column, Array | Bool $where = False )
    {
    }
    
    public function update( Array $column, Array | Bool $where = False ): Bool
    {
        if( isset( $column['updated'] ) === False && $this->updated )
        {
            $column['updated'] = AoE\App::$object->dateTime->getTimestamp();
        }
        if( $where !== False )
        {
            return( $this->database->update( $this->table, $this->prefix( $column ) ) )->where( $this->prefix( $where ) )->execute();
        }
        return( $this->database->update( $this->table, $this->prefix( $column ) ) )->execute();
    }
    
    /*
     * Returns whether the record is available.
     *
     * @access Public
     *
     * @params Array <column>
     *
     * @return Bool
     */
    public function exists( Array $column )
    {
        $this
            
            // PDO|Database Instance class.
            ->database
            
            // Select column user.
            ->select( $this->table, $this->prefix( $this->primaryKey ) )
            
            // Search users by column name.
            ->where( $this->prefix( $column ) )
            
            // Pick up limit.
            ->limit( 10 )
            
            // Execute.
            ->execute();
        
        return( $this->database->stmt()->count() > 0 );
    }
    
    /*
     * Adding prefix for each column name.
     *
     * @access Protected
     *
     * @params Array, String <column>
     *
     * @return Array, String
     */
    protected function prefix( Array | String $column ): Array | String
    {
        if( is_array( $column ) )
        {
            foreach( $column As $key => $val )
            {
                unset( $column[$key] );
                
                if( is_string( $key ) )
                {
                    $key = $this->prefix( $key );
                } else {
                    $val = $this->prefix( $val );
                }
                $column[$key] = $val;
            }
        } else {
            if( in_array( $column, $this->tableColumnUnprefix ) === False )
            {
                $column = $this->tableColumnPrefix . $column;
            }
        }
        return( $column );
    }
    
}

?>