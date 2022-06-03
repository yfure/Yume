<?php

namespace Yume\Kama\Obi\Database\Traits;

use Yume\Kama\Obi\Database;
use Yume\Kama\Obi\HTTP;

trait Table
{
    
    /*
     * The table associated with the model.
     *
     * @values String
     */
    protected $table;
    
    /*
     * Primary table key column name.
     *
     * @values String
     */
    protected $primary;
    
    /*
     * Data type for auto increment value.
     *
     * @values String
     */
    protected $uniqid;
    
    /*
     * To indicate if the model ID is auto increment.
     *
     * @values Bool
     */
    protected $increment;
    
    /*
     * Use a model-driven database connection.
     *
     * @values String
     */
    protected $connection;
    
    /*
     * Default value for empty or unfilled fields.
     *
     * @values Array
     */
    protected $columns;
    
    /*
     * Insertsis new records in a table.
     *
     * @params Array <params>
     *
     * @return \Yume\Kama\Obi\Database\Database
     */
    public function insert( Array $params )//: Database\Database
    {
        // Get all keys in array.
        $keys = array_keys( $params );
        
        // Remove the (:) symbol in the array key.
        $column = HTTP\Filter\RegExp::replace( "/:/", $keys, fn( $m ) => "" );
        
        return( $this->database->query( 'insert', "INSERT INTO {$this->table}( " . implode( ", ", $column ) . " ) VALUES( " . implode( ", ", $keys ) . " )", True ) )->params( $params );
    }
    
    /*
     * Select data from a database.
     *
     * @params Array, String <column>
     *
     * @return \Yume\Kama\Obi\Database\Database
     */
    public function select( Array | String $column ): Database\Database
    {
        // If more than one column is selected.
        if( is_array( $column ) ) {
            
            // Implode column.
            $column = $this->database->lineup( $column, $this->database::OPR_COMMA );
        }
        return( $this->database->query( 'select', "SELECT {$column} FROM {$this->table} ", True ) );
    }
    
    /*
     * Modify the existing records in a table.
     *
     * @params Array <params>
     *
     * @return \Yume\Kama\Obi\Database\Database
     */
    public function update( Array $params ): Database\Database
    {
        // New sql syntax set.
        $this->database->query( 'update', "UPDATE {$this->table} SET {$this->database->lineup( $params['set'], $this->database::OPR_COMMA )} ", True );
        
        // If where is set.
        if( isset( $params['where'] ) ) {
            
            // Add <where> syntax column value.
            $this->database->where( $params['where'] );
            
            // Merge set and where arrays.
            $params = array_merge( $params['set'], $params['where'] );
        } else {
            
            // Default value.
            $params = $params['set'];
        }
        return( $this->database->params( $params ) );
    }
    
    /*
     * Delete existing records in a table.
     *
     * @params Array <params>
     *
     * @return \Yume\Kama\Obi\Database\Database
     */
    public function delete( Array $params ): Database\Database
    {
        return( $this->database->query( 'delete', "DELETE FROM {$this->table} ", True ) )->where( $params );
    }
    
}

?>