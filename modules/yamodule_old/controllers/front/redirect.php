<?php
/**
* Module is prohibited to sales! Violation of this condition leads to the deprivation of the license!
*
* @category  Front Office Features
* @package   Yandex Payment Solution
* @author    Yandex.Money <cms@yamoney.ru>
* @copyright © 2015 NBCO Yandex.Money LLC
* @license   https://money.yandex.ru/doc.xml?id=527052
*/

class YamoduleRedirectModuleFrontController extends ModuleFrontController
{
    public $display_header = true;
    public $display_column_left = true;
    public $display_column_right = false;
    public $display_footer = true;
    public $ssl = true;

    public function postProcess()
    {
        parent::postProcess();
        $log_on = Configuration::get('YA_P2P_LOGGING_ON');
        $cart = $this->context->cart;
        if ($cart->id_customer == 0
            || $cart->id_address_delivery == 0
            || $cart->id_address_invoice == 0
            || !$this->module->active
        ) {
            Tools::redirect('index.php?controller=order&step=1');
        }

        $customer = new Customer($cart->id_customer);
        if (!Validate::isLoadedObject($customer)) {
            Tools::redirect('index.php?controller=order&step=1');
        }
                
        $this->myCart=$this->context->cart;
        $total_to_pay = $cart->getOrderTotal(true);
        $rub_currency_id = Currency::getIdByIsoCode('RUB');
        if ($cart->id_currency != $rub_currency_id) {
            $from_currency = new Currency($cart->id_currency);
            $to_currency = new Currency($rub_currency_id);
            $total_to_pay = Tools::convertPriceFull($total_to_pay, $from_currency, $to_currency);
        }
        if ($total_to_pay > 0 && $total_to_pay < 1) {
            $total_to_pay_limit = '1.00';
        } else {
            $total_to_pay_limit = number_format($total_to_pay, 2, '.', '');
        }
        $total_to_pay = number_format($total_to_pay, 2, '.', '');
        $this->module->payment_status = '';
        $code = Tools::getValue('code');
        $type = Tools::getValue('type');
        if (empty($code)) {
            $scope = array(
                "payment.to-account(\"".Configuration::get('YA_P2P_NUMBER')
                ."\",\"account\").limit(,".$total_to_pay_limit.")",
                "money-source(\"wallet\",\"card\")"
            );
            if ($type == 'wallet') {
                if ($log_on) {
                    $this->module->logSave('p2p_redirect: '.$this->module->l('Type wallet'));
                }
                $auth_url = API::buildObtainTokenUrl(
                    Configuration::get('YA_P2P_IDENTIFICATOR'),
                    $this->context->link->getModuleLink('yamodule', 'redirectwallet', array(), true),
                    $scope
                );
            } elseif ($type == 'card') {
                if ($log_on) {
                    $this->module->logSave('redirect: '.$this->module->l('Type card'));
                }
                Tools::redirect(
                    $this->context->link->getModuleLink(
                        'yamodule',
                        'redirectcard',
                        array('code' => true, 'cnf' => true),
                        true
                    ),
                    ''
                );
            }
            
            if ($log_on) {
                $this->module->logSave('p2p_redirect: url = '.$auth_url);
            }
            Tools::redirect($auth_url, '');
        }
    }
    
    public function initContent()
    {
        parent::initContent();
        $cart = $this->context->cart;
        $this->context->smarty->assign(array(
            'payment_link' => '',
            'nbProducts' => $cart->nbProducts(),
            'cust_currency' => $cart->id_currency,
            'currencies' => $this->module->getCurrency((int)$cart->id_currency),
            'total' => $cart->getOrderTotal(true, Cart::BOTH),
            'this_path' => $this->module->getPathUri(),
            'this_path_ssl' => Tools::getShopDomainSsl(true, true).__PS_BASE_URI__.'modules/'.$this->module->name.'/'
        ));

        $this->setTemplate('redirect.tpl');
    }
}
