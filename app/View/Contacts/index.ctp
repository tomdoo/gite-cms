<h2><?php echo ___('contacts-title', 'Contact us'); ?></h2>
<p><?php echo ___('contacts-form-intro', 'Fill in this form to send us an email. All fields are required.'); ?></p>
<?php echo $this->Form->create('Contact', array(
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
	<?php echo $this->Form->input('Contact.name', array('placeholder' => ___('contacts-name', 'Name'))); ?>
	<?php echo $this->Form->input('Contact.email', array('placeholder' => ___('contacts-email', 'Email'))); ?>
	<?php echo $this->Form->input('Contact.subject', array('placeholder' => ___('contacts-subject', 'Subject'))); ?>
	<?php echo $this->Form->input('Contact.text', array('placeholder' => ___('contacts-text', 'Text'))); ?>
	<?php echo $this->Form->submit(___('contacts-send', 'Send'), array('class' => 'btn btn-default')); ?>
<?php echo $this->Form->end(); ?>