<?php
if ( ! function_exists( 'frog' ) ) {
	function frog( ...$variables ) {
		$response = wp_remote_post( 'http://' . HOST . ':' . PORT, [
			'headers' => [
				'Content-Type' => 'application/json',
			],
			'body' => json_encode( $variables ),
		] );
	}
}