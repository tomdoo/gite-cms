<div class="page-header">
	<h2>Installation</h2>
</div>

<div class="progress">
  <div class="progress-bar <?php echo ($progression<100)?'':'progress-bar-success'; ?>" role="progressbar" aria-valuenow="<?php echo $progression; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $progression; ?>%;">
    <?php echo $progression; ?>%
  </div>
</div>

<?php if ($progression < 100) : ?>
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
<?php else : ?>
	<div class="panel panel-success">
		<div class="panel-heading">Installation completed</div>
		<div class="panel-body">
			<p>Now you can set the param "install" at false in the config.php file !</p>
		</div>
	</div>
<?php endif; ?>