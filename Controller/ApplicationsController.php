<?php
App::uses('AppController', 'Controller');
class ApplicationsController extends AppController {
	public $helpers = array('Html', 'Form', 'Flash');
	public $components = array('Flash');

	public function addApplication(){
		$this->loadModel('Category');
		$this->loadModel('User');
		if($this->Session->check('User.id')) {
			$userId = $this->Session->read('User.id');
			$user = $this->User->findById($userId);
			$categories = $this->Category->find('list',
				array( 'fields' => array('Category.category')));
			if (!$this->request->data) {
				$this->request->data = $user;
			}
			$this->set(compact('categories','userId'));

			if ($this->request->is('post')) {
				$appData['Application'] = $this->request->data['Application'];
				$appCategData = $this->request->data['AppCategory'];

				// save application
				if ($this->Application->add($appData)) {

					// once saved, get its id.
					$lastId = $this->Application->id;

					// save app's category.
					$this->loadModel('AppCategory');
			    	if($this->AppCategory->add($appCategData,$lastId)){
						$this->Session->setFlash(__('Successfully added new application'));
						$this->redirect(array('controller' => 'users','action' => 'index', '0'));
			    	}
				}else{
					$this->Session->setFlash(__("Unable to update your user's profile."));
				}
			}
		}
	}

	public function viewApplication($appId){
		$this->loadModel('Category');
		$this->loadModel('User');
		$application = $this->Application->findById($appId);
		$appCategories = $this->Category->getAppCategories($application);
		$userId = $this->Session->read('User.id');
		$this->set(compact('appCategories','application', 'userId'));
	}

	public function updateApplication($appId){
		$this->loadModel('Category');
		$this->loadModel('AppCategory');
		$userId = $this->Session->read('User.id');
		$application = $this->Application->findById($appId);
		$selectedCategories = $this->AppCategory->getAppCategoriesByAppId($application);
		$categories = $this->Category->find('list', array( 'fields' => array('Category.category')));

		// if logged in user is not the owner, redirect to index
		if($userId != $application['Application']['user_id']){
			$this->Session->setFlash('Invalid action');
			return $this->redirect(array('controller' => 'users','action' => 'index',0));
		}

		$this->set(compact('appId', 'userId','selectedCategories','categories'));
		if (!$this->request->data) {
			$this->request->data['AppCategory']['category'] = $selectedCategories;
			$this->request->data['Application'] = $application['Application'];
		}

		if ($this->request->is('put')) {
			$appData['Application'] = $this->request->data['Application'];
			$appCategData = $this->request->data['AppCategory'];

			if ($this->Application->add($appData)) {
				if($this->AppCategory->update($appCategData,$this->request->data['Application']['id'])){
					$this->Session->setFlash(__('Successfully updated the application'));
					$this->redirect(array('controller' => 'users','action' => 'index', '0'));
				} else {
					$this->Session->setFlash(__("Unable to update your application."));
				}
			}else{
				$this->Session->setFlash(__("Unable to update your application."));
			}
		}

	}
}
?>