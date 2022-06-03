<?php

namespace Yume\Kama\Obi\HTTP\Route;

use Yume\Kama\Obi\Service;

final class RouteService implements Service\ServiceInterface
{
    
    protected $pattern = [
        
        // User id pattern.
        'id' => "[0-9]+",
        
        // User name pattern.
        'user' => "[a-zA-Z_][a-zA-Z0-9_\.]{1,18}[a-zA-Z0-9_]"
        
    ];
    
    /*
     * @inheritdoc Yume\Kama\Obi\Service\ServiceInterface
     *
     */
    public function bootstrap(): Void
    {
        foreach( $this->pattern As $where => $pattern )
        {
            RoutePattern::add( $where, $pattern );
        }
    }
    
}

?>