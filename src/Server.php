<?php
namespace App;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Riimu\Kit\PHPEncoder\PHPEncoder;
use SplObjectStorage;
use Exception;

class Server implements MessageComponentInterface {
	private $encoder;
	private $clients;

	public function __construct() {
		$this->encoder = new PHPEncoder;
		$this->clients = new SplObjectStorage;
	}

	public function onOpen( ConnectionInterface $connection ) {
		$this->clients->attach( $connection );
	}

	public function onMessage( ConnectionInterface $from, $message ) {
		$variables = json_decode( $message, true );

		// First parameter is the caller in format $file:$line.
		$caller = array_shift( $variables );

		// Output to terminal.
		$output = [];
		foreach ( $variables as $variable ) {
			$output[] = $this->encoder->encode( $variable );
		}
		echo "\n", implode( "\n\n", [
			str_repeat( '-', 40 ),
			"# $caller",
			implode( "\n\n", $output ),
		] ), "\n";

		// Output to the browser.
		$output = [];
		foreach ( $variables as $variable ) {
			$output[] = $this->encoder->encode( $variable );
		}
		$output = "$caller###" . implode( "\n\n", $output );
		foreach ( $this->clients as $client ) {
			if ( $from !== $client ) {
				$client->send( $output );
			}
		}
	}

	public function onClose( ConnectionInterface $connection ) {
		$this->clients->detach( $connection );
	}

	public function onError( ConnectionInterface $connection, Exception $e ) {
		$connection->close();
	}
}