<div class="page-header">
	<h2>Edit booking</h2>
</div>

<?php echo $this->Form->create('Booking', array(
	'class' => 'form',
	'inputDefaults' => array(
		'format' => array('before', 'label', 'between', 'input', 'error', 'after'),
		'div' => 'form-group',
		'class' => 'form-control',
		'error' => array('attributes' => array('wrap' => 'span', 'class' => 'text-danger')),
	),
)); ?>
	<?php echo $this->Form->input('Booking.id'); ?>
	<?php echo $this->Form->input('Booking.from', array('type' => 'text', 'class' => 'form-control datepicker')); ?>
	<?php echo $this->Form->input('Booking.to', array('type' => 'text', 'class' => 'form-control datepicker')); ?>
	<?php echo $this->Form->input('Booking.full'); ?>
	<?php echo $this->Form->input('Booking.details'); ?>
	<?php echo $this->Form->submit('Save', array('class' => 'btn btn-default')); ?>
<?php echo $this->Form->end(); ?>