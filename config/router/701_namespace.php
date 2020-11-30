<?php
/**
 * Load the Ylvan/controller
 */



return [

    // All routes in order
    "routes" => [
        [
            "info" => "A Controller to validate ip.",
            "mount" => "ip/namespace",
            "handler" => "\Ylvan\Controller\NamespaceController",
        ],
    ]
];