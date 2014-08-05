<?php if (!empty($page)) : ?>
	<h2><?php echo $page['Post']['title']; ?></h2>
	<?php echo $page['Post']['content']; ?>
<?php else : ?>
	<p class="error">La page n'existe pas</p>
<?php endif; ?>