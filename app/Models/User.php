<?php

namespace App\Models;

use Yume\Kama\Obi\Database;

/*
 * User Model class.
 *
 * @package App\Models
 */
final class User extends Database\Driver\PDO\PDOModel
{
    
    /*
     * Used when username or email address is available.
     *
     * @access Public
     *
     * @values Int
     */
    public const E_USERMAIL_EXISTS = 682952;
    public const E_USERNAME_EXISTS = 682954;
    
    /*
     * @inheritdoc Database\Driver\PDO\PDOModel
     *
     */
    protected $connection = "octancle";
    
    /*
     * @inheritdoc Database\Driver\PDO\PDOModel
     *
     */
    protected $increment = True;
    
    /*
     * @inheritdoc Database\Driver\PDO\PDOModel
     *
     */
    protected $incrementMax = 10;
    
    /*
     * @inheritdoc Database\Driver\PDO\PDOModel
     *
     */
    protected $incrementValue = "Number";
    
    /*
     * @inheritdoc Database\Driver\PDO\PDOModel
     *
     */
    protected $primaryKey = "id";
    
    /*
     * @inheritdoc Database\Driver\PDO\PDOModel
     *
     */
    protected $table = "_0xusers";
    
    /*
     * @inheritdoc Database\Driver\PDO\PDOModel
     *
     */
    protected $tableColumnPrefix = "_";
    
    /*
     * @inheritdoc Database\Driver\PDO\PDOModel
     *
     */
    protected $tableColumnUnprefix = [
        "id",
        "node",
        "created",
        "updated",
        "access_token",
        "remind_token"
    ];
    
    /*
     * @inheritdoc Database\Driver\PDO\PDOModel
     *
     */
    protected $created = True;
    
    /*
     * @inheritdoc Database\Driver\PDO\PDOModel
     *
     */
    protected $updated = True;
    
}

?>