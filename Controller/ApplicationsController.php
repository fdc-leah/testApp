<?php
App::uses('AppController', 'Controller');
class ApplicationsController extends AppController {
	public $helpers = array('Html', 'Form', 'Flash');
	public $components = array('Flash');

	public $uses = array('User','AppCategory','Comment','Application');


	public function addApplication(){
		$this->loadModel('Category');
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

				// check first if user selected categories
				$errors = array_filter($appCategData);
				if (empty($errors)){
					$this->Session->setFlash(__("Please select one or more categories"));
					return;
				}

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
					$this->Session->setFlash(__("Unable to save your application."));
				}
			}
		}
	}

	public function viewApplication($appId){
		$this->loadModel('Category');
		$application = $this->Application->findById($appId);
		$appCategories = $this->Category->getAppCategories($application);
		$appComments = $this->Comment->getAppComments($appId);
		$userId = $this->Session->read('User.id');
		$this->set(compact('appCategories','application', 'userId','appComments'));

		if($this->request->is('post')){
			if( $this->Comment->submitComment($this->request->data)){
				$this->redirect(array('action' => 'viewApplication', $appId));
			}
		}
	}

	public function updateApplication($appId){
		$this->loadModel('Category');
		$userId = $this->Session->read('User.id');
		$application = $this->Application->findById($appId);
		$selectedCategories = $this->AppCategory->getAppCategoriesByAppId($application);
		$categories = $this->Category->find('list', array( 'fields' => array('Category.category')));

		// if logged in user is not the owner, redirect to index
		if($userId != $application['Application']['user_id']){
			$this->Session->setFlash('Invalid action');
			return $this->redirect(array('controller' => 'pages','action' => 'index'));
		}

		$this->set(compact('appId', 'userId','selectedCategories','categories'));
		if (!$this->request->data) {
			$this->request->data['AppCategory']['category'] = $selectedCategories;
			$this->request->data['Application'] = $application['Application'];
		}

		if ($this->request->is('put')) {
			$appData['Application'] = $this->request->data['Application'];
			$appCategData = $this->request->data['AppCategory'];

			// check first if user selected categories
			$errors = array_filter($appCategData);
			if (empty($errors)){
				$this->Session->setFlash(__("Please select one or more categories"));
				return;
			}

			if ($this->Application->add($appData)) {
				if($this->AppCategory->update($appCategData,$this->request->data['Application']['id'])){
					$this->Session->setFlash(__('Successfully updated the application'));
					$this->redirect(array('controller' => 'pages','action' => 'index', '0'));
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