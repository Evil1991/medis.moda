<?php

class OrderOpcController extends OrderOpcControllerCore
{
    protected function _getPaymentMethods()
    {
        if (!$this->isLogged)
            return '<p class="warning">'.Tools::displayError('Please sign in to see payment methods.').'</p>';
        if ($this->context->cart->OrderExists())
            return '<p class="warning">'.Tools::displayError('Error: This order has already been validated.').'</p>';
        if (!$this->context->cart->id_customer || !Customer::customerIdExistsStatic($this->context->cart->id_customer) || Customer::isBanned($this->context->cart->id_customer))
            return '<p class="warning">'.Tools::displayError('Error: No customer.').'</p>';
        $address_delivery = new Address($this->context->cart->id_address_delivery);
        $address_invoice = ($this->context->cart->id_address_delivery == $this->context->cart->id_address_invoice ? $address_delivery : new Address($this->context->cart->id_address_invoice));
        if (!$this->context->cart->id_address_delivery || !$this->context->cart->id_address_invoice || !Validate::isLoadedObject($address_delivery) || !Validate::isLoadedObject($address_invoice) || $address_invoice->deleted || $address_delivery->deleted)
            return '<p class="warning">'.Tools::displayError('Error: Please select an address.').'</p>';
        if (count($this->context->cart->getDeliveryOptionList()) == 0 && !$this->context->cart->isVirtualCart())
        {
            if ($this->context->cart->isMultiAddressDelivery())
                return '<p class="warning">'.Tools::displayError('Error: None of your chosen carriers deliver to some of  the addresses you\'ve selected.').'</p>';
            else
                return '<p class="warning">'.Tools::displayError('Error: None of your chosen carriers deliver to the address you\'ve selected.').'</p>';
        }
        if (!$this->context->cart->getDeliveryOption(null, false) && !$this->context->cart->isVirtualCart())
            return '<p class="warning">'.Tools::displayError('Error: Please choose a carrier.').'</p>';
        if (!$this->context->cart->id_currency)
            return '<p class="warning">'.Tools::displayError('Error: No currency has been selected.').'</p>';

        $link = new Link();
        $url = $link->getModuleLink('yamodule', 'changeorder');
       return '<a href="'.$url.'" title="ОФОРМИТЬ ЗАКАЗ" class="btn btn-default button button-medium">
                   <span>ОФОРМИТЬ ЗАКАЗ<i class="icon-chevron-right right"></i></span>
               </a>';

        /* If some products have disappear */
        if (!$this->context->cart->checkQuantities())
            return '<p class="warning">'.Tools::displayError('An item in your cart is no longer available. You cannot proceed with your order.').'</p>';

        /* Check minimal amount */
        $currency = Currency::getCurrency((int)$this->context->cart->id_currency);

        $minimal_purchase = Tools::convertPrice((float)Configuration::get('PS_PURCHASE_MINIMUM'), $currency);
        if ($this->context->cart->getOrderTotal(false, Cart::ONLY_PRODUCTS) < $minimal_purchase)
            return '<p class="warning">'.sprintf(
                    Tools::displayError('A minimum purchase total of %1s (tax excl.) is required in order to validate your order, current purchase total is %2s (tax excl.).'),
                    Tools::displayPrice($minimal_purchase, $currency), Tools::displayPrice($this->context->cart->getOrderTotal(false, Cart::ONLY_PRODUCTS), $currency)
                ).'</p>';

        /* Bypass payment step if total is 0 */
        if ($this->context->cart->getOrderTotal() <= 0)
            return '<p class="center"><button class="button btn btn-default button-medium" name="confirmOrder" id="confirmOrder" onclick="confirmFreeOrder();" type="submit"> <span>'.Tools::displayError('I confirm my order.').'</span></button></p>';

        $return = Hook::exec('displayPayment');
        if (!$return)
            return '<p class="warning">'.Tools::displayError('No payment method is available for use at this time. ').'</p>';
        return $return;
    }
}