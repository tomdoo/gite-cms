<?php
class AppController extends Controller {
	public $components = array(
		'DebugKit.Toolbar' => array(),
		'Session',
	);

	public function beforeFilter() {
		parent::beforeFilter();
		$this->_setLanguage();

		// front theme
		if (Configure::check('Config.themes.front')) {
			$this->theme = Configure::read('Config.themes.front');
		}

		// prefixes
		if (!empty($this->request->params['prefix'])) {
			$this->layout = $this->request->params['prefix'];
			if ($this->request->params['prefix'] == 'admin') {
				// admin uses default language only
				if (Configure::check('Config.defaultLanguage')) {
					Configure::write('Config.language', Configure::read('Config.defaultLanguage'));
				}
				// admin theme
				if (Configure::check('Config.themes.'.$this->request->params['prefix'])) {
					$this->theme = Configure::read('Config.themes.'.$this->request->params['prefix']);
				}
			}
		}
	}

	private function _setLanguage() {
		if (!empty($this->params['language'])) {
			Configure::write('Config.language', $this->params['language']);
			$this->Session->write('User.language', $this->params['language']);
		} else {
			if ($this->Session->check('User.language')) {
				Configure::write('Config.language', $this->Session->read('User.language'));
			} else {
				if (!Configure::check('Config.language')) {
					Configure::write('Config.language', Configure::read('Config.defaultLanguage'));
				}
				$this->Session->write('User.language', Configure::read('Config.language'));
			}
			$this->params['language'] = Configure::read('Config.language');
		}
	}
}