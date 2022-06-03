<?php

return([
    
    'environment' => [
        'path' => "kankyou"
    ],
    
    'reflection' => [
        'function' => [
            'template' => []
        ],
        'instance' => [
            '@method' => [
                'allow' => True,
                'template' => []
            ],
            '@constant' => [
                'allow' => True,
                'template' => []
            ],
            '@property' => [
                'allow' => True,
                'template' => []
            ],
            'template' => []
        ],
        'interface' => [
            'template' => []
        ],
        'parameter' => [
            'template' => []
        ]
    ],
    
    'timezone' => "Asia/Tokyo",
    
    'trouble' => [
        'memew' => [
            'scheme' => [
                "@Object" => [
                    "@Code",
                    "@Type",
                    "@Alias",
                    "@Class",
                    "@Trait",
                    "@Parent",
                    "@Interface",
                    "@Previous"
                ],
                "@File" => [
                    "@Line",
                    "@File"
                ],
                "@Message",
                "@Trace"
            ]
        ]
    ]
    
]);

?>