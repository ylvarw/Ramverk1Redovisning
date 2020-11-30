<?php
/**
 * Load the ip json controller.
 */
return [
    "routes" => [
        [
            "info" => "Validate ip with Json Controller.",
            "mount" => "ip/jsonlocation",
            "handler" => "\Ylvan\Controller\GeoTagJsonController",
        ],
    ]
];
