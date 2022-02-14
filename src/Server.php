<?php
namespace App;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Riimu\Kit\PHPEncoder\PHPEncoder;
use SplObjectStorage;
use Exception;

class Server implements MessageComponentInterface {
	protected $clients;

	public function __construct() {
		$this->clients = new SplObjectStorage;
	}

	public function onOpen( ConnectionInterface $connection ) {
		$this->clients->attach( $connection );
	}

	public function onMessage( ConnectionInterface $from, $message ) {
		$variables = json_decode( $message, true );

		ob_start();
		$encoder = new PHPEncoder;
		foreach ( $variables as $variable ) {
			echo $encoder->encode( $variable ), "\n";
		}
		$message = ob_get_clean();

		// Output to terminal.
		echo "\n", str_repeat( '-', 40 ), "\n", $message, "\n";

		foreach ( $this->clients as $client ) {
			if ( $from !== $client ) {
				$client->send( $message );
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