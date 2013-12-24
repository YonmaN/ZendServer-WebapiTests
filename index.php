<html>
<head>
</head>
<body>
<ul>
<?php foreach (glob('WebApi-*') as $script):?>
<li><a href="<?php echo $script ?>" target="_blank">/<?php echo $script ?></a></li>
<?php endforeach ?>
</ul>
</body>
</html>