<?php

namespace Yume\Fure\Translator;

use Yume\Fure\AoE;
use Yume\Fure\Services;
use Yume\Fure\Threader;

/*
 * TranslatorServices
 *
 * @extends Yume\Fure\Services\Services
 *
 * @package Yume\Fure\Translator
 *
 */
final class TranslatorServices extends Services\Services
{
    
    /*
     * @inherit Yume\Fure\Services\ServicesInterface
     *
     */
    public static function boot(): Void
    {
        Translator::import( Threader\App::config( "localization.language" ) );
    }
    
}

?>