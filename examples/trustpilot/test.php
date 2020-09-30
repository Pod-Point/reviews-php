<?php

require __DIR__ . '/../../vendor/autoload.php';


try {
    $manager = new \PodPoint\Reviews\Manager();
    $reviewService = $manager->withProvider('trustpilot');

    $reviewService->product();

    $reviewService->service();

    $invite = $reviewService->service()->invite($options);


} catch (Exception $exception) {
    var_dump($exception);
}

