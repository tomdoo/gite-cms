<?php
class TranslationsController extends AppController {
	public $uses = array('Translation');

	public function beforeRender() {
		parent::beforeRender();
		$this->set('model', 'View');
		$this->set('foreign_key', 0);
	}

	public function admin_index() {
		$translations = $this->Translation->findAllByLocaleAndModel(Configure::read('Config.language'), 'View');
		$this->set('translations', $translations);
	}

	public function admin_edit($id = null) {
		if ($this->request->is('put') || $this->request->is('post')) {
			if ($this->Translation->save($this->request->data)) {
				$this->Session->setFlash('The translation has been saved', 'success');
				return $this->redirect('/admin/translations');
			} else {
				$this->Session->setFlash('Some errors occured', 'error');
			}
		}

		$pageTitle = 'Create translation';
		if(!empty($id)) {
			$translation = $this->Translation->findById($id);
			$pageTitle = 'Edit translation <small>'.$translation['Translation']['field'].'</small>';
			if (empty($this->request->data['Translation']) && !empty($translation)) {
				$this->request->data['Translation'] = $translation['Translation'];
			}
		}

		$this->set('pageTitle', $pageTitle);
		$this->set('locale', Configure::read('Config.language'));
	}

	public function admin_translate($id, $language = null) {
		$translationOrigin = $this->Translation->findById($id);
		if (empty($language)) {
			$this->set('selectLanguage', true);
			$this->set('languages', Configure::read('Config.languages'));
		} else {
			$this->set('selectedLocale', $language);
			if ($this->request->is('put') || $this->request->is('post')) {
				if ($this->Translation->save($this->request->data)) {
					$this->Session->setFlash('The translation has been saved', 'success');
					return $this->redirect('/admin/translations');
				} else {
					$this->Session->setFlash('Some errors occured', 'error');
				}
			}

			if ($translation = $this->Translation->findByLocaleAndModelAndField($language, 'View', $translationOrigin['Translation']['field'])) {
				$this->request->data['Translation'] = $translation['Translation'];
			} else {
				$this->request->data['Translation']['field'] = $translationOrigin['Translation']['field'];
			}
		}

		$this->set('translationOrigin', $translationOrigin);
		$this->set('pageTitle', 'Translate configuration <small>'.$translationOrigin['Translation']['field'].' - '.Configure::read('Config.languages.'.$language).'</small>');
	}
}