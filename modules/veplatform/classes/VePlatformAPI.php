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

include_once dirname(__FILE__).'/AbstractVePlatformAPI.php';

class VePlatformAPI extends AbstractVePlatformAPI
{
	protected $request_ecommerce = 'Prestashop/';
	protected $context;
	protected $configurations = array(
		'veplatform_tag_url',
		'veplatform_pixel_url',
		'veplatform_token',
		'veplatform_products'
	);

	public function __construct($context)
	{
		$this->context = $context;
		parent::__construct();
	}

	protected function loadConfig()
	{
		$config = Configuration::getMultiple($this->configurations);
		$this->config['tag'] = $config['veplatform_tag_url'] !== false? $config['veplatform_tag_url'] : $this->config['tag'];
		$this->config['pixel'] = $config['veplatform_pixel_url'] !== false? $config['veplatform_pixel_url'] : $this->config['pixel'];
		$this->config['token'] = $config['veplatform_token'] !== false? $config['veplatform_token'] : $this->config['token'];
		if ($config['veplatform_products'] !== false)
		{
			$products = unserialize($config['veplatform_products']);
			$products_active = array();
			foreach ($products as $product)
				if (array_key_exists($product, $this->ve_products) === true)
					$products_active[] = $this->ve_products[$product];
			$this->config['products'] = $products_active;
		}
	}

	protected function saveJourney($journey)
	{
		if (!Configuration::updateValue('veplatform_tag_url', $journey->URLTag)
		|| !Configuration::updateValue('veplatform_pixel_url', $journey->URLPixel)
		|| !Configuration::updateValue('veplatform_token', $journey->Token))
			return false;
		$this->config['tag'] = $journey->URLTag;
		$this->config['pixel'] = $journey->URLPixel;
		$this->config['token'] = $journey->Token;
		return true;
	}

	protected function saveProducts($products)
	{
		$products_to_save = array();
		foreach ($this->ve_products as $product => $key)
			if (in_array($key, $products) === true)
				$products_to_save[] = $product;
		Configuration::updateValue('veplatform_products', serialize($products_to_save));
		$this->config['products'] = $products;
		return true;
	}

	protected function deleteConfig()
	{
		foreach ($this->configurations as $config)
			Configuration::deleteByName($config);
	}

	protected function setParams()
	{
		$this->request_params = array(
			'domain' => preg_replace('(^https?://)', '', _PS_BASE_URL_.__PS_BASE_URI__),
			'language' => Tools::strtolower($this->context->language->iso_code),
			'email' => $this->context->cookie->email,
			'phone' => null,
			'merchant' => $this->context->shop->name,
			'country' => Tools::strtoupper($this->context->country->iso_code),
			'currency' => Tools::strtoupper($this->context->currency->iso_code),
			'version' => _PS_VERSION_
		);
	}
}
