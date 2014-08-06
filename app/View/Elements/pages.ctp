<li>
	<?php echo $this->Html->link($page['Post']['title'], array('action' => 'show', $page['Post']['slug'])); ?>
	<?php if (!empty($page['children'])) : ?>
		<ul>
			<?php foreach ($page['children'] as $page) : ?>
				<?php echo $this->element('pages', array('page' => $page)); ?>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</li>