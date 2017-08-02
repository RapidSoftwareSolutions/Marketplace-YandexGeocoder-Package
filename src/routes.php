<?php
$routes = [
    'getAddressByCord',
    'getCordByAddress',
    'metadata'
];
foreach($routes as $file) {
    require __DIR__ . '/../src/routes/'.$file.'.php';
}
