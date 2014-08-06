<div class="page-header">
	<h2>Installation</h2>
</div>

<div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $progression; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $progression; ?>%;">
    <?php echo $progression; ?>%
  </div>
</div>

<?php if (!empty($steps)) : ?>
	<?php foreach ($steps as $step) : ?>
		<div class="panel panel-<?php echo $step['status']; ?>">
			<div class="panel-heading"><?php echo $step['title']; ?></div>
			<?php if ($step['status'] != 'success') : ?>
				<div class="panel-body"><?php echo $step['text']; ?></div>
			<?php endif; ?>
		</div>
	<?php endforeach; ?>
<?php endif; ?>