<?php
if ( ! function_exists( 'frog' ) ) {
	function frog( ...$variables ) {
		\App\Client::send( ...$variables );
	}
}