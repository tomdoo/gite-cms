<h2><?php echo ___('users-login', 'Log in'); ?></h2>
<p><?php echo ___('users-login-intro', 'Enter username and password'); ?></p>
<?php echo $this->Form->create('User', array(
	'class' => 'form',
	'inputDefaults' => array(
		'format' => array('before', 'label', 'between', 'input', 'error', 'after'),
		'div' => 'form-group',
		'class' => 'form-control',
		'required' => false,
		'error' => array('attributes' => array('wrap' => 'span', 'class' => 'text-danger')),
		'label' => false,
	),
)); ?>
	<?php echo $this->Form->input('User.username', array('placeholder' => ___('users-username', 'Username'))); ?>
	<?php echo $this->Form->input('User.password', array('placeholder' => ___('users-password', 'Password'))); ?>
	<?php echo $this->Form->submit(___('users-login', 'Log in'), array('class' => 'btn btn-default')); ?>
<?php echo $this->Form->end(); ?>