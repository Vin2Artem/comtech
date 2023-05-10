<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>
		<?= $title ?>
	</title>
	<link rel="stylesheet" href="/project/webroot/styles/main.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>

<body>
	<header>
		<div class="header">
		<div>
			<img src="\project\webroot\images\mainLogo.png" alt="Comtech" class="logo">
		</div>
		<div class="logout">
			<a href="/logout">Выйти</a>
		</div>
		</div>
	</header>
	<div class="container">
		<?= $content ?>
	</div>
</body>

</html>