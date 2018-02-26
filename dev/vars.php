<?php
define('INSTALL_PATH', dirname(__FILE__));
require_once(INSTALL_PATH.'/../config/config.inc.php');
require_once(INSTALL_PATH.'/../init.php');
require_once(INSTALL_PATH.'/lib.php');
require_once "head.php";
$adminfolder = (is_dir(_PS_ROOT_DIR_.'/ad') ? _PS_ROOT_DIR_.'/ad/' : false);
if(!$adminfolder) echo '<p class="warning">Папка админа не найдена</p>';

if(Tools::isSubmit('addVar')){
    $name = Tools::getValue('name');
    if(empty($name)){
        $errors[] = "Не указано имя";
    }
    $name = Tools::link_rewrite(strtolower($name));
    $displayName = Tools::getValue('displayName');
    $class_txt = "\npublic \$".$name.";\n //".Tools::getValue('displayName');

    $place = 'place';
    switch($_POST['type']){
        case 'boolean':
            $mysql_len = 1;
            $mysql_type = 'TINYINT';
            $getFields_string = '(int) $this->'.$name.';';
            $adminfield = '<input type="radio" name="'.$name.'" id="'.$name.'1" value="1" \'.($this->getFieldValue($obj, \''.$name.'\') == true ? \'checked="checked" \' : \'\').\'><label class="t" for="'.$name.'1">Да</label><br />
            <input type="radio" name="'.$name.'" id="'.$name.'0" value="0" \'.($this->getFieldValue($obj, \''.$name.'\') == false ? \'checked="checked" \' : \'\').\'><label class="t" for="'.$name.'0">Нет</label>';
            break;
        case 'integer':
            $mysql_len = 12;
            $mysql_type = 'INTEGER';
            $getFields_string = '(int) $this->'.$name.';';
            $adminfield = '<input type="text" name="'.$name.'" id="'.$name.'" value="\'.(int)$this->getFieldValue($obj, \''.$name.'\').\'" />';
            break;
        case 'float':
            $mysql_len = 12;
            $mysql_type = 'FLOAT';
            $getFields_string = '(float) $this->'.$name.';';
            $adminfield = '<input type="text" name="'.$name.'" id="'.$name.'" value="\'.(float)$this->getFieldValue($obj, \''.$name.'\').\'" />';
            break;
        case 'varchar':
            $mysql_len = 255;
            $mysql_type = 'VARCHAR';
            $getFields_string = 'pSQL($this->'.$name.');';
            $adminfield = '<input type="text" width="200" name="'.$name.'" id="'.$name.'" value="\'.$this->getFieldValue($obj, \''.$name.'\').\'" />';
            break;
        case 'text':
            $mysql_len = '';
            $mysql_type = 'TEXT';
            $getFields_string = 'pSQL($this->'.$name.');';
            $adminfield = '<textarea cols="60" rows="8" name="'.$name.'" id="'.$name.'">\'.$this->getFieldValue($obj, \''.$name.'\').\'</textarea>';
            break;
        case 'texthtml':
            $mysql_len = '';
            $mysql_type = 'TEXT';
            $getFields_string = 'pSQL($this->'.$name.', true);';
            $adminfield = '<textarea cols="60" class="rte" rows="8" name="'.$name.'" id="'.$name.'">\'.$this->getFieldValue($obj, \''.$name.'\').\'</textarea>';
            break;
    }
    $adminfield2 = '<label for="'.$name.'">'.$displayName.'</label>
                    <div class="margin-form">
                        '.$adminfield.'
                    </div><p class="clear"></p>';
    switch($_POST['class']){
        case 'product':
            $class_filename = 'Product.php';
            $tablename = _DB_PREFIX_.'product';
            $admintab = 'AdminProducts.php';
            $adminfield2 = '<tr>
						<td class="col-left">'.$displayName.'</td>
						<td style="padding-bottom:5px;clear:both">
							'.$adminfield.'
						</td></tr>';
            if(in_array($_POST['type'], Array('text','texthtml'))) $place = '2place';
            break;

        case 'customer':
            $class_filename = 'Customer.php';
            $tablename = _DB_PREFIX_.'customer';
            $admintab = 'AdminCustomers.php';
            break;

        case 'category':
            $class_filename = 'Category.php';
            $tablename = _DB_PREFIX_.'category';
            $admintab = 'AdminCategories.php';
            break;

        case 'address':
            $class_filename = 'Address.php';
            $tablename = _DB_PREFIX_.'address';
            $admintab = 'AdminAddresses.php';
            break;
    }


    $sql = 'ALTER TABLE `'.$tablename.'` ADD `'.$name.'` '.$mysql_type.($mysql_len ? '( '.$mysql_len.' )' : '').' NULL AFTER `date_upd`';


    $class_content = file_get_contents(_PS_CLASS_DIR_.$class_filename);
    $class_content = preg_replace('|\/\*end_of_vars\*\/|Uis', "\${0}\n\tpublic \$".$name."; //".$displayName, $class_content);
    $class_content = preg_replace('|public function getFields\(\)[\s]*{(.*)return\s\$fields;\s*}|Uis',
    "public function getFields() {\${1}\n\t\t\$fields['$name'] = ".$getFields_string."//".$displayName."\n\t\treturn \$fields;\n\t}", $class_content);

    $admintab_content = file_get_contents($adminfolder.'tabs/'.$admintab);

    $admintab_content =  preg_replace('|\/\/'.$place.'|Uis', "\${0}\n\t echo '".$adminfield2."';\n", $admintab_content);

    $column_result =  Db::getInstance()->ExecuteS("SHOW COLUMNS FROM `".$tablename."` LIKE '".$name."'"); //Проверяем наличие столбца в базе
    $column_exists = (count($column_result))?TRUE:FALSE;
    if(!$column_exists){
        if(Db::getInstance()->Execute($sql)){
            echo '<p class="success">Создание столбца '.$name.' прошло успешно</p>';
            if(file_put_contents(_PS_CLASS_DIR_.$class_filename, $class_content)){
                echo '<p class="success">Добавление строк в класс '.$class_filename.' прошло успешно</p>';
                if(file_put_contents($adminfolder.'tabs/'.$admintab,  $admintab_content)){
                    echo '<p class="success">Добавление строк в админку '.$admintab.' прошло успешно</p>';
                } else
                    echo'<p class="warning">Не удалось записать данные в админку</p>';
            } else echo '<p class="warning">Не удалось записать данные в класс</p>';
        }
    }else echo '<p class="warning">Уже есть такой столбец в базе</p>';


}
?>
<form method="post" action="vars.php" class="pure-form pure-form-stacked">
    <p>
        <label for="">Переменная</label>
        <input style="width:300px" name="name" value="<?=($_POST['name'] ? $_POST['name'] : 'var')?>" type="text" />
    </p>
    <p>
        <label for="">Название</label>
        <input style="width:300px" name="displayName" value="<?=($_POST['displayName'] ? $_POST['displayName'] : 'Моя переменная')?>" type="text" />
    </p>
    <p>
        <label for="class">Класс для добавления</label>
        <select name="class" id="class">
            <option value="product" <?=($_REQUEST['class']=="product" ? 'selected="selected"' : '')?>>product</option>
            <option value="customer" <?=($_REQUEST['class']=="customer" ? 'selected="selected"' : '')?>>customer</option>
            <option value="category" <?=($_REQUEST['class']=="category" ? 'selected="selected"' : '')?>>category</option>
            <option value="address" <?=($_REQUEST['class']=="address" ? 'selected="selected"' : '')?>>address</option>
        </select>
    </p>
    <p>
        <label for="Тип переменной">Тип переменной</label>
        <select name="type" id="type">
            <option <?=($_REQUEST['type']=="boolean" ? 'selected="selected"' : '')?>>boolean</option>
            <option <?=($_REQUEST['type']=="integer" ? 'selected="selected"' : '')?>>integer</option>
            <option <?=($_REQUEST['type']=="float" ? 'selected="selected"' : '')?>>float</option>
            <option <?=($_REQUEST['type']=="varchar" ? 'selected="selected"' : '')?>>varchar</option>
            <option <?=($_REQUEST['type']=="text" ? 'selected="selected"' : '')?>>text</option>
            <option <?=($_REQUEST['type']=="texthtml" ? 'selected="selected"' : '')?>>texthtml</option>
        </select>
    </p>
    <p><input type="submit" name="addVar" value="Генерировать" class="pure-button pure-button-primary"/></p>
</form>

<?require_once "foot.php";?>