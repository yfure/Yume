<?php

namespace Yume\Kama\Obi\Database;

use Yume\Kama\Obi\AoE;

use PDO;
use PDOStatement;

/*
 * Statement utility class.
 *
 * @package Yume\Kama\Obi\Database
 */
class Statement extends PDOStatement
{
    
    /*
     * ...
     *
     * @access Public
     *
     * @return Array
     */
    final public function fetchAssoc(): Array
    {
        return( $this->fetchAll( PDO::FETCH_ASSOC ) );
    }
    
}

?>