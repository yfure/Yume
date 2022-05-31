<?php

namespace Yume\Util\Database\Driver;

use PDO;

/*
 * Database Driver PHPDataObjectPgSQL utility class.
 *
 * @package Yume\Util\Database\Driver
 */
class PDOPgSQL extends PHPDataObject
{
    
    /*
     * @inheritdoc Yume\Util\Database\Driver\PHPDataObject
     *
     */
    public function __construct( Himei\Data $config )
    {
        parent::__construct( "pgsql", $config );
    }
    
}

?>
