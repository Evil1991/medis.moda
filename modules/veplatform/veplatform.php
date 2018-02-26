<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the GNU General Public License (GPL) version 3
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/
 *
 * @author    Ve Interactive <info@veinteractive.com>
 * @copyright 2015 Ve Interactive
 * @license   http://www.gnu.org/licenses/ GNU General Public License (GPL) version 3
 */

if (!defined('_PS_VERSION_'))
	exit;

include_once dirname(__FILE__).'/classes/VePlatformAPI.php';

class VePlatform extends Module {

	/* View Path */
	const VIEW_FRONT_TAG_PATH = 'views/templates/front/VeTag.tpl';
	const VIEW_FRONT_PIXEL_PATH = 'views/templates/front/VePixel.tpl';
	const VIEW_ADMIN_SETTINGS_PATH = 'views/templates/admin/VeSettings.tpl';
	const VIEW_ADMIN_THANKS_PATH = 'views/templates/admin/VeThanks.tpl';
	const VIEW_ADMIN_JS_PATH = 'views/js/VePlatform.js';
	const VIEW_ADMIN_CSS_PATH = 'views/css/VePlatform.css';
	/* Misc */
	const IMG_PATH = '../modules/veplatform/views/img/';
	const ADMIN_TAB_CONTROLLER = 'VePlatformTab';

	private $api = null;

	public function __construct()
	{
		$this->author = 'Ve Interactive';
		$this->displayName = 'VePlatform';
		$this->name = 'veplatform';
		$this->version = '15.2.300'; // PS validator needs XX.XX.XX format, so we put <Year>.<Quarter>.(Sprint * 100 + Bug).
		$this->module_key = '8dd5aeff61bc9289af2b7e2bc3b9ed18';
		$this->tab = 'advertising_marketing';
		/* Only checked by PS >= 1.6 - TODO */
		$this->ps_versions_compliancy = array('min' => '1.5.0.1', 'max' => _PS_VERSION_);
		$this->module_admintab_name = 'VEPLATFORM';

		parent::__construct();

		$this->api = new VePlatformAPI($this->context);

		/* Not to Move */
		$this->description = $this->l('Instantly increase your sales by adding the VePlatform\'s integrated conversion enhancing, 
		remarketing and re-engagement apps that convert customers who abandon your site.');
	}

	/**
	 * Hook for Install on Admin.
	 */
	public function install()
	{
		$b_installed = false;

		/* PS >= 1.6 already check the compliancy */
		$error_msg = $this->checkRequirements();
		if (!$error_msg)
		{
			$this->logMessage('Call webservice to install merchant', 'INFO');
			if ($this->api->installModule() === true)
			{
				$this->logMessage('Merchant has been properly installed in webservice', 'OK');
				$b_installed = ( parent::install() && $this->registerHooks() && $this->installTab($this->name, $this->module_admintab_name) );
				if ($b_installed)
					$this->logMessage('Module has been properly installed in prestashop', 'OK');
				else
					$this->logMessage('Error installing module in prestashop', 'ERROR');
			}
			else
			{
				$this->logMessage('Error in webservice when installing merchant', 'ERROR');
				$error_msg = $this->l('There was a problem connecting to Ve Interactive server, try again please.');
			}
		}

		if ($error_msg)
			$this->_errors[] = $error_msg;
		return $b_installed;
	}

	/**
	 * Hook for Settings/Thanks Display on Admin.
	 */
	public function getContent()
	{
		/* This hook only exist in PS >= 1.6 */
		$this->hookActionAdminControllerSetMedia();

		$product_alert = '';
		$is_thanks_time = false;

		/* On Save Settings */
		if (Tools::isSubmit('submit'))
		{
			$this->logMessage('Saving products', 'INFO');
			$products_form = Tools::getValue('product', array());
			if ($this->api->activateProducts($products_form) === true)
			{
				$this->logMessage('Products have been properly saved in webservice', 'OK');
				$is_thanks_time = true;
			}
			else
			{
				$this->logMessage('Error in webservice when saving products', 'ERROR');
				$product_alert = $this->l('There was a problem connecting to Ve Interactive server, try again please.');
			}
		}

		$this->context->smarty->assign('currentYear', date('Y'));
		$this->context->smarty->assign('path', self::IMG_PATH);
		$this->context->smarty->assign('showLogin', $this->api->showLogin());
		$this->context->smarty->assign('veApi', $this->api);
		$this->context->smarty->assign('langIsoCode', $this->context->language->iso_code);
		if ($is_thanks_time)
			$template_path = self::VIEW_ADMIN_THANKS_PATH;
		else
		{
			$this->context->smarty->assign('productAlert', $product_alert);
			$template_path = self::VIEW_ADMIN_SETTINGS_PATH;
		}

		return $this->display(__FILE__, $template_path);
	}

	/**
	 * Hook for UnInstall on Admin
	 */
	public function uninstall()
	{
		$this->logMessage('Call webservice to uninstall merchant', 'INFO');
		if ($this->api->uninstallModule())
			$this->logMessage('Merchant has been properly uninstalled in webservice', 'OK');
		else
			$this->logMessage('Error in webservice when uninstalling merchant', 'ERROR');
		self::unInstallTab();
		/* You don't need to call unregisterHook this one because uninstall do it for you */
		return parent::uninstall();
	}

	public function enable($force_all = false)
	{
		$response = parent::enable($force_all);
		if ($response)
			$this->logMessage('Module has been enabled', 'INFO');
		return $response;
	}

	public function enableDevice($device)
	{
		parent::enableDevice($device);
		$this->logMessage('Module has been enabled in device '.$device, 'INFO');
	}

	public function disable($force_all = false)
	{
		parent::disable($force_all);
		$this->logMessage('Module has been disabled', 'INFO');
	}

	public function disableDevice($device)
	{
		parent::disableDevice($device);
		$this->logMessage('Module has been disabled in device '.$device, 'INFO');
	}

	/**
	 * Hook for Checkout Display on Front-End.
	 */
	public function hookDisplayOrderConfirmation()
	{
		$output = '';
		$pixel = $this->api->getConfigOption('pixel');
		if ($pixel && !empty($pixel))
		{
			$this->context->smarty->assign('url_pixel', $pixel);
			$output = $this->display(__FILE__, self::VIEW_FRONT_PIXEL_PATH);
		}

		return $output;
	}

	/* Hook for Footer Display on Front-End */

	public function hookFooter()
	{
		$output = '';
		$tag = $this->api->getConfigOption('tag');
		if ($tag && !empty($tag))
		{
			$this->context->smarty->assign('url_tag', $tag);
			$this->context->smarty->assign('footer', 'CONTENT');
			$output = $this->display(__FILE__, self::VIEW_FRONT_TAG_PATH);
		}

		return $output;
	}

	/**
	 * Hook for add CSS and JS to Back-End.
	 */
	public function hookActionAdminControllerSetMedia()
	{
		$this->context->controller->addJS($this->_path.self::VIEW_ADMIN_JS_PATH);
		$this->context->controller->addCSS($this->_path.self::VIEW_ADMIN_CSS_PATH, 'all');
	}

	private function registerHooks()
	{
		return ( $this->registerHook('footer') && $this->registerHook('displayOrderConfirmation') && $this->registerHook('actionAdminControllerSetMedia') );
	}

	private function installTab($module, $tabname)
	{
		$b_is_ok = true;

		/* Only PS >= 1.6.
		Class ADMIN_TAB_CONTROLLER require definition of ModuleAdminController.
		Hook actionAdminControllerSetMedia is also needed for registry Tab.
		( Without this hook, if you select another admintab our logo doesn't appears in veplatform admintab )
		*/
		if (class_exists('ModuleAdminController') && $this->isRegisteredInHook('actionAdminControllerSetMedia'))
		{
			$tab = new Tab();
			$tab->name[(int)Configuration::get('PS_LANG_DEFAULT')] = $tabname;
			$tab->class_name = self::ADMIN_TAB_CONTROLLER;
			$tab->id_parent = 0; /* Home tab */
			$tab->module = $module;
			$b_is_ok = (bool)$tab->add(); /* return Id tab */
		}

		return $b_is_ok;
	}

	private function checkRequirements()
	{
		$error_msg = false;

		if (!$error_msg && !self::checkedPHPVersion())
			$error_msg = $this->l('PHP 5.2 or newer is required.');
		elseif (!$error_msg && !self::checkedCurlInstallation())
			$error_msg = $this->l('CURL is required.');
		else
		{
			if (method_exists($this, 'checkCompliancy'))
				$check_compliancy = $this->checkCompliancy();
			else
				$check_compliancy = $this->checkCompliancyVersion();
			if ($check_compliancy === false)
				$error_msg = $this->l('The version of your module is not compliant with your PrestaShop version.');
		}

		return $error_msg;
	}

	private function checkCompliancyVersion()
	{
		$min_version = version_compare(_PS_VERSION_, $this->ps_versions_compliancy['min'], '<');
		$max_version = version_compare(_PS_VERSION_, $this->ps_versions_compliancy['max'], '>');
		if ($min_version || $max_version)
			return false;
		return true;
	}

	private static function checkedCurlInstallation()
	{
		return function_exists('curl_init');
	}

	private static function checkedPHPVersion()
	{
		return ( version_compare(phpversion(), '5.2.0', '>=') );
	}

	private static function unInstallTab()
	{
		$id = Tab::getIdFromClassName(self::ADMIN_TAB_CONTROLLER);
		if ($id)
		{
			$tab = new Tab($id);
			$tab->delete();
		}
	}

	private function logMessage($message, $level)
	{
		$file = dirname(__FILE__).'/veplatform.log';
		if (is_writable($file) || (!file_exists($file) && is_writable(dirname(__FILE__))))
		{
			$formatted_message = '*'.$level.'* '."\t".date('Y/m/d - H:i:s').': '.$message."\r\n";
			file_put_contents($file, $formatted_message, FILE_APPEND);
		}
	}
}
