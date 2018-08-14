<?php
App::uses('AppController', 'Controller');
class UsersController extends AppController {
	public $helpers = array('Html', 'Form', 'Flash');
	public $components = array('Flash');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(['register','login','logout','update']);
	}

	public function index($param){
		if($this->Session->check('User.id')){
			$this->loadModel('Application');
			$loggedin = $this->Session->read('User.id');
			$user = $this->User->findById($loggedin);
			$applications = $this->Application->find('all');
			$this->set(compact('applications','user'));
			$this->viewPath = "/Pages/";
		}
	}

	public function register(){
		if ($this->request->is('post')) {
			if(! empty($this->data)) {
				if($this->User->validates()){
					$user = $this->User->findByEmail($this->data['User']['email']);

					if(empty( $user['User']['email'] )) {
						$this->User->create();
						if ($this->User->save($this->request->data)) {
							$this->Flash->success(__('Successfully registered.'));
							return $this->redirect('/');
						}
						$this->Flash->error(__('Unable to register.'));
					} else {
						throw new ExistingEmailException();
					}
				} else {
					$errors = $this->User->invalidFields();
				}
			}
		}
	}

	public function login(){
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$user = $this->User->findByEmail($this->data['User']['email']);
				$this->Session->write('User.id', $user['User']['id']);
				return $this->redirect(array('controller' => 'users','action' => 'index',0));
			} else {
				$this->Flash->error(__('Username or password is incorrect'));
			}
		}
	}

	public function logout(){
		$this->Auth->logout();
		return $this->redirect('/');
	}

	public function updateProfile() {
		if($this->Session->check('User.id')){
			$userId = $this->Session->read('User.id');
			$this->set('userId',$userId);
			if (!$userId) {
				$this->Session->setFlash('Please provide a user id');
				$this->redirect(array('action'=>'index',0));
			}

			$user = $this->User->findById($userId);
			if (!$user) {
				$this->Session->setFlash('Invalid User ID Provided');
				$this->redirect(array('action'=>'index',0));
			}

			if ($this->request->is('put')) {
				$this->User->id = $this->loggedin;
				if ($this->User->save($this->request->data)) {
					$this->Session->setFlash(__('The user has been updated'));
					$this->redirect(array('action' => 'updateProfile'));
				}else{
					$this->Session->setFlash(__("Unable to update your user's profile."));
				}
			}

			if (!$this->request->data) {
				$this->request->data = $user;
			}

		}
	}

	public function updatePassword(){
		if($this->Session->check('User.id')){
			$userId = $this->Session->read('User.id');
			$this->set('userId',$userId);
			$this->updateProfile();
		}
	}
}
?>