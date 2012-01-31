<?php
$g=$_GET;
header('Content-type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<head>
	<title>monkeyNuts</title>
	<meta charset="utf-8"/>
	<meta name="description" content="the collected tweets of @ben_nuttall and @wisemonkeyash"/>
	<meta name="keywords" content="twitter,bromance,sitcom,monkey,nuts"/>
	<link href="theme/css.php?_style,style" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="wrap">
	<header>
		<h1><a href="http://m1ke.me/monkeynuts/">monkeyNuts</a></h1>
		<h2>The, currently very one-sided, adventures of Ben &amp; Ash</h2>
<?php if ($_GET['page']>1) echo '<h3>Page '.$_GET['page'].'</h3>'?>
	</header>