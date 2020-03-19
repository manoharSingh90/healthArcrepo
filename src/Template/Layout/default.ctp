<!DOCTYPE html>
<html>
<head>
	<title>HealthArc</title>

	<?php echo $this->Html->css(["bootstrap","style"]); ?>
	
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
	
	<?php echo $this->Html->script(["bootstrap.js"]); ?>
</head>

<?= $this->Flash->render() ?>
<?= $this->fetch('content') ?>

</html>
