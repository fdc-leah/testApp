<?php 
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');
class AppFile extends AppModel{
    public $useTable = 'app_files';
    public $name = 'AppFile';

	public $validate = array(
        'file' => array(
            'checktype' => array(
                'rule' => array('extension',array('gif', 'jpeg', 'png', 'jpg')),
                'message' => 'Please supply a valid file type'
            )
        )
    );

    public $belongsTo = array(
        'Application' => array(
            'className' => 'Application'
    	)
    );

    public function saveFile($data){
        $basename = basename($data['name'],".");
        $uploadFolder = WWW_ROOT. 'appfiles';  
        $basename = str_replace(" ", "_", $basename);
        $filename = time().'_'.$basename; 
        $uploadPath =  $uploadFolder . DS . $filename;

        // make directory if not found
        if( !file_exists($uploadFolder) ){
            mkdir($uploadFolder);
        }

        if (!move_uploaded_file($data['tmp_name'], $uploadPath)) {
            return false;
        }

        return $filename;
    }

    public function getCurrentFile($applicationId){
        $result = $this->find('first', array('conditions' => array('AppFile.application_id' => $applicationId),
            'fields' => array('AppFile.filepath'),
            'order' => array('AppFile.created' => 'desc')));

        $errors = array_filter($result);
        if (empty($errors)){
            return false;
        } else {
            return $result['AppFile']['filepath'];
        }
    }
}
?>