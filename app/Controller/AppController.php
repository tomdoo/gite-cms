<?php
class AppController extends Controller {
	public $components = array(
		'DebugKit.Toolbar' => array(),
		'Session',
	);
	public $uses = array('Config');

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
			if (Configure::check('Config.themes.'.$this->request->params['prefix'])) {
				$this->theme = Configure::read('Config.themes.'.$this->request->params['prefix']);
			}
		}
	}

	public function beforeRender() {
		parent::beforeRender();

		$this->set('title_for_layout', $this->Config->getValue('title'));
		$this->set('baseline', $this->Config->getValue('baseline'));
		$this->set('language', Configure::read('Config.language'));
	}

	private function _setLanguage() {
		// admin : default language
		if (!empty($this->request->params['prefix'])) {
			if ($this->request->params['prefix'] == 'admin') {
				Configure::write('Config.language', Configure::read('Config.defaultLanguage'));
				$this->Session->write('User.language', Configure::read('Config.defaultLanguage'));
				return;
			}
		}
		// install : default language
		if (!empty($this->request->params['controller'])) {
			if ($this->request->params['controller'] == 'install') {
				Configure::write('Config.language', Configure::read('Config.defaultLanguage'));
				$this->Session->write('User.language', Configure::read('Config.defaultLanguage'));
				return;
			}
		}
		// other : params['language'] / session['User.language'] / config['Config.defaultLanguage']
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