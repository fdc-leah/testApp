<?php
App::uses('AppController', 'Controller');
App::uses('CakeNumber', 'Utility');
class ProfileImagesController extends AppController {
	public $helpers = array('Html', 'Form', 'Flash','Number','Js');
	public $components = array('Flash');
	public $uses = array('User','ProfileImage');

	public function uploadImage(){
		if($this->Session->check('User.id')){
			$userId = $this->Session->read('User.id');
			$this->set('userId',$userId);
			if (!$userId) {
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
				$filepath = $this->ProfileImage->saveFile($appFile);
				if($filepath == false){
					$this->Session->setFlash(__('Failed uploading the file.'));
					return $this->redirect( array('controller' => 'users','action'=>'updateProfile'));
				}

				$this->request->data['ProfileImage']['imagepath'] = $filepath;
				if($this->ProfileImage->save($this->request->data['ProfileImage'])){
					$this->redirect( array('controller' => 'users','action'=>'updateProfile'));
				} else {
					$this->Session->setFlash(__('Failed uploading image.'));
				}
			}
		}
	}
}
?>