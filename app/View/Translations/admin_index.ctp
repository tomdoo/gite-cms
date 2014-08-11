<div class="page-header">
	<h2>Translations manager</h2>
</div>

<?php echo $this->Html->link('<i class="glyphicon glyphicon-plus"></i> Add translation', array('prefix' => 'admin', 'controller' => 'translations', 'action' => 'edit'), array('escape' => false, 'class' => 'btn btn-default')); ?>

<?php if (!empty($translations)) : ?>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>Field</th>
				<th>Content</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($translations as $translation) : ?>
				<tr>
					<td><?php echo $translation['Translation']['field']; ?></td>
					<td><?php echo $translation['Translation']['content']; ?></td>
					<td>
						<?php echo $this->Html->link('<i class="glyphicon glyphicon-edit"></i>', array('prefix' => 'admin', 'controller' => 'translations', 'action' => 'edit', $translation['Translation']['id']), array('escape' => false, 'class' => 'btn btn-default btn-sm')); ?>
						<?php echo $this->Html->link('<i class="glyphicon glyphicon-flag"></i>', array('prefix' => 'admin', 'controller' => 'translations', 'action' => 'translate', $translation['Translation']['id']), array('escape' => false, 'class' => 'btn btn-default btn-sm')); ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php else : ?>
	<p class="lead text-danger">No translation at this time :(</p>
<?php endif; ?>