<?php
session_start();

function pr($var) {
	echo '<pre>'.print_r($var, true).'</pre>';
}
function prd($var) {
	pr($var);
	die();
}
function chmod_r($Path, $rights) {
	$dp = opendir($Path);
	while($File = readdir($dp)) {
		if($File != "." AND $File != "..") {
			if(is_dir($File)){
				chmod($File, $rights);
			}else{
				chmod($Path."/".$File, $rights);
				if(is_dir($Path."/".$File)) {
					chmod_r($Path."/".$File);
				}
			}
		}
	}
	closedir($dp);
}

if (isset($_GET['start'])) {
	$_SESSION['step'] = 1;
	header('location: install.php');
}

$step = null;
$error = null;
if (!empty($_SESSION['step'])) {
	$step = $_SESSION['step'];
	switch ($step) {
		case 1:
			if (!empty($_POST)) {
				// check some file perms
				$dirname = dirname(dirname(__FILE__));
				$folders = array(
					$dirname.'/Config',
					$dirname.'/webroot/files/uploads',
					$dirname.'/webroot/files/thumbs',
					$dirname.'/tmp',
					$dirname.'/tmp/cache',
					$dirname.'/tmp/cache/models',
					$dirname.'/tmp/cache/persistent',
					$dirname.'/tmp/cache/views',
					$dirname.'/tmp/logs',
					$dirname.'/tmp/sessions',
					$dirname.'/tmp/tests',
				);
				foreach ($folders as $folder) {
					exec("chmod -R 777 ".$folder);
					$perms = intval(substr(sprintf('%o', fileperms('/tmp')), -4));
					if ($perms < 1777) {
						$error = 'Please manually check folder "'.$folder.'".';
						break;
					}
				}
				if (empty($error)) {
					$_SESSION['step'] = 2;
					header('location: install.php');
				}
			}
			break;

		case 2:
			// database connection
			if (!empty($_POST)) {
				$host = !empty($_POST['host']) ? $_POST['host'] : 'localhost';
				$user = !empty($_POST['user']) ? $_POST['user'] : 'root';
				$pass = !empty($_POST['pass']) ? $_POST['pass'] : '';
				$name = !empty($_POST['name']) ? $_POST['name'] : 'gitecms';
				$mysqli = new mysqli($host, $user, $pass, $name);
				if ($mysqli->connect_errno) {
					$error = $mysqli->connect_error;
				} else {
					$file = "<?php\nclass DATABASE_CONFIG {\n	public \$default = array(\n		'datasource' => 'Database/Mysql',\n		'persistent' => false,\n		'host' => '".$host."',\n		'login' => '".$user."',\n		'password' => '".$pass."',\n		'database' => '".$name."',\n		'prefix' => '',\n		'encoding' => 'utf8',\n	);\n}";
					if (file_put_contents('../Config/database.php', $file)) {
						$_SESSION['step'] = 3;
						$_SESSION['database']['host'] = $host;
						$_SESSION['database']['user'] = $user;
						$_SESSION['database']['pass'] = $pass;
						$_SESSION['database']['name'] = $name;
						header('location: install.php');
					} else {
						$error = 'Impossible to write file app/Config/database.php';
					}
					$mysqli->close();
				}
			}
			break;

		case 3:
			// generate config file
			if (!empty($_POST)) {
				$title = !empty($_POST['title']) ? $_POST['title'] : 'My famous Gite';
				$baseline = !empty($_POST['baseline']) ? $_POST['baseline'] : 'The cutest gite all around the world!';
				$contact = !empty($_POST['contact']) ? $_POST['contact'] : 'contact@me.com';

				$defaultLanguage = !empty($_POST['dl']) ? $_POST['dl'] : 'fra';
				$languages = !empty($_POST['languages']) ? $_POST['languages'] : 'fra/Français/accueil;nld/Nederlands/home';


				$languages = explode(';', $languages);
				$availableLanguages = array();
				$homepages = array();
				foreach ($languages as $language) {
					$vars = explode('/', $language);
					$availableLanguages[$vars[0]] = $vars[1];
					$homepages[$vars[0]] = $vars[2];
				}
				$file = "<?php\nConfigure::write('Config', array(\n	'defaultLanguage' => '".$defaultLanguage."',\n	'languages' => array(";
				foreach ($availableLanguages as $code => $language) {
					$file .= "'".$code."' => '".$language."', ";
				}
				$file .= "),\n	'themes' => array('admin' => null, 'front' => null),\n	'homepages' => array(";
				foreach ($homepages as $code => $page) {
					$file .= "'".$code."' => '".$page."', ";
				}
				$file .= "),\n));";
				if (file_put_contents('../Config/config.php', $file)) {
					$_SESSION['step'] = 4;
					$_SESSION['config']['defaultLanguage'] = $defaultLanguage;
					$_SESSION['config']['languages'] = $availableLanguages;
					$_SESSION['config']['homepages'] = $homepages;
					$_SESSION['config']['title'] = $title;
					$_SESSION['config']['baseline'] = $baseline;
					$_SESSION['config']['contact'] = $contact;
					header('location: install.php');
				} else {
					$error = 'Impossible to write file app/Config/config.php';
				}
			}
			break;

		case 4:
			if (!empty($_POST)) {
				$mysqli = new mysqli($_SESSION['database']['host'], $_SESSION['database']['user'], $_SESSION['database']['pass'], $_SESSION['database']['name']);
				$mysqli->query("SET NAMES 'UTF8';");
				$mysqli->query("CREATE TABLE IF NOT EXISTS `bookings` (`id` int(11) NOT NULL AUTO_INCREMENT, `from` date NOT NULL, `to` date NOT NULL, `full` tinyint(1) NOT NULL, `details` text, `created` datetime NOT NULL, `modified` datetime NOT NULL, PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");
				$mysqli->query("CREATE TABLE IF NOT EXISTS `configs` (`id` int(11) NOT NULL AUTO_INCREMENT, `name` varchar(50) NOT NULL, `value` varchar(200) DEFAULT NULL, PRIMARY KEY (id)) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");
				$mysqli->query("CREATE TABLE IF NOT EXISTS `contacts` (`id` int(11) NOT NULL AUTO_INCREMENT, `type` varchar(10) NOT NULL DEFAULT 'contact', `name` varchar(150) NOT NULL, `email` varchar(100) NOT NULL, `subject` varchar(100) NOT NULL, `text` text NOT NULL, `created` datetime NOT NULL, `modified` datetime NOT NULL, PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");
				$mysqli->query("CREATE TABLE IF NOT EXISTS `i18n` (`id` int(10) NOT NULL AUTO_INCREMENT, `locale` varchar(6) NOT NULL, `model` varchar(255) NOT NULL, `foreign_key` int(10) NOT NULL, `field` varchar(255) NOT NULL, `content` text, PRIMARY KEY (id)) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");
				$mysqli->query("CREATE TABLE IF NOT EXISTS `posts` (`id` int(11) NOT NULL AUTO_INCREMENT, `type` varchar(10) NOT NULL, `title` varchar(150) DEFAULT NULL, `slug` varchar(150) DEFAULT NULL, `content` text NOT NULL, `order` int(11) DEFAULT NULL, `online` tinyint(1) NOT NULL DEFAULT '0', `parent_id` int(11) DEFAULT NULL, `lft` int(11) NOT NULL, `rght` int(11) NOT NULL, `created` datetime NOT NULL, `modified` datetime NOT NULL, PRIMARY KEY (id)) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");
				$mysqli->query("INSERT INTO `configs` (`name`, `value`) VALUES ('title', '".$_SESSION['config']['title']."')");
				$mysqli->query("INSERT INTO `configs` (`name`, `value`) VALUES ('baseline', '".$_SESSION['config']['baseline']."')");
				$mysqli->query("INSERT INTO `configs` (`name`, `value`) VALUES ('contact_email', '".$_SESSION['config']['contact']."')");
				$mysqli->query("INSERT INTO `configs` (`name`, `value`) VALUES ('google_tracking_id', '');");
				$mysqli->query("INSERT INTO `posts` (`type`, `title`, `slug`, `content`, `order`, `online`, `parent_id`, `lft`, `rght`, `created`, `modified`) VALUES ('page', 'Pages', 'pages', '<p>Contenu</p>', NULL, 1, 0, 1, 4, '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."');");
				$mysqli->query("INSERT INTO `posts` (`type`, `title`, `slug`, `content`, `order`, `online`, `parent_id`, `lft`, `rght`, `created`, `modified`) VALUES ('page', '".ucfirst($_SESSION['config']['homepages'][$_SESSION['config']['defaultLanguage']])."', '".$_SESSION['config']['homepages'][$_SESSION['config']['defaultLanguage']]."', '<p>Homepage content</p>', 1, 1, 1, 2, 3, '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."');");
				foreach ($_SESSION['config']['languages'] as $code => $language) {
					$mysqli->query("INSERT INTO `i18n` (`locale`, `model`, `foreign_key`, `field`, `content`) VALUES ('".$code."', 'Config', 1, 'value', '".$_SESSION['config']['title']."')");
					$mysqli->query("INSERT INTO `i18n` (`locale`, `model`, `foreign_key`, `field`, `content`) VALUES ('".$code."', 'Config', 2, 'value', '".$_SESSION['config']['baseline']."')");
					$mysqli->query("INSERT INTO `i18n` (`locale`, `model`, `foreign_key`, `field`, `content`) VALUES ('".$code."', 'Config', 3, 'value', '".$_SESSION['config']['contact_email']."')");
					$mysqli->query("INSERT INTO `i18n` (`locale`, `model`, `foreign_key`, `field`, `content`) VALUES ('".$code."', 'Config', 4, 'value', '');");
					$mysqli->query("INSERT INTO `i18n` (`locale`, `model`, `foreign_key`, `field`, `content`) VALUES ('".$code."', 'Post', 1, 'title', 'Pages')");
					$mysqli->query("INSERT INTO `i18n` (`locale`, `model`, `foreign_key`, `field`, `content`) VALUES ('".$code."', 'Post', 1, 'slug', 'pages')");
					$mysqli->query("INSERT INTO `i18n` (`locale`, `model`, `foreign_key`, `field`, `content`) VALUES ('".$code."', 'Post', 1, 'content', '');");
					$mysqli->query("INSERT INTO `i18n` (`locale`, `model`, `foreign_key`, `field`, `content`) VALUES ('".$code."', 'Post', 2, 'title', '".ucfirst($_SESSION['config']['homepages'][$code])."')");
					$mysqli->query("INSERT INTO `i18n` (`locale`, `model`, `foreign_key`, `field`, `content`) VALUES ('".$code."', 'Post', 2, 'slug', '".$_SESSION['config']['homepages'][$code]."')");
					$mysqli->query("INSERT INTO `i18n` (`locale`, `model`, `foreign_key`, `field`, `content`) VALUES ('".$code."', 'Post', 2, 'content', '<p>Homepage content</p>');");
				}
				$mysqli->close();
				$_SESSION['step'] = 5;
				header('location: install.php');
			}
			break;

		default:
			# code...
			break;
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Gîte CMS install</title>
	<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="/css/bootstrap-theme.min.css" />
	<link rel="stylesheet" type="text/css" href="/css/admin_styles.css" />
</head>
<body>
	<div class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="/install.php" class="navbar-brand">Gîte CMS - Installation</a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li><a href="https://github.com/tomdoo/gite-cms" target="blank">GitHub</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="container">
		<?php if (!empty($error)) : ?>
			<p class="text-danger"><?php echo $error; ?></p>
		<?php endif; ?>
		<?php if (empty($step)) : ?>
			<h1>Welcome!</h1>
			<p>This process helps you to install Gîte CMS.</p>
			<a href="?start" class="btn btn-primary">Start installation</a>
		<?php elseif ($step == 1) : ?>
			<h2>Step 1 : Check some file perms</h2>
			<form class="form-horizontal" method="post" action="install.php">
				<div class="form-group">
					<div class="col-sm-10">
						<button name="check" type="submit" class="btn btn-primary">Check</button>
					</div>
				</div>
			</form>
		<?php elseif ($step == 2) : ?>
			<h1>Step 2 : MySQL Database connection</h1>
			<form class="form-horizontal" method="post" action="install.php">
				<div class="form-group">
					<label for="host" class="col-sm-2 control-label">Host</label>
					<div class="col-sm-10">
						<input name="host" type="text" class="form-control" id="host" placeholder="localhost">
					</div>
				</div>
				<div class="form-group">
					<label for="user" class="col-sm-2 control-label">User</label>
					<div class="col-sm-10">
						<input name="user" type="text" class="form-control" id="user" placeholder="root">
					</div>
				</div>
				<div class="form-group">
					<label for="pass" class="col-sm-2 control-label">Password</label>
					<div class="col-sm-10">
						<input name="pass" type="text" class="form-control" id="pass">
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">Database</label>
					<div class="col-sm-10">
						<input name="name" type="text" class="form-control" id="name" placeholder="gitecms">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-primary">Connect</button>
					</div>
				</div>
			</form>
		<?php elseif ($step == 3) : ?>
			<h1>Step 3 : Generate configuration file</h1>
			<form class="form-horizontal" method="post" action="install.php">
				<div class="form-group">
					<label for="title" class="col-sm-2 control-label">Site title</label>
					<div class="col-sm-10">
						<input name="title" type="text" class="form-control" id="title" placeholder="My famous Gite">
					</div>
				</div>
				<div class="form-group">
					<label for="baseline" class="col-sm-2 control-label">Baseline</label>
					<div class="col-sm-10">
						<input name="baseline" type="text" class="form-control" id="baseline" placeholder="The cutest gite all around the world!">
					</div>
				</div>
				<div class="form-group">
					<label for="contact" class="col-sm-2 control-label">Contact email</label>
					<div class="col-sm-10">
						<input name="contact" type="text" class="form-control" id="contact" placeholder="contact@me.com">
					</div>
				</div>
				<div class="form-group">
					<label for="dl" class="col-sm-2 control-label">Default language</label>
					<div class="col-sm-10">
						<input name="dl" type="text" class="form-control" id="dl" placeholder="fra">
					</div>
				</div>
				<div class="form-group">
					<label for="languages" class="col-sm-2 control-label">Languages</label>
					<div class="col-sm-10">
						<input name="languages" type="text" class="form-control" id="languages" placeholder="fra/Français/accueil;nld/Nederlands/home">
						<span class="help-block">Example: "fra/Français/accueil;nld/Nederlands/home;eng/English/home"</span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-primary">Generate</button>
					</div>
				</div>
			</form>
		<?php elseif ($step == 4) : ?>
			<h2>Step 4 : Create default data</h2>
			<form class="form-horizontal" method="post" action="install.php">
				<div class="form-group">
					<div class="col-sm-10">
						<button name="create" type="submit" class="btn btn-primary">Create</button>
					</div>
				</div>
			</form>
		<?php elseif ($step == 5) : ?>
			<h2>Step 5 : End</h2>
			<p>Installation completed.</p>
			<a href="/" class="btn btn-primary">See my website now!</a>
		<?php endif; ?>
	</div>
	<script type="text/javascript" src="/js/jquery.min.js"></script>
	<script type="text/javascript" src="/js/jquery.form.min.js"></script>
	<script type="text/javascript" src="/js/bootstrap.min.js"></script>
</body>
</html>