<?php

namespace Yume\Fure\IO\File;

use Yume\Fure\AoE;
use Yume\Fure\IO;

use DateTime;

/*
 * File
 *
 * @package Yume\Fure\IO\File
 */
class File implements FileInterface
{
    
    /*
     * File name
     *
     * @access Public /* /* Readonly */ */
     *
     * @values String
     */
    public /* /* Readonly */ */ String $fname;
    
    /*
     * File extension type.
     *
     * @access Public /* /* Readonly */ */
     *
     * @values String
     */
    public /* /* Readonly */ */ String $ftype;
    
}

?>