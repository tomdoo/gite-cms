<h2><?php echo ___('bookings-title', 'Bookings'); ?></h2>

<p>Date: <?php echo $year; ?>-<?php echo $month; ?></p>

<ul>
	<?php foreach ($days as $day => $status) : ?>
		<li><?php echo $day; ?>: <?php echo $status; ?></li>
	<?php endforeach; ?>
</ul>