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
		$appCategories = $this->Category->getAppCategory($application);
		$userId = $this->Session->read('User.id');
		$this->set(compact('appCategories','application', 'userId'));
	}
}
?>