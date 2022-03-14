<?php require dirname( __DIR__ ) . '/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Frog</title>
	<link rel="stylesheet" href="https://unpkg.com/bamboo.css/dist/light.min.css" class="light">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.5.0/build/styles/atom-one-light.min.css" class="light">
	<link rel="stylesheet" href="https://unpkg.com/bamboo.css/dist/dark.min.css" class="dark" disabled>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.5.0/build/styles/atom-one-dark.min.css" class="dark" disabled>
	<style>
		body {
			margin-top: 2em;
			max-width: 100ch;
		}
		.hidden {
			display: none;
		}
		.controls {
			position: fixed;
			top: 1em;
			right: 1em;
		}
		pre {
			padding: 0;
			position: relative;
			border-radius: .25rem;
		}
		.caller {
			position: absolute;
			top: 0;
			right: 0;
			font-size: .75rem;
			background: var(--b-bg-2);
			padding: .25rem .5rem;
			border-radius: 0 .25rem 0 .25rem;
		}
	</style>
</head>
<body>
	<p>Listening...</p>
	<div id="result"></div>

	<div class="controls">
		<button id="scheme">☀</button>
		<button id="clear" class="hidden">Clear</button>
	</div>

	<script src="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.5.0/build/highlight.min.js"></script>
	<script>
		// Toggle color scheme.
		let colorScheme = getUserColorScheme();
		const toggleSchemeBtn = document.querySelector( '#scheme' );
		toggleSchemeBtn.addEventListener( 'click', () => {
			colorScheme = colorScheme === 'light' ? 'dark' : 'light';
			setColorScheme( colorScheme );
		} );
		setColorScheme( colorScheme );

		// Clear content.
		const clearBtn = document.querySelector( '#clear' );
		clearBtn.addEventListener( 'click', () => {
			result.innerHTML = '';
			clearBtn.classList.add( 'hidden' );
		} );

		// Append new data.
		const result     = document.querySelector( '#result' );
		const connection = new WebSocket('ws://<?= HOST ?>:<?= PORT ?>');
		connection.onmessage = ( { data } ) => {
			const pre = document.createElement( 'pre' );
			let [func, message] = data.split( '###' );

			// Show caller.
			let caller = document.createElement( 'span' );
			caller.classList.add( 'caller' );
			caller.innerHTML = func;
			pre.appendChild( caller );

			// Show code.
			const code = document.createElement( 'code' );
			code.classList.add( 'language-php' );
			code.innerHTML = message.replace( '<', '&lt;' ).replace( '>', '&gt;' );
			pre.appendChild( code );
			result.appendChild( pre );
			hljs.highlightElement( code );

			// Show clear button.
			clearBtn.classList.remove( 'hidden' );
		}

		function getUserColorScheme() {
			// Get from user preference first.
			let colorScheme = localStorage.getItem( 'colorScheme' ) ;
			if ( colorScheme ) {
				return colorScheme;
			}

			// Then from system preference. Link: https://medium.com/hypersphere-codes/detecting-system-theme-in-javascript-css-react-f6b961916d48
			const detectDarkMode = window.matchMedia( '(prefers-color-scheme: dark)' );

			// Fallback to default 'light' color scheme.
			return detectDarkMode.matches ? 'dark' : 'light';
		}

		function setColorScheme( colorScheme ) {
			// Enable style.
			document.querySelectorAll( 'link' ).forEach( link => link.setAttribute( 'disabled', true ) );
			document.querySelectorAll( `.${colorScheme}` ).forEach( link => link.removeAttribute( 'disabled' ) );

			// Update button & store data.
			toggleSchemeBtn.innerHTML = colorScheme === 'light' ? '☀' : '🌙';
			localStorage.setItem( 'colorScheme', colorScheme );
		}
	</script>
</body>
</html>