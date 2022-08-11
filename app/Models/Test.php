<?php

namespace Yume\App\Models;

use Yume\Fure\Database;

/*
 * Test Model
 *
 * @extends Yume\Fure\Database\Model\PDOMySQLModel
 *
 * @package Yume\App\Models
 */
final class Test extends Database\Driver\PDO\PDOMySQLModel
{
    
    /*
     * @inherit Yume\Fure\Database\DatabaseModel
     *
     */
    protected $connection = "yume";
    
    /*
     * @inherit Yume\Fure\Database\DatabaseModel
     *
     */
    protected $table = "test";
    
}

?>