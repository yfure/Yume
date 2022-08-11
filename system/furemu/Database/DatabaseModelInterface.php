<?php

namespace Yume\Fure\Database;

/*
 * DatabaseModelInterface
 *
 * @package Yume\Fure\Database
 */
interface DatabaseModelInterface
{
    
    /*
     * Get database connection name.
     *
     * @access Public
     *
     * @return String
     */
    public function getConnection(): String;
    
    /*
     * Get database driver instance.
     *
     * @access Public
     *
     * @return Yume\Fure\Database\DatabaseDriverInterface
     */
    public function getDatabase(): DatabaseDriverInterface;
    
    /*
     * Get table incementation.
     *
     * @access Public
     *
     * @return Bool
     */
    public function getIncrement(): Bool;
    
    /*
     * Get table max incementation.
     *
     * @access Public
     *
     * @return Int
     */
    public function getIncrementMax(): Int;
    
    /*
     * Get table increment type.
     *
     * @access Public
     *
     * @return String
     */
    public function getIncrementValue(): ? String;
    
    /*
     * Get table primary key.
     *
     * @access Public
     *
     * @return String
     */
    public function getPrimaryKey(): ? String;
    
    /*
     * Get table name.
     *
     * @access Public
     *
     * @return String
     */
    public function getTable(): String;
    
    /*
     * Get table column prefix name.
     *
     * @access Public
     *
     * @return String
     */
    public function getTableColumnPrefix(): ? String;
    
    /*
     * Get unprefix colum name.
     *
     * @access Public
     *
     * @return Array
     */
    public function getTableColumnUnprefix(): Array;
    
    /*
     * Get allow autofil timestamp permission [CREATE]
     *
     * @access Public
     *
     * @return 
     */
    public function getCreated(): Bool;
    
    /*
     * Get allow autofil timestamp permission [UPDATE]
     *
     * @access Public
     *
     * @return 
     */
    public function getUpdated(): Bool;
    
}

?>