<?php 
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');
class AppCategory extends AppModel{
    public $useTable = 'app_categories';
    public $name = 'app_categories';

    public $belongsTo = array(
    	'Application' => array(
    		'className' => 'Application'
    	)
    );

    public function add($appCategData,$lastId){
        $newAppCategory = array();
        $index = 0;
        foreach ($appCategData['category'] as $category) {
            $newAppCategory[$index] = array('application_id' => $lastId, 'category_id' => $category);
            $index++;
        }
        $appCategData = $newAppCategory;
		if($this->saveAll($appCategData)){
			return true;
		}
    	return false;
    }
}
?>