<?php

namespace Yume\Kama\Obi\Database\Driver;

use PDO;

/*
 * Database Driver PHPDataObjectSQLite utility class.
 *
 * @package Yume\Kama\Obi\Database\Driver
 */
class PHPDataObjectSQLite extends PHPDataObject
{
    
    /*
     * @inheritdoc Yume\Kama\Obi\Database\Driver\PHPDataObject
     *
     */
    public function __construct( AoE\Data $config )
    {
        parent::__construct( "sqlite", $config );
    }
    
}

?>