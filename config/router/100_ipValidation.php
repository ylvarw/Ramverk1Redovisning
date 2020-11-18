<?php
/**
 * Load the Ylvan/controller
 */

// return [
//     // Path where to mount the routes, is added to each route path.
//     "mount" => "ip",

//     // All routes in order
//     "routes" => [
//         [
//             "info" => "Just say hi with a string.",
//             "method" => null,
//             "path" => "validate",
//             "handler" => "\Anax\Controller\ValidateIpController",
//         ],
//     ]
// ];


return [

    // All routes in order
    "routes" => [
        [
            "info" => "A Controller to validate ip.",
            "mount" => "ip/validate",
            "handler" => "\Anax\Controller\ValidateIpController",
            // "handler" => "\Ylvan\Ip\ValidateIpController",
        ],
    ]
];