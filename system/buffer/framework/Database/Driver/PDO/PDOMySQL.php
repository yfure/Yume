<?php

namespace Yume\Kama\Obi\Database\Driver\PDO;

use Yume\Kama\Obi\AoE;

/*
 * Database Driver PDOMySQL utility class.
 *
 * @package Yume\Kama\Obi\Database\Driver\PDO
 */
class PDOMySQL extends PDOProvider
{
    
    /*
     * @inheritdoc Yume\Kama\Obi\Database\Driver\PDO\PDOProvider
     *
     */
    protected $server = "MySQL";
    
    /*
     * @inheritdoc Yume\Kama\Obi\Database\Driver\PDO\PDOProvider
     *
     */
    public function __construct( String $name, Array $config )
    {
        parent::__construct( $name, $config );
    }
    
    /*
     * @inheritdoc Yume\Kama\Obi\Database\Driver\PDO\PDOProvider
     *
     */
    public function delete( String $table )
    {
        // ...
    }
    
    /*
     * @inheritdoc Yume\Kama\Obi\Database\Driver\PDO\PDOProvider
     *
     */
    public function insert( String $table, Array $column )
    {
        // Reset query syntax.
        $this->query = "INSERT INTO $table ";
        $this->params = [];
        
        // Add a column to be filled.
        $this->query .= "( " . implode( ", ", array_keys( $column ) ) . " )";
        
        foreach( $column As $key => $val )
        {
            // Add a colon in front of the column name.
            $key = ":$key";
            
            $keys[] = $key;
            
            // Add parameters.
            $this->params[$key] = $val;
        }
        
        // Added VALUES syntax syntax.
        $this->query .= "\nVALUES( " . implode( ", ", $keys ) . " )";
        
        return( $this );
    }
    
    /*
     * @inheritdoc Yume\Kama\Obi\Database\Driver\PDO\PDOProvider
     *
     */
    public function limit( Int $limit = 10 )
    {
        if( $limit !== 0 )
        {
            if( $this->query !== Null )
            {
                // Adding syntax to the query line.
                $this->query .= "\nLIMIT $limit";
            }
        }
        return( $this );
    }
    
    /*
     * @inheritdoc Yume\Kama\Obi\Database\Driver\PDO\PDOProvider
     *
     */
    public function order( String $order )
    {
        if( $order !== "" )
        {
            if( $this->query !== Null )
            {
                // Adding syntax to the query line.
                $this->query .= "\nORDER BY $order";
            }
        }
        return( $this );
    }
    
    /*
     * @inheritdoc Yume\Kama\Obi\Database\Driver\PDO\PDOProvider
     *
     */
    public function select( String $table, Array | String $column )
    {
        // Reset query syntax.
        $this->query = "SELECT ";
        $this->params = [];
        
        if( is_array( $column ) )
        {
            if( count( $column ) !== 0 )
            {
                foreach( $column As $col => $name )
                {
                    $this->params[$column[$col] = ":$name"] = $name;
                }
                $column = implode( ", ", $column );
            } else {
                throw new Trouble\Exception\DatabaseDriverError( "No selected column." );
            }
        }
        
        // Add selected column & used table.
        $this->query .= "{$column} FROM {$table} ";
        
        return( $this );
    }
    
    /*
     * @inheritdoc Yume\Kama\Obi\Database\Driver\PDO\PDOProvider
     *
     */
    public function update( String $table, Array $column )
    {
        // Reset query syntax.
        $this->query = "UPDATE $table\nSET ";
        
        if( count( $column ) !== 0 )
        {
            $keys = [];
            
            foreach( $column As $key => $val )
            {
                // Add a colon in front of the column name.
                $key = ":$key";
                
                $keys[] = $key;
                
                // Add parameters.
                $this->params[$key] = $val;
            }
            
            // Add column to query row.
            $this->query .= implode( ", ", $keys );
        } else {
            throw new Trouble\Exception\DatabaseDriverError( "The update column cannot be empty." );
        }
        return( $this );
    }
    
    /*
     * @inheritdoc Yume\Kama\Obi\Database\Driver\PDO\PDOProvider
     *
     */
    public function where( Array $column )
    {
        if( count( $column ) !== 0 )
        {
            if( $this->query !== Null )
            {
                // Added prefix syntax.
                $this->query .= "\nWHERE ";
                
                $keys = [];
                
                foreach( $column As $key => $val )
                {
                    
                    // Add a colon in front of the column name.
                    $keys[] = "$key=" . ( $key = ":$key" );
                    
                    // Add parameters.
                    $this->params[$key] = $val;
                }
                
                // Add column to query row.
                $this->query .= implode( ", ", $keys );
            }
        } else {
            throw new Trouble\Exception\DatabaseDriverError( "The where column cannot be empty." );
        }
        
        return( $this );
    }
    
    
}

?>