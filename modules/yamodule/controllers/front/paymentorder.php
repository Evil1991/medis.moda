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

class yamodulepaymentorderModuleFrontController extends ModuleFrontController
{
    public $display_header = false;
    public $display_column_left = false;
    public $display_column_right = false;
    public $display_footer = false;
    public $ssl = true;

    public function initContent()
    {
        $cart = $this->context->cart;

        $payments = array();
        $payments['message'] = $this->module->l('The order status is not paid! Go to my account and then reorder');

        $order = new Order(Tools::getValue('id_order'));
        $total_to_pay = $order->total_paid;
        $rub_currency_id = Currency::getIdByIsoCode('RUB');
        if ($order->id_currency != $rub_currency_id) {
            $from_currency = new Currency($order->id_curre1ncy);
            $to_currency = new Currency($rub_currency_id);
            $total_to_pay = Tools::convertPriceFull($total_to_pay, $from_currency, $to_currency);
        }

        if (Configuration::get('YA_ORG_ACTIVE')) {
            $vars_org = Configuration::getMultiple(array(
                'YA_ORG_SHOPID',
                'YA_ORG_SCID',
                'YA_ORG_ACTIVE',
                'YA_ORG_TYPE',
            ));

            $this->context->smarty->assign(array(
                'DATA_ORG' => $vars_org,
                'id_cart' => $order->reference,
                'customer' => new Customer($order->id_customer),
                'address' => new Address($order->id_address_delivery),
                'total_to_pay' => number_format($total_to_pay, 2, '.', ''),
                'this_path_ssl' => Tools::getShopDomainSsl(true, true)
                    .__PS_BASE_URI__.'modules/'.$this->module->name.'/',
                'shop_name' => Configuration::get('PS_SHOP_NAME')
            ));

            $payments = Configuration::getMultiple(array(
                'YA_ORG_PAYMENT_YANDEX',
                'YA_ORG_PAYMENT_CARD',
                'YA_ORG_PAYMENT_MOBILE',
                'YA_ORG_PAYMENT_WEBMONEY',
                'YA_ORG_PAYMENT_TERMINAL',
                'YA_ORG_PAYMENT_SBER',
                'YA_ORG_PAYMENT_PB',
                'YA_ORG_PAYMENT_MA',
                'YA_ORG_PAYMENT_ALFA'
            ));

            if (Configuration::get('YA_ORG_INSIDE')) {
                $payments['pt'] = Tools::getValue('type');
            } else {
                $payments['pt'] = '';
            }
        }

        $this->context->smarty->assign($payments);

        return $this->setTemplate('redirectk.tpl');
    }

}
