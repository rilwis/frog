<?php
if ( ! function_exists( 'frog' ) ) {
	function frog( ...$variables ) {
		Client::send( ...$variables );
	}
}