<div class="page-header">
	<h2>Global configuration</h2>
</div>

<?php if (!empty($configs)) : ?>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>Name</th>
				<th>Value</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($configs as $config) : ?>
				<tr>
					<td><?php echo $config['Config']['name']; ?></td>
					<td><?php echo $config['Config']['value']; ?></td>
					<td>
						<?php echo $this->Html->link('<i class="glyphicon glyphicon-flag"></i>', array('prefix' => 'admin', 'controller' => 'configuration', 'action' => 'translate', $config['Config']['id']), array('escape' => false, 'class' => 'btn btn-default btn-sm')); ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php else : ?>
	<p class="lead text-danger">No configuration at this time :(</p>
<?php endif; ?>