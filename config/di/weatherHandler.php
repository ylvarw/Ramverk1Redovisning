<?php
/**
 * Configuration file for DI container.
 */
return [
    // Services to add to the container.
    "services" => [
        "weatherHandler" => [
            "shared" => true,
            "active" => false,
            "callback" => function () {
                $weatherHandler = new \Ylvan\Models\WeatherHandler();

                return $weatherHandler;
            }
        ],
    ],
];
