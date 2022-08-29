<?php

namespace Yume\Fure\View;

use Yume\Fure\Error;
use Yume\Fure\Reflector;
use Yume\Fure\Services;
use Yume\Fure\Threader;

/*
 * ViewServices
 *
 * @extends Yume\Fure\Services\Services
 *
 * @package Yume\Fure\View
 */
final class ViewServices extends Services\Services
{
    
    /*
     * @inherit Yume\Fure\Services\Services
     *
     */
    public static function boot(): Void
    {
        // View configuration set.
        Reflector\ReflectProperty::setValue( View::class, "configs", Threader\App::config( "view" ) );
        return;
        // Mapping parser classes.
        array_map( array: View::config( "parsers" ), callback: function( String $token )
        {
            // If tokenization class does not implement Interface Tokenizer.
            if( Reflector\ReflectClass::isImplements( $token, Tokenizer\TokenizerInterface::class ) === False )
            {
                throw new Error\ImplementError([ $token, Tokenizer\TokenizerInterface::class ]);
            }
        });
    }
    
}

?>