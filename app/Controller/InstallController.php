<?php
class InstallController extends AppController {
	public $layout = 'install';
	public function index() {
		$steps = array();

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
			'title' => 'Create database file',
			'text' => '<p>Copy <em>/app/Config/database.php.default</em> to <em>/app/Config/database.php</em></p>',
			'status' => file_exists(ROOT.DS.APP_DIR.DS.'Config'.DS.'database.php') ? 'success' : 'danger',
		);

		$db = $this->getDataSource();
		die();
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
		$error = false;
		if ($this->$query
		
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