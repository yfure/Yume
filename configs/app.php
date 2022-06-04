<?php

return([
    
    /*
     * Environment class configuration.
     *
     */
    "environment" => [
        
        /*
         * The location where the environment files are stored.
         *
         * You can rename files and move environment
         * files where no one can reach them.
         *
         * @path Default BASE_PATH
         */
        "path" => "kankyou"
    ],
    
    /*
     * Reflection class configuration.
     *
     */
    "reflector" => [
        "function" => [
            "template" => []
        ],
        "instance" => [
            "@method" => [
                "filter" => ReflectionMethod::IS_PUBLIC,
                "scheme" => []
            ],
            "@constant" => [
                "filter" => True,
                "scheme" => []
            ],
            "@property" => [
                "filter" => True,
                "scheme" => []
            ],
            "scheme" => [
                "class" => [
                    "name",
                    "space"
                ],
                "object" => [
                    "is" => [
                        "is::Abstract",
                        "is::Anonymous",
                        "is::Cloneable",
                        "is::Countable",
                        "is::Data",
                        "is::Enum",
                        "is::Final",
                        "is::Instance",
                        "is::Instantiable",
                        "is::Interface",
                        "is::Internal",
                        "is::Iterable",
                        "is::Stringable",
                        "is::SubclassOf",
                        "is::Throwable",
                        "is::Trait",
                        "is::UserDefined"
                    ]
                ],
                "traits" => "traits",
                "methods" => "methods",
                "constants" => "constants",
                "interfaces" => "interfaces",
                "properties" => "properties"
            ]
        ],
        "interface" => [
            "scheme" => []
        ],
        "parameter" => [
            "scheme" => []
        ]
    ],
    
    /*
     * Default Time Zone for app.
     *
     */
    "timezone" => "Asia/Tokyo",
    
    /*
     * The Trouble configuration.
     *
     * It also includes the name of the function that handles the error,
     * where the error log is stored and also includes how the function
     * displays error messages based on a template or schema.
     */
    "trouble" => [
        "error" => [
            "scheme" => [
                "File" => [
                    "File",
                    "Line"
                ],
                "Error" => [
                    "Code",
                    "Level"
                ],
                "Message"
            ],
            "handler" => "Yume\Kama\Obi\Trouble\Toriga\Toriga::handler"
        ],
        "exception" => [
            "scheme" => [
                "Object" => [
                    "Code",
                    "Type",
                    "Alias",
                    "Class",
                    "Trait",
                    "Parent",
                    "Interface",
                    "Previous"
                ],
                "File" => [
                    "Line",
                    "File"
                ],
                "Message",
                "Trace"
            ],
            "handler" => "Yume\Kama\Obi\Trouble\Memew\Memew::handler"
        ]
    ]
    
]);

?>