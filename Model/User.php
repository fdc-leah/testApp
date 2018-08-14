<?php 
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');
class User extends AppModel{
    public $useTable = 'users';
    public $name = 'users';
    public $key = 'wt1U5MACWJFTXGenFoZoiLwQGrLgdbHABAsDdZKoALa';

	public $validate = array(
        'full_name' => array(
            'rule' => 'notBlank',
            'message' => 'Fullname is required'
        ),
        'email' => array(
            'rule' => 'notBlank',
            'message' => 'Email is required'
        ),
        'password' => array(
            'rule' => 'notBlank',
            'message' => 'Password is required'
        ),
        'password_new' => array(
            'rule' => 'notBlank',
            'message' => 'New password is required'
        ),
        'password_old' => array(
            'rule'=>array('password_old'),
            'message' => 'Incorrect password'
        ),
        'password_confirm'=>array(
            'rule'=>array('password_confirm'),
            'message'=>'Password Confirmation must match Password',                         
        ),
        'password_new_confirm'=>array(
            'rule'=>array('password_new_confirm'),
            'message'=>'Password Confirmation must match New Password',                         
        ),
        'birthday' => array(
            'rule' => 'date',
            'message' => 'birthday is required'
        )
    );

    public function beforeSave($options = array()) {
	    if (isset($this->data[$this->alias]['password'])) {
	        $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
	    }
        if (isset($this->data[$this->alias]['password_new'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password_new']);
        }
	    return true;
	}

    public function beforeFind($results, $primary = false){
        if (isset($this->data[$this->alias]['password'])){
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
        return true;
    }

    public function password_confirm(){ 
        if ($this->data['User']['password'] !== $this->data['User']['password_confirm']){
            return false;       
        }
        return true;
    }

    public function password_old(){
        $id = $this->data['User']['id'];
        $user = $this->findById($id);
        if ($user['User']['password'] !== AuthComponent::password($this->data['User']['password_old'])){
            return false;       
        }
        return true;
    }

    public function password_new_confirm(){ 
        if ($this->data['User']['password_new'] !== $this->data['User']['password_new_confirm']){
            return false;       
        }
        return true;
    }

}
?>