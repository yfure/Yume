<?php

namespace Yume\Fure\Database\Driver\PDO;

use Yume\Fure\AoE;

use PDO;
use PDOStatement as PDOState;

/*
 * PDOStatement
 *
 * @extends PDOStatement
 *
 * @package Yume\Fure\Database\Driver\PDO
 */
final class PDOStatement extends PDOStats
{
    
    /*
     * Shortname for rowCount method.
     *
     * @access Public
     *
     * @return Int
     */
    public function count(): Int
    {
        return( $this->rowCount() );
    }
    
    /*
     * PDO Fetch Assoc.
     *
     * @access Public
     *
     * @return Array
     */
    public function fetchAssoc()
    {
        return( $this->fetchAll( PDO::FETCH_ASSOC ) );
    }
    
    /*
     * PDO Fetch Assoc.
     *
     * @access Public
     *
     * @return Yume\Fure\AoE\Data
     */
    public function fetchResult()
    {
        return( new AoE\Data( $this->fetchAssoc() ) );
        
    }
    
}

?>