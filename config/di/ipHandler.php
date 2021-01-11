<?php
/**
 * Configuration file for DI container.
 */
return [
    // Services to add to the container.
    "services" => [
        "ipHandler" => [
            "shared" => true,
            "active" => false,
            "callback" => function () {
                $ipHandler = new \Ylvan\Models\IpHandler();

                return $ipHandler;
            }
        ],
    ],
];
