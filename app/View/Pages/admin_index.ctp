<div class="page-header">
	<h2>Pages manager</h2>
</div>

<?php echo $this->Html->link('<i class="glyphicon glyphicon-plus"></i> Add page', '/admin/pages/edit', array('escape' => false, 'class' => 'btn btn-default')); ?>

<?php if (!empty($pages)) : ?>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>Title</th>
				<th>Online</th>
				<th>Order</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($pages as $page) : ?>
				<?php echo $this->element('admin_pages', array('page' => $page)); ?>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php else : ?>
	<p class="lead text-danger">No page at this time :(</p>
<?php endif; ?>