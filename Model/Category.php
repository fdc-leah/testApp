<?php 
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');
class Category extends AppModel{
    public $useTable = 'categories';
    public $name = 'Category';

    public function getAppCategory($application){
		$appCategories = array();
		$index = 0;
		foreach ($application['Category'] as $category) {
			$appCategories[$index] = $this->findById($category['category_id']);
			$index++;
		}
		return $appCategories;
    }
}
?>