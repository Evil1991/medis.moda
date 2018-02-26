<?php

if (!defined('_PS_VERSION_'))
	exit;

class PWImport extends Module
{
	public $empty = array();
	
	public function __construct()
	{
		$this->name = 'pwimport';
		$this->tab = 'quick_bulk_update';
		$this->version = '1.0';
		$this->author = 'PrestaWeb.ru';
		$this->need_instance = 0;

		parent::__construct();
		$this->bootstrap = true;
		$this->displayName = $this->l('Импорт комбинаций');
		$this->description = $this->l('Импорт комбинаций.');
		$this->ps_versions_compliancy = array('min' => '1.5', 'max' => _PS_VERSION_);
	}

	public function install()
	{
		return (parent::install());
	}
	
	public function getContent()
	{
		$output = '';
		if(Tools::isSubmit('submitCsv')){
			if (isset($_FILES['csv']) && !empty($_FILES['csv']['error'])){
				$output .= $this->displayError('Ошибка загрузки файла');
			}
			else{
				$success = 0;
				$errorRows = array();
				$file = Tools::fileAttachment('csv');
				$rows = preg_split('/\\r\\n?|\\n/', $file['content']);
				foreach($rows as $i => $row){
					if(trim($row) != ''){
						$product_attribute = array();
						$s = mb_convert_encoding($row, 'utf-8', 'windows-1251');
						$parsedRow = $this->str_getcsv($s, ';');
						$quantity = $parsedRow[9]; //столбик с количеством товара
						$reference = $parsedRow[0];//столбик со значением reference
						if($this->updateProductAttribute($quantity, $reference)){
							$success += 1;
						}
						else{
							$errorRows[$i+1] = $s;
						}
					}
				}
				$output .= $this->displayConfirmation('Обработано строк: '.(count($errorRows) + $success));
				$output .= $this->displayConfirmation('Успешно обновлено продуктов: '.($success - count($this->empty)));
				$output .= $this->formatErrorRow($this->empty, 'Отсутсвуют артикулы', false);
				if(count($errorRows)){
					$output .= $this->displayError('Строк с ошибками: '.count($errorRows));
					$output .= $this->formatErrorRow($errorRows, 'Необработанные строки', true);
				}
			}
		}
		$output .= $this->displayAlert('Импортировать файлы вы можете только в формате CSV.');
		return $output.$this->renderForm();
	}
	
	public function renderForm()
	{
		$fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => 'Импорт комбинаций',
					'icon' => 'icon-cogs'
				),
				'input' => array(
						array(
								'type' => 'file',
								'name' => 'csv',
								'label' => 'Открыть файл',
						),
				),
				'submit' => array(
						'title' => 'Загрузить',
						'class' => 'button'
				),
			)
		);
		$helper = new HelperForm();
		$helper->show_toolbar = false;
		$helper->table = $this->table;
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->submit_action = 'submitCsv';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');

		return $helper->generateForm(array($fields_form));
	}
	
	private function displayAlert($alert)
	{
		return '<div class="alert alert-info">'.$alert.'</div>';
	}
	
	private function updateProductAttribute($quantity, $reference)
	{
		if(!is_numeric($quantity) || empty($reference)){
			return false;
		}
		if($id_product = $this->getIdProductByRef($reference)){
			Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'product` SET `quantity` = '.(int)$quantity.' WHERE `id_product` = '.$id_product);
		}
		if($id_product_attribute = $this->getIdProductAttrByRef($reference)){
			Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'product_attribute` SET `quantity` = '.(int)$quantity.' WHERE `id_product_attribute` = '.$id_product_attribute);
		}
		if(!$id_product && !$id_product_attribute){
			$this->empty[] = $reference;
			return true;
		}
		return Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'stock_available` SET `quantity` = '.(int)$quantity.' WHERE '.
											($id_product?'`id_product` = '.(int)$id_product.' AND `id_product_attribute`=0':'').
											($id_product_attribute?'`id_product_attribute` = '.(int)$id_product_attribute:''));
	}
	
	private function formatErrorRow($errorRows, $title, $index = true)
	{
		$html = '<textarea>';
		if(is_array($errorRows)){
			foreach($errorRows as $i => $er){
				$html .= ($index?'<'.$i.'> ':'').$er . chr(0x0A);
			}
		}
		$html .= '</textarea>';
		return $this->displayError($title.':'.$html);
	}
	
	protected function getIdProductByRef($reference)
	{
		return Db::getInstance()->getValue('
		SELECT `id_product`
		FROM `'._DB_PREFIX_.'product` p
		WHERE p.reference = "'.pSQL($reference).'"');
	}
	
	protected function getIdProductAttrByRef($reference)
	{
		return Db::getInstance()->getValue('
		SELECT `id_product_attribute`
		FROM `'._DB_PREFIX_.'product_attribute` pa
		WHERE pa.reference = "'.pSQL($reference).'"');
	}
	
	protected function str_getcsv($input, $delimiter = ',', $enclosure = '"') {

        if( ! preg_match("/[$enclosure]/", $input) ) {
          return (array)preg_replace(array("/^\\s*/", "/\\s*$/"), '', explode($delimiter, $input));
        }

        $token = "##"; $token2 = "::";
        //alternate tokens "\034\034", "\035\035", "%%";
        $t1 = preg_replace(array("/\\\[$enclosure]/", "/$enclosure{2}/",
             "/[$enclosure]\\s*[$delimiter]\\s*[$enclosure]\\s*/", "/\\s*[$enclosure]\\s*/"),
             array($token2, $token2, $token, $token), trim(trim(trim($input), $enclosure)));

        $a = explode($token, $t1);
        foreach($a as $k=>$v) {
            if ( preg_match("/^{$delimiter}/", $v) || preg_match("/{$delimiter}$/", $v) ) {
                $a[$k] = trim($v, $delimiter); $a[$k] = preg_replace("/$delimiter/", "$token", $a[$k]); }
        }
        $a = explode($token, implode($token, $a));
        return (array)preg_replace(array("/^\\s/", "/\\s$/", "/$token2/"), array('', '', $enclosure), $a);
	}
	
}


