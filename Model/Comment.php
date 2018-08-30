<?php 
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');
class Comment extends AppModel{
    public $useTable = 'comments';
    public $name = 'Comment';

	public $validate = array(
        'comment' => array(
            'rule' => 'notBlank',
            'message' => 'Please insert any comment'
        )
    );

    public $belongsTo = array(
        'Application' => array(
            'className' => 'Application'
        ),
        'User' => array(
            'className' => 'User'
        )
    );

    public function getAppComments($appId){
        $conditions = array('application_id' => $appId); 
        $appComments = $this->find('all',array('conditions' => $conditions));
        return $appComments; 
    }

    public function submitComment($comment){
        if ($this->save($comment)){
            return true;
        }
        return false;
    }
}
?>