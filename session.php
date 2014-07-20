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
<?php session_start() ?>
<?php $_SESSION['new'][] = 1; ?>
<?php $_SESSION['mod']++; ?>
<?php if (isset($_SESSION['rem'])) {unset($_SESSION['rem']);} else $_SESSION['rem'] = 1; ?>
