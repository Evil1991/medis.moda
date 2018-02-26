<?
define('INSTALL_PATH', dirname(__FILE__));
function createMultiLangField($field)
{
	$languages = Language::getLanguages(false);
	$res = array();
	foreach ($languages as $lang)
		$res[$lang['id_lang']] = $field;
	return $res;
}
require_once(INSTALL_PATH.'/../config/config.inc.php');
require_once(INSTALL_PATH.'/../init.php');
require_once "head.php";
$id_lang = ($cookie->id_lang ? $cookie->id_lang : CONFIG_LANG_DEFAULT);
if(Tools::isSubmit('submitCatList')){
	$categorylist = Tools::getValue('catlist');
	$arr = explode(",", $categorylist);
	if(count($arr)<2) $arr = explode("\n", $categorylist);
	$i = 0;
	$links = "<ul>";
	foreach($arr as $row){
		$level = 1;
		$row = trim($row);
		if(strlen($row)){
			if(substr($row,0,2) == "--"){
				$level = 3;
				$row = substr($row,2);
			}elseif(substr($row,0,1) == "-"){
				$level = 2;
				$row = substr($row,1);
			}
			$category = new Category();
			$category->name = createMultiLangField($row);
			$category->link_rewrite = createMultiLangField(Tools::link_rewrite($row));
			if($level>1) $category->id_parent = $id_last[($level-1)];
			else $category->id_parent = 1;
			$category->active = 1;
			if($category->add()){
				$i++;
				$id_last[$level] = $category->id;
				$level_last = 1;
			}
			$links.= '<li><a href="'.$link->getCategoryLink($category->id, $category->link_rewrite[6]).'">'.$row.'</a>'."\n";
		}
	}
	echo '<p class="success">'.$i.' добавлено</p>';
	echo '<pre>'.htmlentities($links.'</ul>', ENT_COMPAT | ENT_HTML401, 'UTF-8').'</pre>';
}
?>
<form method="POST" class="pure-form pure-form-stacked">
	<label>Название категорий, чтобы указать подкатегории, пишите -</label>
	<textarea name="catlist" cols="70" rows="10"></textarea>
	<input type="submit" name="submitCatList" class="pure-button pure-button-primary"value="Сохранить и добавить">
</form>
<?require_once "foot.php";?>