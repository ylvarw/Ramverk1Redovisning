<?php
/**
 * Configuration file for DI container.
 */
return [
    // Services to add to the container.
    "services" => [
        "ipPosition" => [
            "shared" => true,
            "active" => false,
            "callback" => function () {
                $ipPosition = new \Ylvan\Models\IpPosition();

                return $ipPosition;
            }
        ],
    ],
];
