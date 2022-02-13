<?php
namespace App;

class Client {
	public static function send( ...$variables ) {
		$socket = socket_create( AF_INET, SOCK_DGRAM, SOL_UDP );

		ob_start();
		foreach ( $variables as $variable ) {
			var_dump( $variable );
		}
		$message = ob_get_clean();
		$length = strlen($message);

		socket_sendto( $socket, $message, $length, 0, HOST, PORT);
		socket_close( $socket );
	}
}