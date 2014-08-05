<div class="page-header">
	<h2><?php echo $pageTitle; ?></h2>
</div>

<?php echo $this->Form->create('Post', array(
	'class' => 'form',
	'inputDefaults' => array(
		'format' => array('before', 'label', 'between', 'input', 'error', 'after'),
		'div' => 'form-group',
		'class' => 'form-control',
		'error' => array('attributes' => array('wrap' => 'span', 'class' => 'text-danger')),
	),
)); ?>
	<?php echo $this->Form->input('Post.id'); ?>
	<?php echo $this->Form->input('Post.type', array('type' => 'hidden', 'value' => 'page')); ?>
	<?php echo $this->Form->input('Post.parent_id', array('options' => $parentPages)); ?>
	<?php echo $this->Form->input('Post.title'); ?>
	<?php echo $this->Form->input('Post.slug'); ?>
	<?php echo $this->Form->input('Post.content', array('class' => 'wysiwyg')); ?>
	<?php echo $this->Form->input('Post.online'); ?>
	<?php echo $this->Form->input('Post.order'); ?>
	<?php echo $this->Form->submit('Save', array('class' => 'btn btn-default')); ?>
<?php echo $this->Form->end(); ?>

<?php $this->Html->script('tinymce/tinymce.min', array('inline' => false)); ?>