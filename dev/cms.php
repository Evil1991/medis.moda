<?
define('INSTALL_PATH', dirname(__FILE__));
require_once(INSTALL_PATH.'/../config/config.inc.php');
require_once(INSTALL_PATH.'/../init.php');
require_once "func.php";
require_once "head.php";
if(Tools::isSubmit('submitCMSList')){
	$cmslist = Tools::getValue('cmslist');
	$arr = explode(",", $cmslist);
	if(count($arr)<2) $arr = explode("\n", $cmslist);
	$i = 0;
	$links = "<ul>";
	foreach($arr as $row){
		$row = trim($row);
		if(strlen($row)){
		$cms = new CMS();
			$cms->meta_title = createMultiLangField($row);
			$cms->link_rewrite = createMultiLangField(Tools::link_rewrite($row));
			$cms->content = createMultiLangField("Редактировать в Админ-панели - Инструменты - Страницы");
			$cms->id_cms_category = 1;
			$cms->active = 1;
			if($cms->add()) $i++;
			$links.= '<li><a href="'.$link->getCMSLink($cms->id, $cms->link_rewrite[6]).'">'.$row.'</a>'."\n";
		}
	}
	echo '<p class="success">'.$i.' добавлено</p>';
	echo '<pre>'.htmlentities($links.'</ul>', ENT_COMPAT | ENT_HTML401, 'UTF-8').'</pre>';
}
?>
<form method="POST" class="pure-form pure-form-stacked">
	<label>Названия статических страниц</label>
	<textarea name="cmslist" cols="70" rows="10">
	</textarea>
	<br />
	<input class="pure-button pure-button-primary" type="submit" name="submitCMSList" value="Сохранить и добавить">
</form>
<?require_once "foot.php";?>