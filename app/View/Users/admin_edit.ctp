<div class="page-header">
	<h2><?php echo $pageTitle; ?></h2>
</div>

<?php echo $this->Form->create('User', array(
	'class' => 'form',
	'inputDefaults' => array(
		'format' => array('before', 'label', 'between', 'input', 'error', 'after'),
		'div' => 'form-group',
		'class' => 'form-control',
		'error' => array('attributes' => array('wrap' => 'span', 'class' => 'text-danger')),
	),
)); ?>
	<?php if (empty($create)) : ?>
		<?php echo $this->Form->input('User.id', array('type' => 'hidden')); ?>
	<?php endif; ?>
	<?php echo $this->Form->input('User.username'); ?>
	<?php echo $this->Form->input('User.password', array('required' => false)); ?>
	<?php echo $this->Form->input('User.role'); ?>
	<?php echo $this->Form->submit('Save', array('class' => 'btn btn-default')); ?>
<?php echo $this->Form->end(); ?>