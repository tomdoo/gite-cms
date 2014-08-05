<div class="page-header">
	<h2>Bookings manager</h2>
</div>

<?php echo $this->Html->link('<i class="glyphicon glyphicon-plus"></i> Add booking', '/admin/bookings/edit', array('escape' => false, 'class' => 'btn btn-default')); ?>

<?php if (!empty($bookings)) : ?>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>From</th>
				<th>To</th>
				<th>Full</th>
				<th>Details</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($bookings as $booking) : ?>
				<tr>
					<td><?php echo $this->Time->i18nFormat($booking['Booking']['from']); ?></td>
					<td><?php echo $this->Time->i18nFormat($booking['Booking']['to']); ?></td>
					<td><?php echo $this->Admin->fullRender($booking['Booking']['full']); ?></td>
					<td><?php echo $this->Text->truncate($booking['Booking']['details']); ?></td>
					<td>
						<?php echo $this->Html->link('<i class="glyphicon glyphicon-pencil"></i>', '/admin/bookings/edit/'.$booking['Booking']['id'], array('escape' => false, 'class' => 'btn btn-default btn-sm')); ?>
						<?php echo $this->Html->link('<i class="glyphicon glyphicon-trash"></i>', '/admin/bookings/delete/'.$booking['Booking']['id'], array('escape' => false, 'class' => 'btn btn-default btn-sm'), 'Delete this booking ?'); ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<div class="pagination">
		<?php echo $this->Paginator->numbers(); ?>
	</div>
<?php else : ?>
	<p class="lead text-danger">No booking at this time :(</p>
<?php endif; ?>