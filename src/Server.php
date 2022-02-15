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

		// Output to terminal.
		$output = [];
		foreach ( $variables as $variable ) {
			$output[] = $this->encoder->encode( $variable );
		}
		echo "\n", str_repeat( '-', 40 ), "\n\n", implode( "\n", $output ), "\n";

		// Output to the browser.
		$output = [];
		foreach ( $variables as $variable ) {
			$output[] = $this->highlight( $this->encoder->encode( $variable ) );
		}
		$output = implode( "\n\n", $output );
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

	/**
	 * @link https://www.php.net/highlight_string
	 */
	private function highlight( $text ) {
		$text = trim( $text );
		$text = highlight_string( "<?php " . $text, true );  // highlight_string() requires opening PHP tag or otherwise it will not colorize the text
		$text = trim( $text );
		$text = preg_replace( "|^\\<code\\>\\<span style\\=\"color\\: #[a-fA-F0-9]{0,6}\"\\>|", "", $text, 1 );  // remove prefix
		$text = preg_replace( "|\\</code\\>\$|", "", $text, 1 );  // remove suffix 1
		$text = trim( $text );  // remove line breaks
		$text = preg_replace( "|\\</span\\>\$|", "", $text, 1 );  // remove suffix 2
		$text = trim( $text );  // remove line breaks
		$text = preg_replace( "|^(\\<span style\\=\"color\\: #[a-fA-F0-9]{0,6}\"\\>)(&lt;\\?php&nbsp;)(.*?)(\\</span\\>)|", "\$1\$3\$4", $text );  // remove custom added "<?php "

		return $text;
	}
}