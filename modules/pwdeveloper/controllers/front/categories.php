<?php
include_once('PWModuleFrontController.php');
class PwdeveloperCategoriesModuleFrontController extends PWModuleFrontController {
	
    public function initContent() 
	{
        parent::initContent();
		$this->setTemplate('categories.tpl');
		$categories = Category::getSimpleCategories(1);
		$this->context->smarty->assign('categories', $categories);
    }
	
	public function postProcess()
	{
		require_once(__DIR__.'/../../lib/pwTools.php');
		if(Tools::isSubmit('submitCatList')){
			$rootCategory = Category::getRootCategory();
			$categorylist = Tools::getValue('catlist');
			$arr = preg_split('/\\r\\n?|\\n/', $categorylist);
			$id_last = array();
			foreach($arr as $row){
				$level = 1;
				$row = trim($row);
				if(strlen($row)){
					if(substr($row,0,2) == "--"){
						$level = 3;
						$row = substr($row,2);
					}elseif(substr($row,0,1) == "-"){
						$level = 2;
						$row = substr($row,1);
					}
					$category = new Category();
					$category->name = pwTools::createMultiLangField($row);
					$category->link_rewrite = pwTools::createMultiLangField(Tools::link_rewrite($row));
					if($level>1){
						$category->id_parent = $id_last[($level-1)];
					}
					else{
						$category->id_parent = $rootCategory->id;
					}
					$category->active = 1;
					if($category->add()){
						$id_last[$level] = $category->id;
					}
				}
			}
			echo 'Успешно добавлено';
		}
	}
 
}