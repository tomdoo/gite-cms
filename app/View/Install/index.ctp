<?php if (empty($showSql)) : ?>
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
<?php else : ?>
	<?php if (!empty($defaultLanguage)) : ?>
	  <pre>
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
CREATE TABLE IF NOT EXISTS `bookings` (
`id` int(11) NOT NULL,
  `from` date NOT NULL,
  `to` date NOT NULL,
  `full` tinyint(1) NOT NULL,
  `details` text,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
CREATE TABLE IF NOT EXISTS `configs` (
`id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `value` varchar(200) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;
INSERT INTO `configs` (`id`, `name`, `value`) VALUES
(1, 'title', 'Site title'),
(2, 'baseline', 'Site baseline');
CREATE TABLE IF NOT EXISTS `contacts` (
`id` int(11) NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'contact',
  `name` varchar(150) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `text` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
CREATE TABLE IF NOT EXISTS `i18n` (
`id` int(10) NOT NULL,
  `locale` varchar(6) NOT NULL,
  `model` varchar(255) NOT NULL,
  `foreign_key` int(10) NOT NULL,
  `field` varchar(255) NOT NULL,
  `content` text
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;
INSERT INTO `i18n` (`id`, `locale`, `model`, `foreign_key`, `field`, `content`) VALUES
(1, '<?php echo $defaultLanguage; ?>', 'Post', 1, 'title', 'Pages'),
(2, '<?php echo $defaultLanguage; ?>', 'Post', 1, 'slug', 'pages'),
(3, '<?php echo $defaultLanguage; ?>', 'Post', 1, 'content', ''),
(16, '<?php echo $defaultLanguage; ?>', 'Config', 1, 'value', 'Aveyron - Gîte de la Roque'),
(17, '<?php echo $defaultLanguage; ?>', 'Config', 2, 'value', 'Bienvenue sur le site du gîte de la Roque');
CREATE TABLE IF NOT EXISTS `posts` (
`id` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `slug` varchar(150) DEFAULT NULL,
  `content` text NOT NULL,
  `order` int(11) DEFAULT NULL,
  `online` tinyint(1) NOT NULL DEFAULT '0',
  `parent_id` int(11) DEFAULT NULL,
  `lft` int(11) NOT NULL,
  `rght` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
INSERT INTO `posts` (`id`, `type`, `title`, `slug`, `content`, `order`, `online`, `parent_id`, `lft`, `rght`, `created`, `modified`) VALUES
(1, 'page', 'Pages', 'pages', '<p>Contenu</p>', NULL, 1, 0, 1, 10, '2014-08-06 05:13:15', '0000-00-00 00:00:00');
ALTER TABLE `bookings`
 ADD PRIMARY KEY (`id`);
ALTER TABLE `configs`
 ADD PRIMARY KEY (`id`);
ALTER TABLE `contacts`
 ADD PRIMARY KEY (`id`);
ALTER TABLE `i18n`
 ADD PRIMARY KEY (`id`), ADD KEY `locale` (`locale`), ADD KEY `model` (`model`), ADD KEY `row_id` (`foreign_key`), ADD KEY `field` (`field`);
ALTER TABLE `posts`
 ADD PRIMARY KEY (`id`);
ALTER TABLE `bookings`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `configs`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
ALTER TABLE `contacts`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `i18n`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
ALTER TABLE `posts`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
	</pre>
	<?php else : ?>
	  <p class="text-danger text-center">Check config file first.</p>
	<?php endif; ?>
<?php endif; ?>