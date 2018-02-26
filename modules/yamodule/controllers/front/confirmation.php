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

class YamoduleConfirmationModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        $this->display_column_left = false;
        parent::initContent();
        $this->context->smarty->assign(array(
            'conf_text' => Configuration::get('YA_LATE_CONFIRMATION_TEXT'),
        ));
        return $this->setTemplate('confirmation.tpl');
    }
}
