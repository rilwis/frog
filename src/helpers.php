<?php
if ( ! function_exists( 'f' ) ) {
	function f( ...$variables ) {
		wp_remote_post( 'http://' . HOST . ':' . PORT, [
			'headers' => [
				'Content-Type' => 'application/json',
			],
			'body' => json_encode( $variables ),
		] );
	}
}