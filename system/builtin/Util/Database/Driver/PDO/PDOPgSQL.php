<?php

namespace Yume\Kama\Obi\Database\Driver;

use PDO;

/*
 * Database Driver PHPDataObjectPgSQL utility class.
 *
 * @package Yume\Kama\Obi\Database\Driver
 */
class PDOPgSQL extends PDOProvider
{
    
    /*
     * @inheritdoc Yume\Kama\Obi\Database\Driver\PHPDataObject
     *
     */
    public function __construct( AoE\Data $config )
    {
        parent::__construct( "pgsql", $config );
    }
    
}

?>