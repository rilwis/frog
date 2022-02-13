<?php require dirname( __DIR__ ) . '/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Frog</title>
	<link rel="stylesheet" href="https://unpkg.com/bamboo.css">
</head>
<body>
	<div id="data"></div>

	<script>
	const show = data => {
		const el = document.querySelector( '#data' );
		el.innerHTML += `<pre>${ data }</pre>`;
	};

	const connection = new WebSocket('ws://<?= HOST ?>:<?= PORT ?>');
	connection.onmessage = e => show( e.data );
	</script>
</body>
</html>