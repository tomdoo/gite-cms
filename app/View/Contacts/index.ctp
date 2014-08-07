<h2>Contact us</h2>
<p>Fill in this form to send us an email. All fields are required.</p>
<?php echo $this->Form->create('Contact', array(
	'class' => 'form',
	'inputDefaults' => array(
		'format' => array('before', 'label', 'between', 'input', 'error', 'after'),
		'div' => 'form-group',
		'class' => 'form-control',
		'required' => false,
		'error' => array('attributes' => array('wrap' => 'span', 'class' => 'text-danger')),
	),
)); ?>
	<?php echo $this->Form->input('Contact.name'); ?>
	<?php echo $this->Form->input('Contact.email'); ?>
	<?php echo $this->Form->input('Contact.subject'); ?>
	<?php echo $this->Form->input('Contact.text'); ?>
	<?php echo $this->Form->submit('Send', array('class' => 'btn btn-default')); ?>
<?php echo $this->Form->end(); ?>