<?php
use React\Socket\SocketServer;
use React\Socket\ConnectionInterface;
use React\Socket\LimitingServer;

require __DIR__ . '/vendor/autoload.php';

$socket = new SocketServer(HOST . ':' . PORT);
$socket = new LimitingServer($socket, null);

$socket->on('connection', function (ConnectionInterface $connection) use ($socket) {
	echo '[' . $connection->getRemoteAddress() . ' connected]' . PHP_EOL;

	$connection->on('data', function ($data) use ($connection, $socket) {
		foreach ($socket->getConnections() as $connection) {
			$connection->write($data);
		}
	});

	$connection->on('close', function () use ($connection) {
		echo '[' . $connection->getRemoteAddress() . ' disconnected]' . PHP_EOL;
	});
});

$socket->on('error', function (Exception $e) {
	echo 'Error: ' . $e->getMessage() . PHP_EOL;
});

echo 'Listening on ' . $socket->getAddress() . PHP_EOL;