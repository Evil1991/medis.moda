<?php

class ParentOrderController extends ParentOrderControllerCore
{
    protected function _assignWrappingAndTOS()
    {
        // Wrapping fees
        $wrapping_fees = $this->context->cart->getGiftWrappingPrice(false);
        $wrapping_fees_tax_inc = $wrapping_fees = $this->context->cart->getGiftWrappingPrice();

        // TOS
        $cms = new CMS(Configuration::get('PS_CONDITIONS_CMS_ID'), $this->context->language->id);
        $this->link_conditions = $this->context->link->getCMSLink($cms, $cms->link_rewrite, (bool)Configuration::get('PS_SSL_ENABLED'));
        if (!strpos($this->link_conditions, '?'))
            $this->link_conditions .= '?content_only=1';
        else
            $this->link_conditions .= '&content_only=1';

        $free_shipping = false;
        foreach ($this->context->cart->getCartRules() as $rule)
        {
            if ($rule['free_shipping'] && !$rule['carrier_restriction'])
            {
                $free_shipping = true;
                break;
            }
        }
        $this->context->smarty->assign(array(
            'free_shipping' => $free_shipping,
            'checkedTOS' => 1,
            'recyclablePackAllowed' => (int)(Configuration::get('PS_RECYCLABLE_PACK')),
            'giftAllowed' => (int)(Configuration::get('PS_GIFT_WRAPPING')),
            'cms_id' => (int)(Configuration::get('PS_CONDITIONS_CMS_ID')),
            'conditions' => (int)(Configuration::get('PS_CONDITIONS')),
            'link_conditions' => $this->link_conditions,
            'recyclable' => (int)($this->context->cart->recyclable),
            'delivery_option_list' => $this->context->cart->getDeliveryOptionList(),
            'carriers' => $this->context->cart->simulateCarriersOutput(),
            'checked' => $this->context->cart->simulateCarrierSelectedOutput(),
            'address_collection' => $this->context->cart->getAddressCollection(),
            'delivery_option' => $this->context->cart->getDeliveryOption(null, false),
            'gift_wrapping_price' => (float)$wrapping_fees,
            'total_wrapping_cost' => Tools::convertPrice($wrapping_fees_tax_inc, $this->context->currency),
            'total_wrapping_tax_exc_cost' => Tools::convertPrice($wrapping_fees, $this->context->currency)));
    }
}