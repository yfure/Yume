<?php

namespace Yume\Kama\App\HTTP\Controllers;

use Yume\Kama\Obi\HTTP;

/*
 * User Controller
 *
 * @package Yume\Kama\App\HTTP\Controllers
 */
class User extends HTTP\Controller\Controller
{
    /*
     * Main method of controller.
     *
     * @access Public
     *
     * @params String $user
     * @params String $tabs
     *
     * @return Void
     */
    public function main( String $user, String $tabs ): Void
    {
        $this->view( "user", [
            "user" => $user,
            "tabs" => $tabs,
            "data" => []
        ]);
    }
}

?>