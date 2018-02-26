<?php

class AdminController extends AdminControllerCore
{
    public $ssl = false;
    
    public function __construct()
	{
        parent::__construct();
        if (Configuration::get('PS_SSL_ENABLED') && Configuration::get('PS_SSL_ENABLED_EVERYWHERE'))
			$this->ssl = true;
        if (Configuration::get('PS_SSL_ENABLED') && $_SERVER['REQUEST_METHOD'] != 'POST' && $this->ssl != Tools::usingSecureMode())
		{	
			header('HTTP/1.1 301 Moved Permanently');
			header('Cache-Control: no-cache');
			if ($this->ssl)					
				header('Location: '.Tools::getShopDomainSsl(true).$_SERVER['REQUEST_URI']);
			else						
				header('Location: '.Tools::getShopDomain(true).$_SERVER['REQUEST_URI']);
			exit();
		}
    }
}