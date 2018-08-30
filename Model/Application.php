<?php 
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');
class Application extends AppModel{
    public $useTable = 'applications';
    public $name = 'applications';

	public $validate = array(
        'title' => array(
            'rule' => 'notBlank',
            'message' => 'Title is required'
        ),
        'description' => array(
            'rule' => 'notBlank',
            'message' => 'Description is required'
        ),
        'version' => array(
            'rule' => 'notBlank',
            'message' => 'version is required'
        )
    );

    public $hasMany = array(
        'Category' => array(
            'className' => 'AppCategory',
            'cascadeCallbacks' => false
        ),
        'Comment' => array(
            'className' => 'Comment',
            'cascadeCallbacks' => false
        )
    );

    public function add($application){
        if($this->save($application)){
            return true;
        }
        return false;
    }

}
?>