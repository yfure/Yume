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
    
    public function delete(): Static
    {
        // ...
    }
    
    public function insert(): Static
    {
        // ...
    }
    
    public function select(): Static
    {
        // ...
    }
    
    public function update(): Static
    {
        // ...
    }
    
}

?>