<?php
App::uses('AppController', 'Controller');
App::uses('CakeNumber', 'Utility');
class AppFilesController extends AppController {
	public $helpers = array('Html', 'Form', 'Flash','Number','Js');
	public $components = array('Flash');
	public $uses = array('Application','AppFile');

	public function uploadFile($appId){
		// once saved, get its id.
		$idLastinserted = ($appId != null ? $appId : $this->Application->id);
		$app = $this->Application->findById($idLastinserted);
		$userId = $this->Session->read('User.id');
		$this->set(compact('app'));

		// if logged in user is not the owner, redirect to index
		if($userId != $app['Application']['user_id']){
			$this->Session->setFlash('Invalid action');
			return $this->redirect(array('controller' => 'applications','action' => 'index'));
		}

		if ($this->request->is('post') || $this->request->is('put') ) {
			$appFile = $this->request->data['File']['file'];
			// check first if user selected any file.
			$appFileErrors = array_filter($appFile);
			if (empty($appFileErrors)){
				$this->Session->setFlash(__("No file selected"));
				return;
			}
			$filepath = $this->AppFile->saveFile($appFile);
			if($filepath == false){
				$this->Session->setFlash(__('Failed uploading the file.'));
				return $this->redirect( array('controller' => 'applications','action'=>'updateApplication',$idLastinserted)); ;
			}

			$this->request->data['AppFile']['filepath'] = $filepath;
			$this->request->data['AppFile']['size'] = CakeNumber::toReadableSize($appFile['size']);
			if($this->AppFile->save($this->request->data['AppFile'])){
				$this->Session->setFlash(__('Successfully added new application'));
				$this->redirect(array('controller' => 'applications','action' => 'index'));
			} else {
				$this->Session->setFlash(__('Failed uploading the file.'));
			}
		}
	}
}
?>