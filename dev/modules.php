<?
define('INSTALL_PATH', dirname(__FILE__));
require_once(INSTALL_PATH.'/../config/config.inc.php');
require_once(INSTALL_PATH.'/../init.php');
require_once(INSTALL_PATH.'/lib.php');
require_once "head.php";
if(Tools::isSubmit('addModule')){
    $name = Tools::getValue('name');
    if(empty($name)){
        $errors[] = "Не указано имя";
    }
    $name = Tools::link_rewrite(strtolower($name));
    if(empty($_POST['hooks']) && empty($_POST['myhooks'])) $errors[] = "Хуки пустые";
    $displayName = Tools::getValue('displayName');
    $displayDesc = Tools::getValue('displayDesc');
    if(is_dir(_PS_MODULE_DIR_.$name)) $errors[] = "Такой модуль уже есть";
    if(empty($errors)){
        mkdir(_PS_MODULE_DIR_.$name);
        $dir = _PS_MODULE_DIR_.$name.'/';
        copy(dirname(__FILE__).'/blocktest/blocktest.php', $dir.$name.'.php');
        copy(dirname(__FILE__).'/blocktest/blocktest.tpl', $dir.$name.'.tpl');
        copy(dirname(__FILE__).'/blocktest/logo.gif', $dir.'logo.gif');
        if(Tools::getValue('tpl')){
            $tpl_content = file_get_contents($dir.$name.'.tpl');
            file_put_contents($dir.$name.'.tpl', Tools::getValue('tpl'));
        }
        $module_content = file_get_contents($dir.$name.'.php');
        $module_content = str_replace('blocktest', $name, $module_content);
        $module_content = str_replace('%name%', $displayName, $module_content);
        $module_content = str_replace('%nameup%', strtoupper($name), $module_content);
        $module_content = str_replace('%description%', $displayDesc, $module_content);
        if(!Tools::getValue('photo')) $module_content = preg_replace('|\/\/start_photo(.*)\/\/end_photo|Uis', '', $module_content);
        if(!Tools::getValue('settings')) $module_content = preg_replace('|\/\/start_setting(.*)\/\/end_setting|Uis', '', $module_content);
        $hook_string = "";
        $functions = "";
        if(Tools::getValue('myhooks')){
            $myhooks = explode(',', Tools::getValue('myhooks'));
            foreach($myhooks as $myhook){
                $myhook = trim($myhook);
                if(strlen($myhook)) $_POST['hooks'][$myhook] = 1;
            }
        }
        foreach($_POST['hooks'] as $key=>$value){
            $hook_string.=' AND $this->registerHook(\''.$key.'\')';
            $functions.="\tpublic function hook".$key."(\$params){
        ".(Tools::getValue('code') ? Tools::getValue('code') : '')."
        return \$this->display(__FILE__, '".$name.".tpl');
    }\n\n";
        }
        $module_content = str_replace('%hook%', $hook_string, $module_content);
        $module_content = str_replace('%functions%', $functions, $module_content);
        if(file_put_contents($dir.$name.'.php', $module_content)){
            echo '<p class="success">Модуль '.$name.' создан</p>';
            $module = Module::getInstanceByName($name);
            if(Tools::getValue('installit')){
                if($module->install()) echo '<p class="success">Модуль '.$name.' установлен</p>';
                else  echo '<p class="warning">Ошибка при установке модуля '.$name.'</p>';
            }
        }
    }else p($errors);
}
?>
<form method="post" action="modules.php"  class="pure-form pure-form-stacked">
    <p>
        <label for="">Имя модуля(транслит)</label>
        <input style="width:300px" name="name" value="<?=($_POST['name'] ? $_POST['name'] : 'block')?>" type="text" />
    </p>

    <p>
        <label for="">Отображаемое имя</label>
        <input style="width:300px" name="displayName" value="<?=($_POST['displayName'] ? $_POST['displayName'] : '')?>" type="text" />
    </p>
    <p>
        <label for="">Отображаемое описание</label>
        <input style="width:300px" name="displayDesc" value="<?=($_POST['displayDesc'] ? $_POST['displayDesc'] : '')?>" type="text" />
    </p>

    <p class="checkbox">
        <label for="">Хуки</label>
        <div class="margin-row">
            <label for="leftcolumn">leftcolumn</label><input id="leftcolumn" type="checkbox" name="hooks[leftcolumn]" value="1" /><br />
            <label for="rightcolumn">rightcolumn</label><input type="checkbox" id="rightcolumn" name="hooks[rightcolumn]" value="1" /><br />
            <label for="header">header</label><input type="checkbox" id="header" name="hooks[header]" value="1" /><br />
            <label for="top">top</label><input type="checkbox" id="top" name="hooks[top]" value="1" /><br />
            <label for="footer">footer</label><input type="checkbox" id="footer" name="hooks[footer]" value="1" /><br />
            <label for="myhooks">Свои хуки</label>
        <input type="text" size="100" id="myhooks" name="myhooks" value="" placeholder="Через запятую" /><br />
        </div>
    </p>
    <p><textarea name="code" id="" cols="30" rows="10" placeholder="Код для функций хуков"></textarea></p>
    <p><textarea name="tpl" id="" cols="30" rows="10">Новый сгенерированный хук</textarea></p>
    <p><label for="settings">Настройки</label><input name="settings" value="1" id="settings" type="checkbox"/></p>
    <p><label for="photo">Загрузка фото</label><input name="photo" value="1" id="photo" type="checkbox"/></p>
    <p><label for="installit">Сразу и установить</label><input name="installit" value="1" checked id="installit" type="checkbox"/></p>
    <p><label for=""></label><input class="pure-button pure-button-primary" type="submit" name="addModule" value="Генерировать" type="text"/></p>
</form>
<?require_once "foot.php";?>