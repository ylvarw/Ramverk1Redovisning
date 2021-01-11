<?php
/**
 * Load the ip json controller.
 */
return [
    "routes" => [
        [
            "info" => "Validate ip with Json Controller.",
            "mount" => "ip/validateJson",
            "handler" => "\Ylvan\Controller\IpJsonController",
        ],
    ]
];
