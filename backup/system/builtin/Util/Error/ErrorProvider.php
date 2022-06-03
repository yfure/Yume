<?php

namespace Yume\Kama\Obi\Error;

use function Yume\Func\path;

use Yume\Kama\Obi\Storage\IO;
use Yume\Kama\Obi\AoE;

abstract class ErrorProvider
{
    
    /*
     * @inheritdoc ErrorInterface
     *
     */
    public static function write( String $dir, Array $error ): Void
    {
        /** If the error store has not been created. **/
        if( file_exists( path( noteware: $dir ) ) === False )
        {
            /** Creating an error log directory. **/
            mkdir( path( noteware: $dir ) );
        }
        
        
        /** New Fairu Instance. *
        $fairu = new IO\Fairu( NOTEWARE_PATH . $dir . AoE\App::$object->dateTime->format( "d.M-Y.\l\o\g" ) );
        
        /** Write new line. *
        $fairu->writer( ( new AoE\Tree( $error ) )->getResult() . "\n" );*/
    }
    
}

?>