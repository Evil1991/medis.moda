<?php

class YamoduleChangeOrderModuleFrontController extends ModuleFrontController
{
    public $display_header = true;
    public $display_column_left = true;
    public $display_column_right = false;
    public $display_footer = true;
    public $ssl = true;
    public $errors;

    public function postProcess()
    {

    }


    public function initContent()
    {
        $cart = $this->context->cart;
        $link = $this->context->link->getPageLink('order-confirmation').'&id_cart='
            .$cart->id.'&id_module='.$this->module->id.'&id_order='
            .$this->module->currentOrder.'&key='.$cart->secure_key;

        if ($cart->id > 0) {
            if (!$cart->orderExists()) {
                $ord = $this->module->validateOrder(
                    $cart->id,
                    Configuration::get('YA_LATE_PRE_STATUS'),
                    $cart->getOrderTotal(true, Cart::BOTH),
                    "Яндекс.Касса",
                    null,
                    array(),
                    null,
                    false,
                    $cart->secure_key
                );

                $id_order = $this->module->currentOrder;
            }
            if ($this->log_on) {
                $this->module->logSave(
                    'payment_card: #'.$this->module->currentOrder.' '.$this->module->l('Order success')
                );
            }
            Tools::redirect($link);
        }
    }
}