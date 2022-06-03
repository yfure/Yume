<?php

// Import all functions in this directory.
$scan = scandir( __DIR__ );

foreach( $scan As $file ) {
    if( preg_match( "/({$file})/", __FILE__ ) ) {
        
        // Skip require file.
        continue;
    }
    require( $file );
}

?>