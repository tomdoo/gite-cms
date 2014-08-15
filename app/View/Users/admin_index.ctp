<div class="page-header">
	<h2>Users manager</h2>
</div>

<?php echo $this->Html->link('<i class="glyphicon glyphicon-plus"></i> Add user', array('prefix' => 'admin', 'controller' => 'users', 'action' => 'edit'), array('escape' => false, 'class' => 'btn btn-default')); ?>

<?php if (!empty($users)) : ?>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>Username</th>
				<th>Role</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($users as $user) : ?>
				<tr>
					<td><?php echo $user['User']['username']; ?></td>
					<td><?php echo $user['User']['role']; ?></td>
					<td>
						<?php echo $this->Html->link('<i class="glyphicon glyphicon-edit"></i>', '/admin/users/edit/'.$user['User']['id'], array('escape' => false, 'class' => 'btn btn-default btn-sm')); ?>
						<?php echo $this->Html->link('<i class="glyphicon glyphicon-trash"></i>', '/admin/users/delete/'.$user['User']['id'], array('escape' => false, 'class' => 'btn btn-default btn-sm'), 'Delete this user ?'); ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php else : ?>
	<p class="lead text-danger">No user at this time :(</p>
<?php endif; ?>