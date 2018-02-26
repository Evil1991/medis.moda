<?php

class FrontController extends FrontControllerCore
{
    public function init()
    {
        parent::init();
        global $smarty;

        require_once _PS_MODULE_DIR_ . 'belvg_staticblocks/classes/BelvgStaticBlocks.php';
        smartyRegisterFunction($smarty, 'function', 'getBelvgBlockContent', array('BelvgStaticBlocks', 'getBlockContent'));
    }
}