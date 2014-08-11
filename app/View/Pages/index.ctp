<h2><?php echo ___('pages-pages-list', 'Pages list'); ?></h2>
<?php if (!empty($pages)) : ?>
	<?php foreach ($pages as $page) : ?>
		<?php echo $this->element('pages', array('page' => $page)); ?>
	<?php endforeach; ?>
<?php endif; ?>