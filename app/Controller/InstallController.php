<?php
class InstallController extends AppController {
	public $layout = 'install';
	public $uses = array('Post', 'Contact', 'Booking', 'Config', 'Toto');

	public function index($install = null, $sql = null) {
		if ($sql == 'sql') {
			if (Configure::check('Config.defaultLanguage')) {
				$this->set('defaultLanguage', Configure::read('Config.defaultLanguage'));
			}
			$this->set('showSql', true);
		} else {
			$steps = array();

			// check file perms
			$folders = array(
				ROOT.DS.APP_DIR.DS.'webroot'.DS.'files'.DS.'uploads',
				ROOT.DS.APP_DIR.DS.'webroot'.DS.'files'.DS.'thumbs',
				ROOT.DS.APP_DIR.DS.'tmp',
				ROOT.DS.APP_DIR.DS.'tmp'.DS.'cache',
				ROOT.DS.APP_DIR.DS.'tmp'.DS.'cache'.DS.'models',
				ROOT.DS.APP_DIR.DS.'tmp'.DS.'cache'.DS.'persistent',
				ROOT.DS.APP_DIR.DS.'tmp'.DS.'cache'.DS.'views',
				ROOT.DS.APP_DIR.DS.'tmp'.DS.'logs',
				ROOT.DS.APP_DIR.DS.'tmp'.DS.'sessions',
				ROOT.DS.APP_DIR.DS.'tmp'.DS.'tests',
			);
			foreach ($folders as $folder) {
				if (!is_writable($folder)) {
					$error = '<p>Are you sure this files are writeable ?</p><ul><li>'.implode('</li><li>', $folders).'</li></ul>';
				}
			}
			$steps[] = array(
				'title' => 'Check file permissions',
				'text' => empty($error) ? '' : $error,
				'status' => empty($error) ? 'success' : 'danger',
			);

			// create config file
			$steps[] = array(
				'title' => 'Create config file',
				'text' => '<p>Copy <em>/app/Config/config.php.default</em> to <em>/app/Config/config.php</em></p>',
				'status' => file_exists(ROOT.DS.APP_DIR.DS.'Config'.DS.'config.php') ? 'success' : 'danger',
			);
			
			// check config
			$steps[] = array(
				'title' => 'Complete config file',
				'text' => '<p>The minimal config file must contains following params (have a look to config.php.default) :</p>
					<ul>
						<li>install</li>
						<li>paths</li>
						<li>defaultLanguage</li>
						<li>languages</li>
						<li>homepages</li>
					</ul>',
				'status' => (
					Configure::check('Config.install')
					&& Configure::check('Config.paths')
					&& Configure::check('Config.defaultLanguage')
					&& Configure::check('Config.languages')
					&& Configure::check('Config.homepages')) ? 'success' : 'danger',
			);

			// create database file
			$steps[] = array(
				'title' => 'Create email file',
				'text' => '<p>Copy <em>/app/Config/email.php.default</em> to <em>/app/Config/email.php</em></p>',
				'status' => file_exists(ROOT.DS.APP_DIR.DS.'Config'.DS.'email.php') ? 'success' : 'danger',
			);
			
			// create database file
			$steps[] = array(
				'title' => 'Create database file',
				'text' => '<p>Copy <em>/app/Config/database.php.default</em> to <em>/app/Config/database.php</em></p>',
				'status' => file_exists(ROOT.DS.APP_DIR.DS.'Config'.DS.'database.php') ? 'success' : 'danger',
			);

			// connect database file
			$message = null;
			App::uses('ConnectionManager', 'Model');
			try {
				$cm = ConnectionManager::getDataSource('default');
			} catch (CakeException $e) {
				$message = $e->getMessage();
			}
			$steps[] = array(
				'title' => 'Connect to database',
				'text' => '<p>'.$message.'</p>',
				'status' => empty($message) ? 'success' : 'danger',
			);

			// default data check
			$errors = array();
			try {
				$this->Booking->create();
				foreach (array('id', 'from', 'to', 'full', 'details', 'created', 'modified') as $field) {
					if (!in_array($field, array_keys($this->Booking->schema()))) {
						throw new CakeException('Missing field Booking.'.$field);
					}
				}
			} catch (CakeException $e) {
				$errors[] = $e->getMessage();
			}
			try {
				$this->Config->create();
				foreach (array('id', 'name', 'value') as $field) {
					if (!in_array($field, array_keys($this->Config->schema()))) {
						throw new CakeException('Missing field Config.'.$field);
					}
				}
				if (!$config = $this->Config->find('first', array('conditions' => array('Config.name' => 'title')))) {
					throw new CakeException('The Config "title" is missing');
				}
				if (!$config = $this->Config->find('first', array('conditions' => array('Config.name' => 'baseline')))) {
					throw new CakeException('The Config "baseline" is missing');
				}
				if (!$config = $this->Config->find('first', array('conditions' => array('Config.name' => 'google_tracking_id')))) {
					throw new CakeException('The Config "google_tracking_id" is missing');
				}
				if (!$config = $this->Config->find('first', array('conditions' => array('Config.name' => 'contact_email')))) {
					throw new CakeException('The Config "contact_email" is missing');
				}
			} catch (CakeException $e) {
				$errors[] = $e->getMessage();
			}
			try {
				$this->Contact->create();
				foreach (array('id', 'type', 'name', 'email', 'subject', 'text', 'created', 'modified') as $field) {
					if (!in_array($field, array_keys($this->Contact->schema()))) {
						throw new CakeException('Missing field Contact.'.$field);
					}
				}
			} catch (CakeException $e) {
				$errors[] = $e->getMessage();
			}
			try {
				$this->Post->create();
				foreach (array('id', 'type', 'title', 'slug', 'content', 'order', 'online', 'parent_id', 'lft', 'rght', 'created', 'modified') as $field) {
					if (!in_array($field, array_keys($this->Post->schema()))) {
						throw new CakeException('Missing field Post.'.$field);
					}
				}
				if (!$post = $this->Post->find('first', array('conditions' => array('Post.id' => 1)))) {
					throw new CakeException('The first post was not found, this one is used as the parent off all the posts');
				}
			} catch (CakeException $e) {
				$errors[] = $e->getMessage();
			}
			$steps[] = array(
				'title' => 'Database check',
				'text' => 'See the initial import request : <a href="/install/sql" target="blank">go !</a><ul><li>'.implode('</li><li>', $errors).'</li></ul>',
				'status' => empty($errors) ? 'success' : 'danger',
			);
			
			// end of installation process
			$success = 0;
			$total = 0;
			foreach ($steps as $step) {
				if ($step['status'] == 'success') {
					$success++;
				}
				$total++;
			}
			$this->set('steps', $steps);
			$this->set('progression', CakeNumber::precision($success*100/$total, 2));
		}
	}
}