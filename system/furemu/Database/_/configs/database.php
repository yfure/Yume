<?php

use Yume\Kama\Obi\Himei;

return([
    
    /*
     * Configuration for the default driver.
     * By default I fill it with PDO because I think
     * PDO supports many types of Database Servers.
     *
     */
    'driver' => "PDO",
    
    'drivers' => [
        'PDO' => [
            'options' => [
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
            ],
            'attributes' => [
                
                /** Extends PDO statement class. */
                PDO::ATTR_STATEMENT_CLASS => [
                    Yume\Kama\Obi\Database\Driver\PDO\PDOStatement::class
                ],
                
                /** Disable emulated prepared statements. */
                PDO::ATTR_EMULATE_PREPARES => False,
                
                /** Set default fetch mode. */
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                
                // Include UPDATED QUERIES in to rowcount() function.
                //PDO::MYSQL_ATTR_FOUND_ROWS => true,
                
                /** Error mode is exception. */
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                
            ]
        ]
    ],
    
    'connections' => [
        'octancle' => [
            'table' => [
                'prefix' => "_0x",
                'engine' => "InnoDB",
                'collate' => "utf8mb4_unicode_ci"
            ],
            'driver' => "default",
            'database' => [
                'socket' => Null,
                'server' => "MySQL",
                'charset' => "utf8mb4",
                'private' => [
                    'hostname' => "127.0.0.1",
                    'portname' => 3306,
                    'database' => "octancle",
                    'username' => "root",
                    'password' => ""
                ]
            ]
        ],
        'mongod' => new Himei\Data,
        'oracle' => new Himei\Data,
        'pgsql' => new Himei\Data,
        'sqlite' => new Himei\Data
    ]
    
]);

?>