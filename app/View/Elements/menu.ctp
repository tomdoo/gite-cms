<?php if (empty($menu)) : ?>
	<?php $menu = $this->requestAction(array('controller' => 'pages', 'action' => 'menu')); ?>
<?php endif; ?>
<ul>
	<?php foreach ($menu as $element) : ?>
		<li>
			<?php echo $this->Html->link($element['Post']['title'], '/pages/show/'.$element['Post']['slug']); ?>
			<?php if (!empty($element['children'])) : ?>
				<?php echo $this->element('menu', array('menu' => $element['children'])); ?>
			<?php endif; ?>
		</li>
	<?php endforeach; ?>
</ul>