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
        $filename = basename($data['name'],".");
        $fileNameNoExtension = preg_replace("/\.[^.]+$/", "", $filename);
        $uploadFolder = WWW_ROOT. 'appfiles';  
        $filename = $fileNameNoExtension.'_'.time(); 
        $uploadPath =  $uploadFolder . DS . $filename;

        // make directory if not found
        if( !file_exists($uploadFolder) ){
            mkdir($uploadFolder);
        }

        if (!move_uploaded_file($data['tmp_name'], $uploadPath)) {
            echo "here";
            // return false;
        }

        // return $uploadPath;
    }
}
?>