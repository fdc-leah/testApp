<?php 
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');
class AppCategory extends AppModel{
    public $useTable = 'app_categories';
    public $name = 'AppCategory';

    public $validate = array(
        'category' => array(
            'rule' => 'notBlank',
            'message' => 'Please select one or more categories'
        )
    );

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

    public function getAppCategoriesByAppId($application){
        $appCategories = array();
        $index = 0;
        foreach ($application['AppCategory'] as $category) {
            $appCategories[$index] = $category['category_id'];
            $index++;
        }
        return $appCategories;
    }

    public function update($appCategData,$appId){
        $newAppCategory = array();
        $temp = $this->query("Delete from app_categories where application_id = $appId");

        // save new category
        $index = 0;
        foreach ($appCategData['category'] as $category) {
            $newAppCategory[$index] = array('application_id' => $appId, 'category_id' => $category);
            $index++;
        }
        $appCategData = $newAppCategory;
        if($this->saveAll($appCategData)){
            return true;
        } else {
            return false;
        }
    }
}
?>