<?php
/**
 * Load the Ylvan/controller
 */



return [

    // All routes in order
    "routes" => [
        [
            "info" => "Find location by ip.",
            "mount" => "ip/location",
            "handler" => "\Ylvan\Controller\GeotagController",
        ],
    ]
];
