<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('bootstrap-theme.min');
		echo $this->Html->css('bootstrap-datepicker');
		echo $this->Html->css('admin_styles');
		echo $this->Html->script('jquery.min', array('inline' => false));
		echo $this->Html->script('jquery.form.min', array('inline' => false));
		echo $this->Html->script('bootstrap.min', array('inline' => false));
		echo $this->Html->script('bootstrap-datepicker', array('inline' => false));
		echo $this->Html->script('admin_scripts', array('inline' => false));

		echo $this->fetch('meta');
		echo $this->fetch('css');
	?>
</head>
<body>
	<div class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<?php echo $this->Html->link('Administration', array('prefix' => 'admin', 'controller' => 'home'), array('class' => 'navbar-brand')); ?>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li><?php echo $this->Html->link('Configuration', array('prefix' => 'admin', 'controller' => 'configuration', 'action' => 'index')); ?></li>
					<li><?php echo $this->Html->link('Users', array('prefix' => 'admin', 'controller' => 'users', 'action' => 'index')); ?></li>
					<li><?php echo $this->Html->link('Pages', array('prefix' => 'admin', 'controller' => 'pages', 'action' => 'index')); ?></li>
					<li><?php echo $this->Html->link('Bookings', array('prefix' => 'admin', 'controller' => 'bookings', 'action' => 'index')); ?></li>
					<li><?php echo $this->Html->link('Contacts', array('prefix' => 'admin', 'controller' => 'contacts', 'action' => 'index')); ?></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><?php echo $this->Html->link('Log out', array('admin' => false, 'controller' => 'users', 'action' => 'logout')); ?></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="container">
		<?php echo $this->Session->flash(); ?>
		<?php echo $this->fetch('content'); ?>
	</div>
	<?php echo $this->fetch('script'); ?>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
