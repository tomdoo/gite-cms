<div class="page-header">
	<h2><?php echo $pageTitle; ?></h2>
</div>

<?php if (!empty($selectLanguage)) : ?>
	<div class="btn-toolbar" role="toolbar">
		<?php foreach ($languages as $code => $language) : ?>
			<div class="btn-group"><?php echo $this->Html->link($language, $this->here.'/'.$code, array('escape' => false, 'class' => 'btn btn-default')); ?></div>
		<?php endforeach; ?>
	</div>
<?php else : ?>
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
		<?php echo $this->Form->input('Post.title'); ?>
		<?php echo $this->Form->input('Post.slug'); ?>
		<?php echo $this->Form->input('Post.content', array('class' => 'wysiwyg')); ?>
		<?php echo $this->Form->submit('Save', array('class' => 'btn btn-default')); ?>
	<?php echo $this->Form->end(); ?>

	<?php $this->Html->script('tinymce/tinymce.min', array('inline' => false)); ?>
<?php endif; ?>