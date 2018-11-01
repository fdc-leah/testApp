<?php 
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');
class ProfileImage extends AppModel{
    public $useTable = 'profile_images';
    public $name = 'ProfileImage';

	public $validate = array(
        'file' => array(
            'checktype' => array(
                'rule' => array('extension',array('gif', 'jpeg', 'png', 'jpg')),
                'message' => 'Please supply a valid file type'
            )
        )
    );

    public $belongsTo = array(
        'User' => array(
            'className' => 'User'
    	)
    );

    public function saveFile($data){
        $basename = basename($data['name'],".");
        $uploadFolder = WWW_ROOT. 'profileImgs';  
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

    public function getCurrentFile($userId){
        $result = $this->find('first', array('conditions' => array('ProfileImage.user_id' => $userId),
            'fields' => array('ProfileImage.imagepath'),
            'order' => array('ProfileImage.created' => 'desc')));

        $errors = array_filter($result);
        if (empty($errors)){
            return false;
        } else {
            return $result['ProfileImage']['imagepath'];
        }
    }
}
?>