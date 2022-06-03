<?php

namespace Yume\Kama\Obi\Database\Driver;

use Yume\Kama\Obi\AoE;

/*
 * Database Driver PHPDataObjectMySQL utility class.
 *
 * @package Yume\Kama\Obi\Database\Driver
 */
class PHPDataObjectMySQL extends PHPDataObject
{
    
    /*
     * @inheritdoc Yume\Kama\Obi\Database\Driver\PHPDataObject
     *
     */
    public function __construct( AoE\Data $config )
    {
        parent::__construct( "mysql", $config );
    }
    
}

?>