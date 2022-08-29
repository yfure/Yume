<?php

namespace Yume\Fure\Database\Driver\PDO;

use Yume\Fure\Database;

/*
 * PDOModel
 *
 * @extends Yume\Fure\Database\DatabaseModel
 *
 * @package Yume\Fure\Database\Driver\PDO
 */
abstract class PDOModel extends Database\DatabaseModel
{
    
    protected PDOQuery $query;
    
    /*
     * @inherit Yume\Fure\Database\DatabaseModelInterface
     *
     */
    public function __construct( Array $columns = [] )
    {
        // Call parent constructor.
        parent::__construct( $columns );
    }
    
    /*
     * Delete column data.
     *
     * @access Public
     *
     * @return Static
     */
    public function delete(): Static
    {
        return( $this );
    }
    
    /*
     * Insert column data.
     *
     * @access Public
     *
     * @return Static
     */
    public function insert(): Static
    {
        return( $this );
    }
    
    /*
     * Select column data.
     *
     * @access Public
     *
     * @return Static
     */
    public function select(): Static
    {
        return( $this );
    }
    
    /*
     * Update column data.
     *
     * @access Public
     *
     * @return Static
     */
    public function update(): Static
    {
        return( $this );
    }
    
}

?>