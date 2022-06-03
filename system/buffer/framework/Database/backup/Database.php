<?php

namespace Yume\Kama\Obi\Database;

use PDO;
use Closure;
use Memcache;

use Yume\Kama\Obi\HTTP;
use Yume\Kama\Obi\Reflection;

class Database
{
    
    const OPR_OR = " OR ";
    const OPR_AND = " AND ";
    const OPR_COMMA = ", ";
    
    private $type;
    
    /*
     * Action query or select query.
     *
     * @values String
     */
    private $query;
    private $params;
    
    /*
     * Allow to cache result.
     *
     * @values Bool
     */
    private $cache = False;
    
    /*
     * Default time to cache.
     *
     * @values Int
     */
    private $caching = 600;
    private $memcache;
    
    /*
     * Database Connection Driver.
     *
     * @values \Yume\Kama\Obi\Database\Driver
     */
    private $driver;
    private $statement;
    
    /*
     * Database Connection Configs.
     *
     * @values Array.
     */
    private $configs;
    
    /*
     * Database Connection Name.
     *
     * @values String.
     */
    private $connection;
    
    use \Yume\Kama\Obi\Database\Traits\Config;
    
    public function __construct( ?String $connection = Null, Bool $cache = False )
    {
        if( $connection === Null ) {
            $connection = self::default();
        }
        
        // Create new database connection.
        $this->driver = Connection::create( $this->connection = $connection, $configs = self::connection( $connection ) );
        
        // Set connection configuration.
        $this->configs = $configs;
        
        // Cache permissions.
        $this->cache = $cache;
    }
    
    public function query( String $type, String $query, Bool $first = False ): Static
    {
        // ....
        $this->type = $type;
        
        if( $first ) {
            $this->query = $query;
        } else {
            $this->query .= $query;
        }
        return $this;
    }
    
    public function lineup( Array $params, String $opr = self::OPR_AND ): String
    {
        // ....
        $column = implode( $opr, array_keys( $params ) );
        
        // ....
        return( HTTP\Filter\RegExp::replace( "/:([a-z0-9_]+)/", $column, fn( $m ) => "{$m[1]}={$m[0]}" ) );
    }
    
    public function params( Array $params ): Static
    {
        $this->params = $params;
        
        return $this;
    }
    
    /*
     * Filter records.
     *
     * @params Array <params>
     * @params String <opr>
     *
     * @return Static
     */
    public function where( Array $params, String $opr = self::OPR_AND ): Static
    {
        return( $this->query( $this->type, "WHERE {$this->lineup( $params, $opr )} " )->params( $params ) );
    }
    
    /*
     * Sort the fetched data in either ascending
     * Or descending according to one or more columns.
     *
     * @params String <col>
     *
     * @return Static
     */
    public function order( String $col )
    {
        return( $this->query( 'order', "ORDER BY {$col} " ) );
    }
    
    /*
     * Restricts how many rows are returned from a query.
     *
     * @params Int <num>
     *
     * @return Static
     */
    public function limit( Int $num ): Static
    {
        return( $this->query( 'limit', "LIMIT {$num} " ) );
    }
    
    /*
     * Get or Create new statement for execution.
     *
     * @params Bool <new>
     *
     * @return \Yume\Kama\Obi\Database\Statement
     */
    final public function stmt( Bool $new = False ): Statement
    {
        if( $new ) {
            
            // Prepares a statement for execution.
            $this->statement = $this->driver->prepare( $this->query );
        }
        return( $this->statement );
    }
    
    final public function exec()
    {
        return( $this->stmt( True ) )->execute( $this->params );
    }
    
    /*
     * Fetches the next row from a result set.
     *
     * @params Callable <handle>
     * @params Callable <error>
     *
     * @return Bool, \Yume\Kama\Obi\Database\Result
     */
    final public function fetch( Callable $handle = Null, Callable $error = Null ): Bool | Result
    {
        // If Executes a prepared statement is success.
        if( $this->exec() )
        {
            // Set the default fetch mode for this statement.
            $this->stmt()->setFetchMode( PDO::FETCH_CLASS, Result::class );
            
            // If the row value is more than zero.
            if( $this->stmt()->numRows() !== 0 )
            {
                // If handle callback is not empty.
                if( $handle !== Null )
                {
                    while( $row = $this->stmt()->fetch() )
                    {
                        // ...
                        Reflection\ReflectionProperty::setValue( "stmt", $this->stmt(), $row );
                        
                        // Invoke handle closure function.
                        Reflection\ReflectionFunction::invoke( $handle, [ $row ] );
                    }
                    return True;
                }
                
                // Return result value from fetch as Iterator.
                return( $this->stmt()->fetchResult() );
            }
        }
        
        // If error callback is not empty.
        if( $error !== Null )
        {
            // Invoke error closure function.
            Reflection\ReflectionFunction::invoke( $error, [ $this->stmt ] );
        }
        return False;
    }
    
}

?>