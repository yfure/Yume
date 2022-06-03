<?php

namespace Yume\Kama\Obi\Database\Driver\PDO;

use Yume\Kama\Obi\AoE;

use PDO;
use PDOStatement As Statement;

/*
 * Database Driver Statement utility class.
 *
 * @package Yume\Kama\Obi\Database\Driver
 */
final class PDOStatement extends Statement
{
    
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
     * @return Yume\Kama\Obi\AoE\Data
     */
    public function fetchResult()
    {
        return( new AoE\Data( $this->fetchAssoc() ) );
        
    }
    
}

?>