<?php
class AppController extends Controller {
	public $components = array(
		'DebugKit.Toolbar' => array(),
		'Session',
	);

	public function beforeFilter() {
		if (!empty($this->request->params['prefix'])) {
			$this->layout = $this->request->params['prefix'];
			if ($this->request->params['prefix'] == 'admin') {
				if (Configure::check('Config.defaultLanguage')) {
					Configure::write('Config.language', Configure::read('Config.defaultLanguage'));
				}
			}
		}
	}
}