<?php $languages = !empty($languages) ? $languages : $this->requestAction(array('controller' => 'configuration', 'action' => 'languages')); ?>
<?php if (!empty($languages)) : ?>
	<ul>
		<?php foreach ($languages as $code => $language) : ?>
			<li>
				<?php echo $this->Html->link($language, '/'.$code, array('title' => $language)); ?>
			</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>