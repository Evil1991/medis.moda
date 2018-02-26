<?php
include_once('../../lib/pwTools.php');

class PWModuleFrontController extends ModuleFrontController {
	
	public $errors = array();
	public $path;

    public function initContent() 
	{
		$cookie = pwTools::getCustomerCookie($this->context);
		if(!$cookie->pwDeveloper){
			return Tools::display404Error();
		}
		$this->display_header = false;
		$this->display_footer = false;
		$this->display_column_left = false;
		$this->display_column_right = false;
        parent::initContent();
		$this->path = _MODULE_DIR_.'pwdeveloper/';
    }
 
}