<?php
class ConfigurationController extends AppController {
	public $uses = array('Config');

	public function languages() {
		if (Configure::check('Config.languages')) {
			return Configure::read('Config.languages');
		}
	}

	public function admin_index() {
		$configs = $this->Config->find('all');
		$this->set('configs', $configs);
	}

	public function admin_translate($id, $language = null) {
		if (empty($language)) {
			$this->set('selectLanguage', true);
			$this->set('languages', Configure::read('Config.languages'));
		} else {
			$this->Config->locale = $language;
			if ($this->request->is('put') || $this->request->is('post')) {
				if ($this->Config->save($this->request->data)) {
					$this->Session->setFlash('The translation has been saved', 'success');
					return $this->redirect('/admin/configuration');
				} else {
					$this->Session->setFlash('Some errors occured', 'error');
				}
			}

			if ($config = $this->Config->find('first', array('conditions' => array('Config.id' => $id)))) {
				$this->request->data['Config'] = $config['Config'];
			} else {
				$this->request->data['Config']['id'] = $id;
			}
		}

		$this->Config->locale = Configure::read('Config.defaultLanguage');
		$configOrigin = $this->Config->findById($id);
		$this->set('configOrigin', $configOrigin);
		$this->set('pageTitle', 'Translate configuration <small>'.$configOrigin['Config']['name'].' - '.Configure::read('Config.languages.'.$language).'</small>');
	}
}