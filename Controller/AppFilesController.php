<?php
App::uses('AppController', 'Controller');
class AppFilesController extends AppController {
	public $helpers = array('Html', 'Form', 'Flash');
	public $components = array('Flash');
	public $uses = array('User','AppCategory','Comment','Application');

	public function uploadFile(){
		// once saved, get its id.
		$app = $this->Application->findById($this->Application->id);
		if ($this->request->is('post')) {

			// check first if user selected any file.
			$appFileErrors = array_filter($appFile);
			if (empty($appFileErrors)){
				$this->Session->setFlash(__("No file selected"));
				return;
			}

			$uploadData = $this->data['AppFile']['file'];
			$filepath = $this->saveFile($uploadData);
			if($filepath == false){
				return false;
			}

			$this->request->data['AppFile']['category'] = $selectedCategories;
			$this->request->data['AppFile']['filepath'] = $filepath;
			$this->request->data['AppFile']['size'] = $uploadData['size'];
			if($this->AppFile->save()){
				$this->Session->setFlash(__('Successfully added new application'));
				$this->redirect(array('controller' => 'pages','action' => 'index'));
			}
		}
	}

	public function saveFile($data){
		$filename = basename($data['name']);
		$uploadFolder = WWW_ROOT. 'appfiles';  
		$filename = $filename.'_'.time(); 
		$uploadPath =  $uploadFolder . DS . $filename;

		// make directory if not found
		if( !file_exists($uploadFolder) ){
			mkdir($uploadFolder);
		}

		if (!move_uploaded_file($uploadData['tmp_name'], $uploadPath)) {
			return false;
		}

		return $uploadPath;
	}
}
?>