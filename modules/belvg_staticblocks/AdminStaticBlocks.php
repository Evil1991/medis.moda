<?php

/*
 * 2007-2012 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 *         DISCLAIMER   *
 * *************************************** */
/* Do not edit or add to this file if you wish to upgrade Prestashop to newer
 * versions in the future.
 * ****************************************************
 * @category   Belvg
 * @package    Belvg_Static Blocks
 * @author     Dzianis Yurevich (dzianis.yurevich@gmail.com)
 * @site       http://module-presta.com
 * @copyright  Copyright (c) 2010 - 2012 BelVG LLC. (http://www.belvg.com)
 * @license    http://store.belvg.com/BelVG-LICENSE-COMMUNITY.txt
 */

include_once(_PS_MODULE_DIR_ . 'belvg_staticblocks/classes/BelvgStaticBlocks.php');
include_once(_PS_MODULE_DIR_ . 'belvg_staticblocks/belvg_staticblocks.php');

class AdminStaticBlocks extends AdminController {

    protected $position_identifier = 'id_belvg_staticblocks';

    protected $_js = '
        <script>
            $(".multishop_toolbar").hide();
            $("#desc-belvg_staticblocks-save").click(function(){
                $("#block_identifier").val($.trim($("#block_identifier").val()));
                $(".translatable input[type=\'text\']").each(function(){
                    $(this).val($.trim($(this).val()));
                });
            });
        </script>
    ';

    protected $_module = NULL;

    public function l($string)
    {
        if (is_null($this->_module)) {
            $this->_module = new belvg_staticblocks;
        }

        return $this->_module->l($string, __CLASS__);
    }

    public function __construct()
    {
    	$this->bootstrap = true;
        $this->table = 'belvg_staticblocks';
        $this->identifier = 'id_belvg_staticblocks';
        $this->className = 'BelvgStaticBlocks';
        $this->lang = TRUE;
        $this->addRowAction('edit');
        $this->addRowAction('delete');

        $this->fields_list = array(
            'id_belvg_staticblocks' => array(
                'title' => $this->l('ID'),
                'align' => 'center',
                'width' => 30
            ),
            'title' => array(
                'title' => $this->l('Block Title'),
                'width' => 300
            ),
            'block_identifier' => array(
                'title' => $this->l('Identifier'),
                'width' => 300
            ),
            'status' => array(
                'title' => $this->l('Status'),
                'width' => 40,
                'active' => 'update',
                'align' => 'center',
                'type' => 'bool',
                'orderby' => FALSE
            ),
            'date_add' => array(
                'title' => $this->l('Date Created'),
                'width' => 150,
                'type' => 'date',
                'align' => 'right'
            ),
            'date_upd' => array(
                'title' => $this->l('Last Modified'),
                'width' => 150,
                'type' => 'date',
                'align' => 'right'
            )
        );

        if (Shop::isFeatureActive() && Shop::getContext() != Shop::CONTEXT_ALL) {
            $this->_where .= ' AND a.' . $this->identifier . ' IN (
                SELECT sa.' . $this->identifier . '
                FROM `' . _DB_PREFIX_ . $this->table . '_shop` sa
                WHERE sa.id_shop IN (' . implode(', ', Shop::getContextListShopID()) . ')
            )';
        }

        $this->identifiersDnd = array('id_belvg_staticblocks' => 'id_sslide_to_move');

        parent::__construct();
    }

    public function renderForm()
    {
        $this->display = 'edit';
        $this->initToolbar();
        if (!$obj = $this->loadObject(TRUE)) {
            return;
        }

        $this->fields_form = array(
            'tinymce' => TRUE,
            'legend' => array(
                'title' => $this->l('Static Block'),
                'image' => '../img/admin/tab-categories.gif'
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Block Title:'),
                    'name' => 'title',
                    'id' => 'title',
                    'lang' => TRUE,
                    'required' => TRUE,
                    'size' => 50,
                    'maxlength' => 50,
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Identifier:'),
                    'name' => 'block_identifier',
                    'id' => 'block_identifier',
                    'required' => TRUE,
                    'hint' => $this->l('Allowed characters:') . ' a-z, A-Z, 0-9, _',
                    'size' => 50,
                    'maxlength' => 50,
                ),
                array(
                    'type' => 'radio',
                    'label' => $this->l('Status:'),
                    'name' => 'status',
                    'required' => FALSE,
                    'class' => 't',
                    'is_bool' => TRUE,
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    ),
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Content:'),
                    'name' => 'content',
                    'required' => TRUE,
                    'autoload_rte' => TRUE,
                    'lang' => TRUE,
                    'rows' => 5,
                    'cols' => 40,
                ),
            ),
            'submit' => array(
                'title' => $this->l('   Save   '),
                'class' => 'button'
            )
        );

        if (Shop::isFeatureActive()) {
            $this->fields_form['input'][] = array(
                'type' => 'shop',
                'label' => $this->l('Shop association:'),
                'name' => 'checkBoxShopAsso',
            );
        }

        $this->tpl_form_vars = array(
            'status' => $this->object->status
        );

        return parent::renderForm() . $this->_js;
    }

    protected function updateAssoShop($id_object)
    {
        if (!Shop::isFeatureActive()) {
            return;
        }

        $assos_data = $this->getSelectedAssoShop($this->table, $id_object);

        $exclude_ids = $assos_data;
        foreach (Db::getInstance()->executeS('SELECT id_shop FROM ' . _DB_PREFIX_ . 'shop') as $row) {
            if (!$this->context->employee->hasAuthOnShop($row['id_shop'])) {
                $exclude_ids[] = $row['id_shop'];
            }
        }

        Db::getInstance()->delete($this->table . '_shop', '`' . $this->identifier . '` = ' . (int) $id_object . ($exclude_ids ? ' AND id_shop NOT IN (' . implode(', ', $exclude_ids) . ')' : ''));

        $insert = array();
        foreach ($assos_data as $id_shop) {
            $insert[] = array(
                $this->identifier => $id_object,
                'id_shop' => (int) $id_shop,
            );
        }

        return Db::getInstance()->insert($this->table . '_shop', $insert, FALSE, TRUE, Db::INSERT_IGNORE);
    }

    protected function getSelectedAssoShop($table)
    {
        if (!Shop::isFeatureActive()) {
            return array();
        }

        $shops = Shop::getShops(TRUE, NULL, TRUE);
        if (count($shops) == 1 && isset($shops[0])) {
            return array($shops[0], 'shop');
        }

        $assos = array();
        if (Tools::isSubmit('checkBoxShopAsso_' . $table)) {
            foreach (Tools::getValue('checkBoxShopAsso_' . $table) as $id_shop => $value) {
                $assos[] = (int) $id_shop;
            }
        } else if (Shop::getTotalShops(FALSE) == 1) {
            // if we do not have the checkBox multishop, we can have an admin with only one shop and being in multishop
            $assos[] = (int) Shop::getContextShopID();
        }

        return $assos;
    }

    public function processSave()
    {
        $id = Tools::getValue('block_identifier');
        if (Validate::isModuleName($id)) {
            return parent::processSave();
        }

        $this->errors[] = Tools::displayError('The field "block_identifier" is invalid. Allowed characters:') . ' a-z, A-Z, 0-9, _';
        $this->display = 'edit';
        return FALSE;
    }

    public function processAdd()
    {
        $id = Tools::getValue('block_identifier');
        $block = BelvgStaticBlocks::getBlockByIdentifier($id);
        if ($block === FALSE) {
            return parent::processAdd();
        }

        $this->errors[] = Tools::displayError('Duplicate field "block_identifier".');
        $this->display = 'edit';
        return FALSE;
    }

    public function processUpdate()
    {
        $id = Tools::getValue('block_identifier');
        $block = BelvgStaticBlocks::getBlockByIdentifier($id);
        if ($block === FALSE || $block->id == Tools::getValue($this->identifier)) {
            return parent::processUpdate();
        }

        $this->errors[] = Tools::displayError('Duplicate field "block_identifier".');
        $this->display = 'edit';
        return FALSE;
    }
}