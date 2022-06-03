<?php

namespace Yume\Kama\Obi\Database\Model;

use Yume\Kama\Obi\Database;

abstract class ModelProvider implements ModelInterface
{
    
    public function getConnection(): String
    {
        return( $this->connection );
    }
    
    public function getDatabase(): Database\Driver\PDO\PDOProvider
    {
        return( $this->database );
    }
    
    public function getIncrement(): Bool
    {
        return( $this->increment );
    }
    
    public function getIncrementMax(): Int
    {
        return( $this->incrementMax );
    }
    
    public function getIncrementValue(): ? String
    {
        return( $this->incrementValue );
    }
    
    public function getPrimaryKey(): ? String
    {
        return( $this->primaryKey );
    }
    
    public function getTable(): String
    {
        return( $this->table );
    }
    
    public function getTableColumnPrefix(): ? String
    {
        return( $this->tableColumnPrefix );
    }
    
    public function getTableColumnUnprefix(): Array
    {
        return( $this->tableColumnUnprefix );
    }
    
    public function getCreated(): Bool
    {
        return( $this->created );
    }
    
    public function getUpdated(): Bool
    {
        return( $this->updated );
    }
    
}

?>