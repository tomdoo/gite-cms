<div class="page-header">
	<h2>Contacts manager</h2>
</div>

<?php if (!empty($contacts)) : ?>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>Date</th>
				<th>Name</th>
				<th>Email</th>
				<th>Subject</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($contacts as $contact) : ?>
				<tr>
					<td><?php echo $contact['Contact']['created']; ?></td>
					<td><?php echo $contact['Contact']['name']; ?></td>
					<td><?php echo $contact['Contact']['email']; ?></td>
					<td>[<?php echo $title_for_layout; ?>] <?php echo ucfirst($contact['Contact']['type']); ?>: <?php echo $contact['Contact']['subject']; ?></td>
					<td>
						<?php echo $this->Html->link('<i class="glyphicon glyphicon-search"></i>', '/admin/contacts/view/'.$contact['Contact']['id'], array('escape' => false, 'class' => 'btn btn-default btn-sm')); ?>
						<?php echo $this->Html->link('<i class="glyphicon glyphicon-envelope"></i>', 'mailto:'.$contact['Contact']['email'].'?subject='.rawurlencode($contact['Contact']['subject']).'&body='.rawurlencode($contact['Contact']['text']), array('escape' => false, 'class' => 'btn btn-default btn-sm')); ?>
						<?php echo $this->Html->link('<i class="glyphicon glyphicon-trash"></i>', '/admin/contacts/delete/'.$contact['Contact']['id'], array('escape' => false, 'class' => 'btn btn-default btn-sm'), 'Delete this contact ?'); ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<div class="pagination">
		<?php echo $this->Paginator->numbers(); ?>
	</div>
<?php else : ?>
	<p class="lead text-danger">No contact at this time :(</p>
<?php endif; ?>