<?php

namespace Yume\Fure\Database;

/*
 * DatabaseDriverTrait
 *
 * @package Yume\Fure\Database
 */
trait DatabaseDriverTrait
{
    
    /*
     * @inherit Yume\Fure\Database\DatabaseDriverInterface
     *
     */
    public function getConnection(): String
    {
        return( $this->connection );
    }
    
    /*
     * @inherit Yume\Fure\Database\DatabaseDriverInterface
     *
     */
    public function getServer(): String
    {
        return( $this->configs )->server ;
    }
    
}

?>