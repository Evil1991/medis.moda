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
 
if (!defined('_PS_VERSION_')) {
    exit;
}

class belvg_staticblocks extends Module
{
    public function __construct()
    {
        $this->name = 'belvg_staticblocks';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'BelVG';
        $this->need_instance = 0;
        $this->module_key = 'cb483701b4cc60dac48b7d5cf3b15118';

        parent::__construct();

        $this->displayName = $this->l('Static Blocks');
        $this->description = $this->l('Static Blocks');
    }

    public function install()
    {
        $sql = array();

        $sql[] =
            'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'belvg_staticblocks` (
              `id_belvg_staticblocks` int(10) unsigned NOT NULL auto_increment,
              `status` int(10) NOT NULL default "1",
              `block_identifier` varchar(255) NOT NULL,
              `date_add` datetime NOT NULL,
              `date_upd` datetime NOT NULL,
              PRIMARY KEY  (`id_belvg_staticblocks`)
            ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8';

        $sql[] =
            'ALTER TABLE  `' . _DB_PREFIX_ . 'belvg_staticblocks`
                ADD UNIQUE  `block_identifier` (  `block_identifier` )';

        $sql[] =
            'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'belvg_staticblocks_shop` (
              `id_belvg_staticblocks` int(10) unsigned NOT NULL auto_increment,
              `id_shop` int(10) unsigned NOT NULL,
              PRIMARY KEY (`id_belvg_staticblocks`, `id_shop`)
            ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8';

        $sql[] =
            'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'belvg_staticblocks_lang` (
              `id_belvg_staticblocks` int(10) unsigned NOT NULL,
              `id_lang` int(10) unsigned NOT NULL,
              `title` varchar(255) NOT NULL,
              `content` text,
              PRIMARY KEY (`id_belvg_staticblocks`,`id_lang`)
            ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8';
/* theme data [begin] */
		$sql[] = "INSERT INTO `" . _DB_PREFIX_ . "belvg_staticblocks` 
		(`id_belvg_staticblocks`, `status`, `block_identifier`, `date_add`, `date_upd`)
		VALUES 
		(1, 1, 'img_b1', '2014-11-28 08:34:27', '2015-01-19 08:56:10'),
		(2, 1, 'img_b2', '2014-11-28 09:21:01', '2015-01-19 08:56:25'),
		(3, 1, 'img_b3', '2014-11-28 09:57:16', '2015-01-19 08:56:43'),
		(4, 1, 'rb1', '2014-11-28 17:55:49', '2015-01-19 08:47:09'),
		(5, 1, 'rb2', '2014-11-28 17:56:47', '2015-01-19 08:51:51'),
		(6, 1, 'rb3', '2014-11-28 17:57:20', '2015-01-19 08:52:08'),
		(7, 1, 'rb4', '2014-11-28 17:57:49', '2015-01-19 08:52:30'),
		(8, 1, 'rb5', '2014-11-28 17:58:25', '2015-01-19 08:52:47'),
		(12, 1, 'b01', '2014-12-01 09:02:55', '2015-01-26 11:52:12'),
		(13, 1, 'b02', '2014-12-01 09:03:28', '2015-01-26 11:53:55'),
		(14, 1, 'b03', '2015-01-10 19:50:06', '2015-01-26 12:00:00'),
		(15, 1, 'b04', '2015-01-10 19:52:06', '2015-01-26 12:00:30'),
		(16, 1, 'bfluid', '2015-01-19 08:15:27', '2015-01-27 16:11:54'),
		(17, 1, 'most_popular_title', '2015-03-23 08:43:38', '2015-03-23 08:43:38'),
		(18, 1, 'new_products_title', '2015-03-23 08:51:38', '2015-03-23 08:57:05'),
		(19, 1, 'featured_products_title', '2015-03-23 09:00:12', '2015-03-23 09:02:15'),
		(20, 1, 'bestselling_products_title', '2015-03-23 09:04:47', '2015-03-23 09:04:47')";
		$languages = Language::getLanguages();
        foreach ($languages as $language) {
			$sql[] = "INSERT INTO `" . _DB_PREFIX_ . "belvg_staticblocks_lang` 
			(`id_belvg_staticblocks`, `id_lang`, `title`, `content`)
			VALUES
			(1, '" . (int)$language['id_lang'] . "', 'Image Banner', '<div class=\"img_b1\"><span class=\"img_b1text\">Мужчинам</span>\r\n<div class=\"img_b1_hr\">&nbsp;</div>\r\n<img src=\"http://belvg.net/helen/prestashop_themes/theme4/img/cms/men1.png\" alt=\"\" width=\"277\" height=\"587\" /></div>\r\n<div> </div>'),
			(2, '" . (int)$language['id_lang'] . "', 'Image Banner', '<div class=\"img_b2\"><span class=\"img_b2text\">Аксессуары</span>\r\n<div class=\"img_b2_hr\">&nbsp;</div>\r\n<img src=\"http://belvg.net/helen/prestashop_themes/theme4/img/cms/accssories3.png\" alt=\"\" width=\"585\" height=\"585\" /></div>'),
			(3, '" . (int)$language['id_lang'] . "', 'Image Banner', '<div class=\"img_b03\">\r\n<div class=\"img_b3\"><span class=\"img_b3text\">Детям</span>\r\n<div class=\"img_b3_hr\">&nbsp;</div>\r\n<img src=\"http://belvg.net/helen/prestashop_themes/theme4/img/cms/kids1.png\" alt=\"\" width=\"279\" height=\"278\" /></div>\r\n<div class=\"img_b4\"><span class=\"img_b4text\">Женщинам</span>\r\n<div class=\"img_b3_hr\">&nbsp;</div>\r\n<img src=\"http://belvg.net/helen/prestashop_themes/theme4/img/cms/women2.png\" alt=\"\" width=\"279\" height=\"278\" /></div>\r\n<div> </div>\r\n</div>'),
			(4, '" . (int)$language['id_lang'] . "', 'Round Banner', '<div class=\"f_banner4 wow bounceInUp\" data-wow-duration=\"1s\"><span class=\"scl\">&nbsp;</span><span class=\"f_ico\">&nbsp;</span>\r\n<p><a class=\"ffa4\" href=\"prestashop.com\">Обратная связь</a></p>\r\n</div>'),
			(5, '" . (int)$language['id_lang'] . "', 'Round Banner', '<div class=\"f_banner5 wow bounceInUp\" data-wow-duration=\"2s\"><span class=\"scl\">&nbsp;</span><span class=\"f_ico1\">&nbsp;</span>\r\n<p><a class=\"ffa4\" href=\"prestashop.com\">Техподдержка</a></p>\r\n</div>'),
			(6, '" . (int)$language['id_lang'] . "', 'Round Banner', '<div class=\"f_banner6 wow bounceInUp\" data-wow-duration=\"3s\"><span class=\"scl\">&nbsp;</span><span class=\"f_ico2\">&nbsp;</span>\r\n<p><a class=\"ffa5\" href=\"prestashop.com\">+375 29 123 45 67</a></p>\r\n</div>'),
			(7, '" . (int)$language['id_lang'] . "', 'Round Banner', '<div class=\"f_banner7 wow bounceInUp\" data-wow-duration=\"4s\"><span class=\"scl\">&nbsp;</span><span class=\"f_ico3\">&nbsp;</span>\r\n<p><a class=\"ffa4\" href=\"prestashop.com\">Наши клиенты</a></p>\r\n</div>'),
			(8, '" . (int)$language['id_lang'] . "', 'Round Banner', '<div class=\"f_banner8 wow bounceInUp\" data-wow-duration=\"5s\"><span class=\"scl\">&nbsp;</span><span class=\"f_ico4\">&nbsp;</span>\r\n<p><a class=\"ffa4\" href=\"prestashop.com\">PayPal, Credit Card</a></p>\r\n</div>'),
			(12, '" . (int)$language['id_lang'] . "', 'Img', '<div class=\"b01\"><img src=\"http://belvg.net/helen/prestashop_themes/theme4/img/cms/b05_2.png\" alt=\"\" width=\"590\" height=\"190\" />\r\n<div class=\"b01text\">Очки</div>\r\n<div class=\"b01text_1\">Скидки до 20%</div>\r\n<div class=\"b01a\"><a href=\"module-presta.com\">Купить</a></div>\r\n</div>'),
			(13, '" . (int)$language['id_lang'] . "', 'Img', '<div class=\"b01\"><img src=\"http://belvg.net/helen/prestashop_themes/theme4/img/cms/b02_2.png\" alt=\"\" width=\"590\" height=\"190\" />\r\n<div class=\"b01text\">Часы 2015</div>\r\n<div class=\"b01text_1\">Скидки до 30%</div>\r\n<div class=\"b01a\"><a href=\"module-presta.com\">Купить</a></div>\r\n</div>'),
			(14, '" . (int)$language['id_lang'] . "', 'Img', '<div class=\"b01\"><img src=\"http://belvg.net/helen/prestashop_themes/theme4/img/cms/b03_1.png\" alt=\"\" width=\"590\" height=\"190\" />\r\n<div class=\"b01text\">1500 Shoes</div>\r\n<div class=\"b01text_1\">New Arrivals</div>\r\n<div class=\"b01a\"><a href=\"module-presta.com\">Shop Now</a></div>\r\n</div>'),
			(15, '" . (int)$language['id_lang'] . "', 'Img', '<div class=\"b01\"><img src=\"http://belvg.net/helen/prestashop_themes/theme4/img/cms/b07_1.png\" alt=\"\" width=\"590\" height=\"190\" />\r\n<div class=\"b01text\">Leather Bags</div>\r\n<div class=\"b01text_1\">New Arrivals</div>\r\n<div class=\"b01a\"><a href=\"module-presta.com\">Shop Now</a></div>\r\n</div>'),
			(16, '" . (int)$language['id_lang'] . "', 'Full Width Banner', '<div class=\"bfluid\"><img src=\"http://belvg.net/helen/prestashop_themes/theme4/img/cms/fluid7_1.png\" alt=\"\" width=\"1185\" height=\"469\" /><br />\r\n<div class=\"bfluid_text wow bounceInUp\">Журнал</div>\r\n<div class=\"bfluid_text1 wow bounceInUp\">Отличные скидки на все золотые аксессуары.</div>\r\n<div class=\"bfluid_button wow bounceInUp\"><a href=\"module-presta.com\">Подробнее</a></div>\r\n<div class=\"fluid_border\">&nbsp;</div>\r\n</div>'),
			(17, '" . (int)$language['id_lang'] . "', 'Most Popular Categories Title', '<div class=\"fb_title\">Популярные категории</div>'),
			(18, '" . (int)$language['id_lang'] . "', 'New Products Title', '<h2>New Products</h2>'),
			(19, '" . (int)$language['id_lang'] . "', 'Featured Products Title', '<h2>Featured Products</h2>'),
			(20, '" . (int)$language['id_lang'] . "', 'Bestselling title', '<h2>Bestsellers</h2>')";						
        }
		/* theme data [end] */
        foreach ($sql as $_sql) {
            Db::getInstance()->Execute($_sql);
        }

        $new_tab = new Tab();
        $new_tab->class_name = 'AdminStaticBlocks';
        $new_tab->id_parent = Tab::getCurrentParentId();
        $new_tab->module = $this->name;
        $languages = Language::getLanguages();
        foreach ($languages as $language) {
            $new_tab->name[$language['id_lang']] = 'Belvg Static Blocks';
        }

        $new_tab->add();

        return parent::install();
    }

    public function uninstall()
    {
        $sql = array();

        $sql[] = 'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'belvg_staticblocks`';
        $sql[] = 'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'belvg_staticblocks_shop`';
        $sql[] = 'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'belvg_staticblocks_lang`';

        foreach ($sql as $_sql) {
            Db::getInstance()->Execute($_sql);
        }

        $idTab = Tab::getIdFromClassName('AdminStaticBlocks');
        if ($idTab) {
            $tab = new Tab($idTab);
            $tab->delete();
        }

        return parent::uninstall();
    }
}
