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

class BelvgStaticBlocks extends ObjectModel {

    public $id;

    /** @var integer block ID */
    public $id_belvg_staticblocks;

    /** @var string Title */
    public $title;

    /** @var string Identifier */
    public $block_identifier;

    /** @var boolean Status for display */
    public $status = 1;

    /** @var string Content */
    public $content;

    /** @var string Object creation date */
    public $date_add;

    /** @var string Object last modification date */
    public $date_upd;

    public static $definition = array(
        'table' => 'belvg_staticblocks',
        'primary' => 'id_belvg_staticblocks',
        'multilang' => TRUE,
        'fields' => array(
            'block_identifier' =>     array('type' => self::TYPE_STRING, 'validate' => 'isModuleName', 'required' => TRUE, 'size' => 50),
            'status' =>             array('type' => self::TYPE_INT),
            'date_add' =>             array('type' => self::TYPE_DATE),
            'date_upd' =>             array('type' => self::TYPE_DATE),

            // Lang fields
            'title' =>                 array('type' => self::TYPE_STRING, 'lang' => TRUE, 'validate' => 'isCatalogName', 'required' => TRUE, 'size' => 128),
            'content' =>             array('type' => self::TYPE_HTML, 'lang' => TRUE, 'validate' => 'isString', 'size' => 3999999999999, 'required' => TRUE),
        ),
    );

    public static function getBlockByIdentifier($block_identifier)
    {
        $sql = '
        SELECT `id_belvg_staticblocks`
        FROM `' . _DB_PREFIX_ . 'belvg_staticblocks`
        WHERE `block_identifier` = "' . pSQL($block_identifier) . '";';

        $block_id = (int)Db::getInstance()->getValue($sql);
        $_block = new BelvgStaticBlocks((int)$block_id);

        if ($_block->id) {
            return $_block;
        }

        return FALSE;
    }

    public static function getBlockContent($params, &$smarty)
    {
        //use in template as {getBelvgBlockContent id="block_identifier"}
        if (!Module::isEnabled('belvg_staticblocks')) {
            return FALSE;
        }

        if (isset($params['id'])) {
            $block_identifier = $params['id'];

            $sql = '
            SELECT `id_belvg_staticblocks`
            FROM `' . _DB_PREFIX_ . 'belvg_staticblocks`
            WHERE `block_identifier` = "' . pSQL($block_identifier) . '" AND `status` = "1"';

            if (Shop::isFeatureActive()) {
                $sql .= ' AND `id_belvg_staticblocks` IN (
                    SELECT sa.`id_belvg_staticblocks`
                    FROM `' . _DB_PREFIX_ . 'belvg_staticblocks_shop` sa
                    WHERE sa.id_shop IN (' . implode(', ', Shop::getContextListShopID()) . ')
                )';
            }

            $block_id = (int)Db::getInstance()->getValue($sql);

            if ($block_id) {
                $id_lang = Context::getContext()->cookie->id_lang;
                $block = new self($block_id);
                if (isset($block->content[$id_lang])) {
                    return $block->content[$id_lang];
                }
            }
        }
    }
}