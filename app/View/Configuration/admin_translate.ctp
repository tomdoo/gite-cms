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
	<?php echo $this->Form->create('Config', array(
		'class' => 'form',
		'inputDefaults' => array(
			'format' => array('before', 'label', 'between', 'input', 'error', 'after'),
			'div' => 'form-group',
			'class' => 'form-control',
			'error' => array('attributes' => array('wrap' => 'span', 'class' => 'text-danger')),
		),
	)); ?>
		<?php echo $this->Form->input('Config.id'); ?>
		<?php echo $this->Form->input('Config.value', array('label' => $configOrigin['Config']['name'])); ?>
		<?php echo $this->Form->submit('Save', array('class' => 'btn btn-default')); ?>
	<?php echo $this->Form->end(); ?>
<?php endif; ?>