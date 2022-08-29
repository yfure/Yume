<?php

namespace Yume\Kama\Obi\Database\Model;

use Yume\Kama\Obi\Database;

interface ModelInterface
{
    
    public function getConnection(): String;
    
    public function getDatabase(): Database\Driver\PDO\PDOProvider;
    
    public function getIncrement(): Bool;
    
    public function getIncrementMax(): Int;
    
    public function getIncrementValue(): ? String;
    
    public function getPrimaryKey(): ? String;
    
    public function getTable(): String;
    
    public function getTableColumnPrefix(): ? String;
    
    public function getTableColumnUnprefix(): Array;
    
    public function getCreated(): Bool;
    
    public function getUpdated(): Bool;
    
}

?>