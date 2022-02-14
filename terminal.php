<?php
require __DIR__ . '/vendor/autoload.php';

use React\Http\HttpServer;
use React\Socket\SocketServer;
use React\Http\Message\Response;
use Psr\Http\Message\ServerRequestInterface;
use Riimu\Kit\PHPEncoder\PHPEncoder;


$http = new HttpServer( function ( ServerRequestInterface $request ) {
	echo "\n", str_repeat( '-', 40 ), "\n";

	$body      = (string) $request->getBody();
	$variables = json_decode( $body, true );

	$encoder = new PHPEncoder;
	foreach ( $variables as $variable ) {
		echo $encoder->encode( $variable ), "\n";
	}

	echo "\n";

	return Response::plaintext( 'Success' );
} );

$socket = new SocketServer( HOST . ':' . PORT );
$http->listen( $socket );