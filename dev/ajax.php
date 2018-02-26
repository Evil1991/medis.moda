<?
define('INSTALL_PATH', dirname(__FILE__));
require_once(INSTALL_PATH.'/../config/config.inc.php');
require_once(INSTALL_PATH.'/../init.php');
require_once "lib.php";
$action = Tools::getValue('action');

switch($action){
    case 'hook':
        $module = Tools::getValue('module');
        $hook = Tools::getValue('hook');
        if(!Module::isInstalled($module)) die('Модуль не установлен или не существует.');
        if(version_compare(_PS_VERSION_, '1.5.0', '>=') === true){ if(!Hook::getIdByName($hook)) die('Такого хука нет');}
        else{ if(!Hook::get($hook)) die('Такого хука нет');}
        $module = Module::getInstanceByName($module);
        $result = $module->registerHook($hook);
        if($result === false) die('Cбой при насаживании на крючок');
        die('1');
    case 'cms':
        $name = Tools::getValue('name');
        $content = Tools::getValue('content');
        if(empty($name)) die('Пустое имя');
        $cms = new CMS();
        $cms->meta_title = createMultiLangField($name);
        $cms->link_rewrite = createMultiLangField(Tools::link_rewrite($name));
        $cms->content = createMultiLangField($content);
        $cms->id_cms_category = 1;
        $cms->active = 1;
        if($cms->add()) die('{"id_cms" : '.$cms->id.', "link_rewrite" : "'.$cms->link_rewrite[$cookie->id_lang].'"}');
        die('Не удалось добавить');
    break;
}
?>