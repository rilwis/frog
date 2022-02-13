<?php
require __DIR__ . '/vendor/autoload.php';

use React\Http\HttpServer;

$http = new HttpServer(function (Psr\Http\Message\ServerRequestInterface $request) {
    $body = $request->getParsedBody();
    var_dump( $_POST );
});

$socket = new React\Socket\SocketServer(HOST . ':' . PORT);
$http->listen($socket);