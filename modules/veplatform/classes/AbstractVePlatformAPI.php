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

abstract class AbstractVePlatformAPI
{
	protected $request_domain = 'http://veconnect.veinteractive.com/API/';
	protected $request_ecommerce = 'EcommerceIdentifier/';
	protected $request_merchant = 'GetMerchantInfo';
	protected $request_install = 'Install';
	protected $request_uninstall = 'Uninstall';
	protected $request_products = 'ActivateProducts';
	protected $request_timeout = 15;
	protected $ve_products = array(
		'vecontact' => 1,
		'vechat' => 2,
		'veassist' => 3,
		'veads' => 5
	);
	protected $request_params = array();
	protected $config = array(
		'tag' => null,
		'pixel' => null,
		'token' => null,
		'products' => array()
	);

	public function __construct()
	{
		$this->setParams();
		$this->loadConfig();
	}

	abstract protected function setParams();
	abstract protected function loadConfig();
	abstract protected function saveJourney($journey);
	abstract protected function saveProducts($products);
	abstract protected function deleteConfig();

	/**
	 * @return boolean
	 */
	protected function getToken()
	{
		$token = $this->getConfigOption('token');
		return $token;
	}

	/**
	 * @param string $option
	 * @param boolean $reload (default: false)
	 * @return string
	 */
	public function getConfigOption($option, $reload = false)
	{
		if ($reload === true)
			$this->loadConfig();
		$value = array_key_exists($option, $this->config)? $this->config[$option] : null;
		return $value;
	}

	/**
	 * @return boolean
	 */
	public function isInstalled()
	{
		foreach (array('tag', 'pixel', 'token') as $name)
			if ($this->config[$name] === null)
				return false;
		return true;
	}

	/**
	 * @return boolean
	 */
	public function showLogin()
	{
		$response = $this->isInstalled() && count($this->config['products']) > 0;
		return $response;
	}

	/**
	 * @param string $product
	 * @return boolean
	 */
	public function isProductActive($product)
	{
		$response = array_key_exists($product, $this->ve_products) && in_array($this->ve_products[$product], $this->config['products']);
		return $response;
	}

	/**
	 * @return boolean
	 */
	public function installModule()
	{
		$params = $this->request_params;
		$response = $this->getRequest($this->request_install, $params);
		if ($response)
		{
			$journey = Tools::jsonDecode($response);
			if (isset($journey->URLPixel) && isset($journey->URLTag) && isset($journey->Token))
			{
				$journey->URLPixel = $this->cleanUrl($journey->URLPixel);
				$journey->URLTag = $this->cleanUrl($journey->URLTag);
				return $this->saveJourney($journey);
			}
		}
		return false;
	}

	/**
	 * @param string $url
	 * @return string
	 */
	protected function cleanUrl($url)
	{
		$clean_url = preg_replace('(^https?:)', '', $url);
		return $clean_url;
	}

	/**
	 * @return boolean
	 */
	public function uninstallModule()
	{
		$params = $this->request_params;
		$params['token'] = $this->getToken();
		$this->deleteConfig();
		$response = $this->getRequest($this->request_uninstall, $params);
		if ($response)
			return Tools::jsonDecode($response);
		return false;
	}

	/**
	 * @param array $products_form
	 * @return boolean
	 */
	public function activateProducts($products_form)
	{
		$products = array();
		foreach ($products_form as $product)
			if (array_key_exists($product, $this->ve_products))
				$products[] = $this->ve_products[$product];
		if (count($products) === 0)
			return true;
		$params = $this->request_params;
		$params['token'] = $this->getToken();
		$params['taskId'] = 1;
		$params['appCodes'] = implode('|', $products);
		$response = $this->getRequest($this->request_products, $params);
		if ($response)
		{
			$response = Tools::jsonDecode($response);
			if ($response === true)
			{
				$old_products = $this->getConfigOption('products');
				$products_to_save = array_merge($old_products, $products);
				$products_to_save = array_unique($products_to_save);
				sort($products_to_save);
				return $this->saveProducts($products_to_save);
			}
		}
		return false;
	}

	/**
	 * @param string $request_action
	 * @param array $params
	 * @return mixed
	 */
	protected function getRequest($request_action, $params)
	{
		$params = Tools::jsonEncode($params);
		$ch = curl_init($this->request_domain.$this->request_ecommerce.$request_action);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: '.Tools::strlen($params)
		));
		$response = curl_exec($ch);
		return $response;
	}
}
