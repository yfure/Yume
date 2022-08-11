<?php

return([
    
    /*
     * Allow replace value on super global variable $_ENV.
     *
     * @values Bool
     */
    "replace" => False,
    
    /*
     * Give prefix name for super global constant name.
     *
     * @values False|String
     */
    "prefix" => "ENV",
    
    /*
     * Skip create super global constant if constant is exists.
     *
     * @values Bool
     */
    "skiped" => True,
    
    /*
     * The location where the environment files are stored.
     *
     * You can rename files and move environment
     * files where no one can reach them.
     *
     * @path Default BASE_PATH
     */
    "path" => "kankyou"
    
]);

?>