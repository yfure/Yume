<?php

namespace Yume\App\HTTP\Controllers;

use Yume\App\Models;
use Yume\App\Views;

use Yume\Fure\AoE;
use Yume\Fure\Database;
use Yume\Fure\Environment;
use Yume\Fure\HTTP;
use Yume\Fure\IO;
use Yume\Fure\JSON;
use Yume\Fure\Logger;
use Yume\Fure\Reflector;
use Yume\Fure\RegExp;
use Yume\Fure\Seclib;
use Yume\Fure\Services;
use Yume\Fure\Threader;
use Yume\Fure\Translator;
use Yume\Fure\View;

/*
 * Test Case
 *
 * This controller only for test cases.
 *
 * @extends Yume\App\HTTP\Controllers\API
 *
 * @package Yume\App\HTTP\Controllers
 */
class Test extends Api
{
    /*
     * @inherit Yume\App\HTTP\Controllers\Api
     *
     */
    public function __construct()
    {
        //parent::__construct();
    }
    
    /*
     * Main method of controller Test.
     *
     * @access Public
     *
     * @return Void
     */
    public function main(): Void
    {
        // Create new model instance class.
        //$model = new Models\Test();
        
        $templ = new Views\Templates\Test([
            "title" => "Welcome to Yume!",
            "users" => [
                [
                    "id" => 020125,
                    "fname" => "Chintya",
                    "uname" => "chintya",
                    "email" => "chintya020125@gmail.com"
                ]
            ],
            "i" => 0
        ]);
        
        $templ->render();
    }
}

?>