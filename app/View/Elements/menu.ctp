<?php $menu = !empty($menu) ? $menu : $this->requestAction(array('controller' => 'pages', 'action' => 'menu')); ?>
<?php if (!empty($menu)) : ?>
	<ul>
		<?php foreach ($menu as $element) : ?>
			<li>
				<?php echo $this->Html->link($element['Post']['title'], array('controller' => 'pages', 'action' => 'show', $element['Post']['slug'])); ?>
				<?php if (!empty($element['children'])) : ?>
					<?php echo $this->element('menu', array('menu' => $element['children'])); ?>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>