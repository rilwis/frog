<?php
namespace App;

use React\Socket\Connector;
use React\Socket\ConnectionInterface;

class Client {
	public static function send( ...$variables ) {
		// $socket = socket_create( AF_INET, SOCK_STREAM, getprotobyname('tcp') );

		// ob_start();
		// foreach ( $variables as $variable ) {
		// 	var_dump( $variable );
		// }
		// $message = ob_get_clean();
		// $length = strlen($message);
		// socket_sendto( $socket, $message, $length, 0, HOST, PORT);
		// socket_close( $socket );

		// $context = new \ZMQContext;
		// $socket = $context->getSocket( ZMQ::SOCKET_PUSH, 'my pusher');
		// $socket->connect( 'tcp://' . HOST . ':' . PORT );

		// $socket->send( json_encode( $variables ) );


		// $connector = new Connector();
		// $connector->connect('127.0.0.1:8080')->then(function (ConnectionInterface $connection) {
		// 	// $connection->pipe(new React\Stream\WritableResourceStream(STDOUT));
		//     $connection->write('asdfasldfkhl');
		//     $connection->end();
		// }, function (Exception $e) {
		//     echo 'Error: ' . $e->getMessage() . PHP_EOL;
		// });

		$client = new \React\Http\Browser();

		$client->post('http://' . HOST . ':' . PORT, [], json_encode($variables))->then(function (Psr\Http\Message\ResponseInterface $response) {
		    dd($response->getHeaders(), (string)$response->getBody());
		}, function (Exception $e) {
		    echo 'Error: ' . $e->getMessage() . PHP_EOL;
		});
	}
}