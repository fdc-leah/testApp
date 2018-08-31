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

    
}
?>