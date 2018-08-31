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
        'AppCategory' => array(
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

    public function loadAllApplications($params){
        $category = isset($params['category']) ? $params['category'] : null;
        if ($category == null) {
            return $this->find('all', array('order' => array('Application.modified' => 'desc')));
        } else {
            $sql = "Select * from applications Application
            join app_categories AppCategory on Application.id = AppCategory.application_id 
            where AppCategory.category_id = $category";
            return $this->query($sql);
        }
    }

}
?>