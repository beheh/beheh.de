<!doctype html>
<html>
	<head>
		<title>beheh.de</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="beheh.css">
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
		<link href='//fonts.googleapis.com/css?family=Halant' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<div id="background"></div>
		<div id="container">
			<i class="pusher"></i>
			<div id="lookatme">
				<h1>Benedict Etzel</h1>
				<?php if(file_exists('catchphrase.txt')) { echo file_get_contents('catchphrase.txt'); } ?>
			</div>
			<footer id="social">
				<p>
					<a href="https://github.com/beheh" title="GitHub"><i class="fa fa-github"></i></a>
					<a href="https://twitter.com/beheh" title="Twitter"><i class="fa fa-twitter"></i></a>
					<a href="https://facebook.com/benedict.etzel" title="Facebook"><i class="fa fa-facebook"></i></a>
				</p>
			</footer>
			<footer id="imprint">
				<?php if(file_exists('imprint.txt')) { echo file_get_contents('imprint.txt'); } ?>
			</footer>
		</div>
		<?php if(file_exists('tracking.txt')) { echo file_get_contents('tracking.txt'); } ?>
	</body>
</html>
