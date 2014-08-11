<div class="page-header">
	<h2><?php echo $pageTitle; ?></h2>
</div>

<?php echo $this->Form->create('Translation', array(
	'class' => 'form',
	'inputDefaults' => array(
		'format' => array('before', 'label', 'between', 'input', 'error', 'after'),
		'div' => 'form-group',
		'class' => 'form-control',
		'error' => array('attributes' => array('wrap' => 'span', 'class' => 'text-danger')),
	),
)); ?>
	<?php echo $this->Form->input('Translation.id'); ?>
	<?php echo $this->Form->input('Translation.locale', array('type' => 'hidden', 'value' => $locale)); ?>
	<?php echo $this->Form->input('Translation.model', array('type' => 'hidden', 'value' => $model)); ?>
	<?php echo $this->Form->input('Translation.foreign_key', array('type' => 'hidden', 'value' => $foreign_key)); ?>
	<?php echo $this->Form->input('Translation.field'); ?>
	<?php echo $this->Form->input('Translation.content'); ?>
	<?php echo $this->Form->submit('Save', array('class' => 'btn btn-default')); ?>
<?php echo $this->Form->end(); ?>

<?php $this->Html->script('tinymce/tinymce.min', array('inline' => false)); ?>