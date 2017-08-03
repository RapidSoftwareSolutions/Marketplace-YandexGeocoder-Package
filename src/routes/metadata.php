<?php

$app->get('/api/YandexGeocoder', function ($request, $response, $args) {

       echo 1;
exit();
    $newStream = new \GuzzleHttp\Psr7\LazyOpenStream(__DIR__ . '/../../src/metadata/metadata.json', 'r');
    $newResponse = $response->withHeader('Content-type', 'application/json')->withStatus(200)->withBody($newStream);
    return $newResponse;
});
