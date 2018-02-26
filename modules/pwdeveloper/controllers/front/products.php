<?php
include_once('PWModuleFrontController.php');
class PwdeveloperProductsModuleFrontController extends PWModuleFrontController {
	
    public function initContent() 
	{
        parent::initContent();
		$this->setTemplate('products.tpl');
		$categories = Category::getSimpleCategories(1);
		$this->context->smarty->assign('categories', $categories);
    }
	
	public function postProcess()
	{
		if(Tools::isSubmit('submitProduct')){
			$product = new Product();
			$name = Tools::getValue('name');
			$product->name = PWTools::createMultiLangField($name);
			$product->quantity = 100;
			$product->link_rewrite = PWTools::createMultiLangField(Tools::link_rewrite($name));
			if($_POST['price1'] && $_POST['price1'] > 0 ){
				if($_POST['price2'] && $_POST['price2'] > $_POST['price1']) $price = rand($_POST['price1'], $_POST['price2']);
				else $price = $_POST['price1'];
				$product->price = $price;
			}
			if($_POST['id_category']){
				$product->id_category_default = $_POST['id_category'];
				$categories = Array(1, $_POST['id_category']);
			}
			
			$product->description = PWTools::createMultiLangField(Tools::getValue('description'));
			$product->add();
			$product->addToCategories($categories);
			//var_dump($_FILES['image']);
			if($_FILES['image']['name']) PWTools::addProductImage($product, 'auto', 'image');
			if($_FILES['image2']['name']) PWTools::addProductImage($product, 'auto', 'image2');
			if($_FILES['image3']['name']) PWTools::addProductImage($product, 'auto', 'image3');
			if($_FILES['image4']['name']) PWTools::addProductImage($product, 'auto', 'image4');
			
			echo '<p class="success"><a href="'.$this->context->link->getProductLink($product).'">Добавлено</a></p>';
		}
	}
 
}