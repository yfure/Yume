<?php

namespace Yume\Util\Database\Driver;

use PDO;

/*
 * Database Driver PHPDataObjectSQLite utility class.
 *
 * @package Yume\Util\Database\Driver
 */
class PDOSQLite extends PDOProvider
{
    
    /*
     * @inheritdoc Yume\Util\Database\Driver\PHPDataObject
     *
     */
    public function __construct( Himei\Data $config )
    {
        parent::__construct( "sqlite", $config );
    }
    
}

?>
