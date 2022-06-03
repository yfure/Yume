<?php

/*
 * Bootrapping file for Yume Framework.
 *
 * Takes various functions as well as built-in classes from yume.
 * It will also check if the user is using php version ^8.0.
 *
 * @author hxAri
 * @license Under MIT
 */
try {
    if( PHP_VERSION < $v = "8.0.6" )
    {
        throw new RuntimeException( "Oops sorry it looks like you are using a PHP version\nbelow {$v} please upgrade the PHP version to {$v} or higher." );
    }
} catch( RuntimeException $e ) {
    echo $e::class . ": {$e->getMessage()}\n{$e->getFile()} on line {$e->getLine()}";
}

/*
 * Register Auto Load.
 *
 * Automatic loading of files required for a project or application.
 * This includes the files required for the application without explicitly
 * including them with the [include] or [require] functions.
 */
require "$root/vendor/autoload.php";

/*
 * Define super global constants based element name.
 *
 * You can also implement your constant names and values easily.
 * See ./const file for define new constant.
 */
foreach( $constant As $group => $array )
{
    foreach( $array As $const => $value )
    {
        define( ( $group === "SERVER" ? "SERVER_" : "" ) . $const, is_callable( $value ) ? call_user_func( $value ) : $value );
    }
}

?>