<?php
if (!defined('_PS_VERSION_'))
	exit;

require_once(dirname(__FILE__).'/lib/pwTools.php');

class pwDeveloper extends Module
{
	
	private $html;
    private $modules;

	public function __construct()
	{
		$this->name = 'pwdeveloper';
		$this->tab = 'admin';
		$this->version = '0.9';
		$this->author = 'PrestaWeb';
		$this->need_instance = 0;
		$this->bootstrap = true;
		parent::__construct();

		$this->displayName = $this->l('Помощь разработчику');
		$this->description = $this->l('Набор инструментов для разработки.');
		$this->modules = Array(
            'graphnvd3',
            'blockcurrencies',
            'blocklanguages',
            'gamification',
            'onboarding'
        );
	}

	public function install()
	{
		return parent::install() && $this->registerHook('header') && $this->registerHook('footer')
		&& $this->registerHook('displayBackOfficeHeader');
	}

	public function uninstall()
	{
		return parent::uninstall();
	}
	
	public function hookHeader($params)
	{
		if($this->context->cookie->pwDeveloper){
			$this->context->controller->addCSS(($this->_path).'css/pwdeveloper.css', 'all');
			$this->context->controller->addJS(($this->_path).'js/pwdeveloper.js');
			$this->context->controller->addjqueryPlugin('fancybox');
	 
			$this->smarty->assign(array(
				'pw_dev_url' => $this->context->link->getModuleLink('pwdeveloper', 'ajax', array())
			));
			return $this->display(__FILE__, 'header.tpl');
		}
	}
	
	public function getContent()
    {
        $this->html = '';
		$this->postProcess();
		$this->smarty->assign(array(
			'pwDeveloperOn' => pwTools::getCustomerCookie($this->context)->pwDeveloper,
		));
		return $this->html.$this->display(__FILE__, 'back.tpl'); 
    }
	
	public function postProcess()
	{
		if (Tools::isSubmit('submitUnistallModule')){
			$disabled = array();
			$modules = Module::getModulesInstalled();
			foreach($modules as $mod)
			{
				$m = Module::getInstanceByName($mod['name']);
				if($m->tab == 'analytics_stats' && $m->uninstall()){
					$disabled[] = $m->name;
				}
			}
            foreach($this->modules as $module){
                if($module){
					$moduleObj = Module::getInstanceByName($module);
					if(Validate::isLoadedObject($moduleObj) && $moduleObj->uninstall()){
						$disabled[] = $moduleObj->name;
					}
                }
            }
            $this->html .= $this->displayConfirmation('Модулей успешно удалено: '.count($disabled).'<br />'.implode(', ',$disabled));
        }
		if(Tools::isSubmit('submitOnDeveloper')){
			$cookie = pwTools::getCustomerCookie($this->context);
			$cookie->pwDeveloper = true;
			$cookie->write();
			$this->html .= $this->displayConfirmation('Инструменты включены для вас');
		}
		if(Tools::isSubmit('submitOffDeveloper')){
			$cookie = pwTools::getCustomerCookie($this->context);
			$cookie->pwDeveloper = false;
			$cookie->write();
			$this->html .= $this->displayConfirmation('Инструменты выключены для вас');
		}
	}
	
	
	function hookFooter($params)
	{
		if($this->context->cookie->pwDeveloper){
			return $this->display(__FILE__, 'footer.tpl');
		}
	}
	
	public function hookDisplayBackOfficeHeader()
	{
		return '<script>$(document).ready(function(){$("#module_install").next(".alert").hide();});</script>';
	}

}
