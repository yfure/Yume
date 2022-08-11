<?php

/*
 * View configurations.
 *
 * @author hxAri
 */
return([
    
    "save" => [
        "path" => "assets/views/{0}.view"
    ],
    
    "cache" => [
        "loaded" => "assets/caches/views/{0}/__view.{0}.loaded",
        "parsed" => "assets/caches/views/{0}/__view.{0}.parsed"
    ],
    
    "parsers" => [
        Yume\Fure\View\Syntax\SyntaxOutput::class
    ],
    "comment" => [
        "remove" => False
    ]
    
]);

?>