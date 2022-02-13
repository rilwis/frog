<?php
if ( ! function_exists( 'frog' ) ) {
	function frog( ...$variables ) {
		wp_remote_post( HOST . ':' . PORT, [
			'body' => $variables
		] );
		App\Client::send( ...$variables );
	}
}