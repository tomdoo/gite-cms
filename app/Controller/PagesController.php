<?php
class PagesController extends AppController {
	public $uses = array('Post');

	public function menu() {
		$pages = $this->Post->getPagesTree(1, false);
		return $pages;
	}

	public function index() {
		$pages = $this->Post->getPagesTree();
		$this->set('pages', $pages);
	}

	public function show($slug = null) {
		if (empty($slug)) {
			$slug = Configure::read('Config.homepages.'.Configure::read('Config.language'));
		}
		if (!$page = $this->Post->getPageBySlug($slug)) {
			throw new NotFoundException();
		}
		$this->set('page', $page);
		$this->set('page_title', $page['Post']['title']);
		if (Configure::read('Config.homepages.'.Configure::read('Config.language')) == $slug) {
			$this->set('page_homepage', true);
		}
	}

	public function admin_index() {
		$pages = $this->Post->getPagesTree();
		$this->set('pages', $pages);
	}

	public function admin_edit($id = null) {
		if ($this->request->is('put') || $this->request->is('post')) {
			if ($this->Post->save($this->request->data)) {
				$this->Session->setFlash('The page has been saved', 'success');
				return $this->redirect('/admin/pages');
			} else {
				$this->Session->setFlash('Some errors occured', 'error');
			}
		}

		$pageTitle = 'Create page';
		if(!empty($id)) {
			$page = $this->Post->findById($id);
			$pageTitle = 'Edit page <small>'.$page['Post']['title'].'</small>';
			if (empty($this->request->data['Post']) && !empty($page)) {
				$this->request->data['Post'] = $page['Post'];
			}
		}

		$parentPages = $this->Post->generateTreeList();
		$this->set('parentPages', $parentPages);

		$this->set('pageTitle', $pageTitle);
	}

	public function admin_translate($id, $language = null) {
		if (empty($language)) {
			$this->set('selectLanguage', true);
			$this->set('languages', Configure::read('Config.languages'));
		} else {
			$this->Post->locale = $language;
			if ($this->request->is('put') || $this->request->is('post')) {
				if ($this->Post->save($this->request->data)) {
					$this->Session->setFlash('The translation has been saved', 'success');
					return $this->redirect('/admin/pages');
				} else {
					$this->Session->setFlash('Some errors occured', 'error');
				}
			}

			if ($page = $this->Post->find('first', array('conditions' => array('Post.id' => $id)))) {
				$this->request->data['Post'] = $page['Post'];
			} else {
				$this->request->data['Post']['id'] = $id;
			}
		}

		$this->Post->locale = Configure::read('Config.defaultLanguage');
		$pageOrigin = $this->Post->findById($id);
		$this->set('pageOrigin', $pageOrigin);
		$this->set('pageTitle', 'Translate page <small>'.$pageOrigin['Post']['title'].' - '.Configure::read('Config.languages.'.$language).'</small>');
	}

	public function admin_delete($id) {
		if ($this->Post->delete($id)) {
			$this->Session->setFlash('The page has been deleted', 'success');
		} else {
			$this->Session->setFlash('The page hasn\'t been deleted', 'error');
		}
		return $this->redirect($this->referer());
	}
}