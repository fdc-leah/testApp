<?php
App::uses('AppController', 'Controller');
class ApplicationsController extends AppController {
	public $helpers = array('Html', 'Form', 'Flash','Js' => array('Jquery'));
	public $uses = array('User','AppCategory','Comment','Application','AppFile', 'Category');
	public $paginate = array(
		'Application' => array(
			'limit' => 5,
			'order' => array('modified' => 'desc')
		)
	);
	public function index() {
		if($this->Session->check('User.id')){
			$loggedin = $this->Session->read('User.id');
			$user = $this->User->findById($loggedin);
			$applications = $this->paginateApp($this->params['url']);
			$categories = $this->Category->find('all');
			$this->set(compact('applications','user','categories'));
		} else {
			$this->redirect(array('controller' => 'users','action' => 'login'));
		}
	}

	public function applications(){
		$data = $this->paginateApp($this->params['url']);
		pr(json_encode($data));
		return json_encode($data);
	}

	public function paginateApp($params){
		$category = isset($params['category']) ? $params['category'] : null;

       	$this->Application->recursive = -1;

        if ($category != null) {
			$this->paginate['Application']['joins'] = array('Join app_categories as AppCategory on Application.id = AppCategory.application_id');
			$this->paginate['Application']['conditions'] = array('AppCategory.category_id = '.$category);
        }

	    $this->Paginator->settings = $this->paginate;
    	$result = $this->Paginator->paginate('Application');
    	return $result;
	}

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

				// check first if user have selected categories
				$appCategoryErrors = array_filter($appCategData);
				if (empty($appCategoryErrors)){
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
						$this->redirect(array('controller' => 'appFiles','action' => 'uploadFile', $lastId));
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
		$image = $this->AppFile->getCurrentFile($appId);
		$filePath = $this->webroot.'appfiles/'.$image;
		$userId = $this->Session->read('User.id');
		$this->set(compact('appCategories','application', 'userId','appComments','filePath'));

		// comment
		if($this->request->is('post')){
			if( $this->Comment->submitComment($this->request->data)){
				$this->redirect(array('action' => 'viewApplication', $appId));
			} else {
				$this->Session->setFlash(__("Unable to send your comment."));
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
			return $this->redirect(array('controller' => 'applications','action' => 'index'));
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
					$this->redirect(array('controller' => 'applications','action' => 'index'));
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