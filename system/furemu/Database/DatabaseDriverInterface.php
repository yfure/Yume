<?php

namespace Yume\Fure\Database;

use Yume\Fure\AoE;

/*
 * DatabaseDriverInterface
 *
 * @package Yume\Fure\Database
 */
interface DatabaseDriverInterface extends AoE\Intafesu\Unchangeable
{
    
    /*
     * Construct method of class PDOConnection
     *
     * @access Public Instance
     *
     * @params String $connection
     * @params Yume\Fure\AoE\Data $options
     * @params Yume\Fure\AoE\Data $configs
     *
     * @return Void
     */
    public function __construct(
        
        /*
         * Database connection name.
         *
         * @access Protected
         *
         * @values String
         */
        String $connection,
        
        /*
         * Database driver options.
         *
         * @access Protected
         *
         * @values Yume\Fure\AoE\Data
         */
        AoE\Data $options,
        
        /*
         * Database connection configs.
         *
         * @access Protected
         *
         * @values Yume\Fure\AoE\Data
         */
        AoE\Data $configs
        
    );
    
    /*
     * Return database connection name.
     *
     * @access Public
     *
     * @return String
     */
    public function getConnection(): String;
    
    /*
     * Return database server name.
     *
     * @access Public
     *
     * @return String
     */
    public function getServer(): String;
    
}

?>