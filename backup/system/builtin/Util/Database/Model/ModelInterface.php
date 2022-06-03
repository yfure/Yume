<?php

namespace Yume\Kama\Obi\Database\Model;

/*
 * ModelInterface interface for model utility.
 *
 * @package Yume\Kama\Obi\Database\Model
 */
interface ModelInterface
{
    
    /*
     * Delete existing records in a table.
     *
     * @access Public
     *
     * @return Bool
     */
    public function delete( Array $params ): Bool;
    
    /*
     * Insert new records in a table.
     *
     * @access Public
     *
     * @return Bool
     */
    public function insert( Array $params ): Bool;
    
    /*
     * Select data from a database.
     *
     * @access Public
     *
     * @return Bool
     */
    public function select( Array $params ): Bool;
    
    /*
     * Modify the existing records in a table.
     *
     * @access Public
     *
     * @return Bool
     */
    public function update( Array $params ): Bool;
    
}


?>