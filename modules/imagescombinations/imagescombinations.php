<?php

class ImagesCombinations extends Module {

	private $_html = '';

	public function __construct() {
		$this->name			 = 'imagescombinations';
		$this->tab			 = 'backend_images_combinations';
		$this->version		 = '1.0.0';
		$this->author		 = 'Konsul';
		$this->need_instance = 0;
		$this->secure_key	 = Tools::encrypt($this->name);

		parent::__construct();

		$this->displayName	 = $this->l('Удобное составление комбинаций атрибутов и изображений');
		$this->description	 = $this->l('');
	}

	public function install() {
		return parent::install() && $this->registerHook('displayAdminProductsExtra') && $this->registerHook('actionAdminProductsControllerSaveAfter');
	}

	public function uninstall() {
		return parent::uninstall();
	}
	
	public function hookDisplayAdminProductsExtra($data) {
		$id_product = (int)Tools::getValue('id_product');
		
		$product = new Product($id_product);
		
		$images = $product->getImages($data['cookie']->id_lang);
		
		$this->smarty->assign('images', $images);
		
		if(!empty($images)) {
			$combinations = $product->getAttributeCombinations($data['cookie']->id_lang);
			
			foreach ($combinations as $k => $combination) {
				$price_to_convert = Tools::convertPrice($combination['price']);
				$price				 = Tools::displayPrice($price_to_convert);

				$comb_array[$combination['id_product_attribute']]['id_product_attribute']	 = $combination['id_product_attribute'];
				$comb_array[$combination['id_product_attribute']]['attributes'][]			 = array($combination['group_name'], $combination['attribute_name'], $combination['id_attribute']);
			}
			
			$images_combinations = $this->getImagesCombinations($product->id, $data['cookie']->id_lang);

			$this->smarty->assign(array(
				'comb_array'			 => $comb_array,
				'images_combinations'	 => $images_combinations,
				'link_rewrite'			 => $product->link_rewrite[$this->context->language->id]
			));
		}
		
		return $this->display(__FILE__, 'imagescombinations.tpl');
		
	}
	
	public function getImagesCombinations($product_id, $id_lang) {
		if (!Combination::isFeatureActive())
			return false;

		$product_attributes = Db::getInstance()->executeS(
			'SELECT `id_product_attribute`
			FROM `'._DB_PREFIX_.'product_attribute`
			WHERE `id_product` = '.(int)$product_id
		);

		if (!$product_attributes)
			return false;

		$ids = array();

		foreach ($product_attributes as $product_attribute)
			$ids[] = (int)$product_attribute['id_product_attribute'];

		$result = Db::getInstance()->executeS('
			SELECT pai.`id_image`, pai.`id_product_attribute`, il.`legend`
			FROM `'._DB_PREFIX_.'product_attribute_image` pai
			LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (il.`id_image` = pai.`id_image`)
			LEFT JOIN `'._DB_PREFIX_.'image` i ON (i.`id_image` = pai.`id_image`)
			WHERE pai.`id_product_attribute` IN ('.implode(', ', $ids).') AND il.`id_lang` = '.(int)$id_lang.' ORDER by i.`position`'
		);

		if (!$result)
			return false;

		$images = array();

		foreach ($result as $row) {
			$images[$row['id_image']][$row['id_product_attribute']] = $row;
		}
		
		return $images;
	}
	
	function hookActionAdminProductsControllerSaveAfter($params) {
		$data = array();
		$imgArray = Tools::getValue('imgArray');
		if(isset($_POST['images_combinations']) && is_array($_POST['images_combinations'])) {
			foreach($_POST['images_combinations'] as $image_id => $attrs) {
				$data[(int)$image_id] = array();
				
				foreach($attrs as $attr_id => $val) {
					$data[(int)$image_id][] = (int)$attr_id;
				}
			}
		}
		
		Db::getInstance()->executeS('DELETE FROM `' . _DB_PREFIX_ . 'product_attribute_image`'
				. ' WHERE id_image IN (' . implode(',', $imgArray) . ')');
		
		$ins_strs = array();
		
		foreach($data as $image_id => $attrs) {
			foreach($attrs as $attr_id) {
				$ins_strs[] = '(' . $attr_id . ',' . $image_id . ')';
			}
		}
		
		Db::getInstance()->executeS('INSERT INTO `' . _DB_PREFIX_ . 'product_attribute_image` VALUES '
			. implode(',', $ins_strs));
		
	}

    public function hookdisplayBackOfficeHeader($params)
    {
        $this->context->controller->addJS(($this->_path).'jquery.shiftcheckbox.js');
    }

}
