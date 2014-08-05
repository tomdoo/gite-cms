<tr>
	<td><?php echo empty($space) ? '' : $space; ?><?php echo $page['Post']['title']; ?></td>
	<td><?php echo $this->Admin->onlineRender($page['Post']['online']); ?></td>
	<td><?php echo $page['Post']['order']; ?></td>
	<td>
		<?php echo $this->Html->link('<i class="glyphicon glyphicon-pencil"></i>', '/admin/pages/edit/'.$page['Post']['id'], array('escape' => false, 'class' => 'btn btn-default btn-sm')); ?>
		<?php echo $this->Html->link('<i class="glyphicon glyphicon-flag"></i>', '/admin/pages/translate/'.$page['Post']['id'], array('escape' => false, 'class' => 'btn btn-default btn-sm')); ?>
		<?php echo $this->Html->link('<i class="glyphicon glyphicon-trash"></i>', '/admin/pages/delete/'.$page['Post']['id'], array('escape' => false, 'class' => 'btn btn-default btn-sm'), 'Delete the page "'.$page['Post']['title'].'"'); ?>
	</td>
</tr>
<?php if (!empty($page['children'])) : ?>
	<?php $space = empty($space) ? '&nbsp;&nbsp;&nbsp;&nbsp;' : $space.'&nbsp;&nbsp;&nbsp;&nbsp;'; ?>
	<?php foreach ($page['children'] as $child) : ?>
		<?php echo $this->element('admin_pages', array('page' => $child, 'space' => $space)); ?>
	<?php endforeach; ?>
<?php endif; ?>