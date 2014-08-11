<?php
class ContactsController extends AppController {
	public $uses = array('Contact');
	public $components = array('Emailing');

	public function index() {
		if ($this->request->is('post')) {
			$this->request->data['Contact']['type'] = 'contact';
			if ($this->Contact->save($this->request->data)) {
				$this->Emailing->contact($this->Config->getValue('contact_email'), $this->request->data['Contact']);
				return $this->redirect(array('action' => 'end'));
			} else {
				$this->Session->setFlash('Some errors occured', 'error');
			}
		}
	}

	public function end() {
	}

	public function admin_index() {
		$contacts = $this->Paginate('Contact');
		$this->set('contacts', $contacts);
	}

	public function admin_show($id = null) {
		if (!$contact = $this->Contact->getContactById($id)) {
			return $this->redirect('/admin/contacts');
		}
		$this->set('contact', $contact);
	}

	public function admin_delete($id) {
		if ($this->Contact->delete($id)) {
			$this->Session->setFlash('The contact has been deleted', 'success');
		} else {
			$this->Session->setFlash('The contact hasn\'t been deleted', 'error');
		}
		return $this->redirect($this->referer());
	}
}