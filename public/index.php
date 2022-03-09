<?php require dirname( __DIR__ ) . '/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Frog</title>
	<link rel="stylesheet" href="https://unpkg.com/bamboo.css/dist/light.min.css">
	<style>
		body {
			margin-top: 2em;
			max-width: 100ch;
		}
		.hidden {
			display: none;
		}
		#clear {
			position: fixed;
			top: 1em;
			right: 1em;
		}
		pre {
			position: relative;
			border-radius: .25rem;
		}
		.caller {
			position: absolute;
			top: 0;
			right: 0;
			font-size: .75rem;
			background: var(--b-focus);
			padding: .25rem .5rem;
			border-radius: 0 .25rem 0 .25rem;
		}
	</style>
</head>
<body>
	<p>Listening...</p>
	<div id="result"></div>
	<button id="clear" class="hidden">Clear</button>

	<script>
	const clearBtn   = document.querySelector( '#clear' );
	const result     = document.querySelector( '#result' );
	const connection = new WebSocket('ws://<?= HOST ?>:<?= PORT ?>');

	connection.onmessage = e => {
		result.innerHTML += `<pre>${ e.data }</pre>`;
		clearBtn.classList.remove( 'hidden' );
	}

	clearBtn.addEventListener( 'click', () => {
		result.innerHTML = '';
		clearBtn.classList.add( 'hidden' );
	} );
	</script>
</body>
</html>