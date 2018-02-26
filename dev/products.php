<?
define('INSTALL_PATH', dirname(__FILE__));
require_once(INSTALL_PATH.'/../config/config.inc.php');
require_once(INSTALL_PATH.'/../init.php');
require_once(INSTALL_PATH.'/lib.php');
require_once "head.php";
$cats = Category::getSimpleCategories($cookie->id_lang);
if(Tools::isSubmit('submitProduct')){
	$product = new Product();
	$name = Tools::getValue('name');
	$product->name = createMultiLangField($name);
	$product->quantity = 100;
	$product->link_rewrite = createMultiLangField(Tools::link_rewrite($name));
	if($_POST['price1'] && $_POST['price1'] > 0 ){
		if($_POST['price2'] && $_POST['price2'] > $_POST['price1']) $price = rand($_POST['price1'], $_POST['price2']);
		else $price = $_POST['price1'];
		$product->price = $price;
	}
	if($_POST['id_category']){
		$product->id_category_default = $_POST['id_category'];
		$categories = Array(1, $_POST['id_category']);
	}
	
	$product->description = createMultiLangField(Tools::getValue('description'));
	$product->add();
	$product->addToCategories($categories);
	//var_dump($_FILES['image']);
	if($_FILES['image']['name']) addProductImage($product, 'auto', 'image');
	if($_FILES['image2']['name']) addProductImage($product, 'auto', 'image2');
	if($_FILES['image3']['name']) addProductImage($product, 'auto', 'image3');
	if($_FILES['image4']['name']) addProductImage($product, 'auto', 'image4');
	
	echo '<p class="success"><a href="'.$link->getProductLink($product).'">Добавлено</a></p>';
}
if(Tools::isSubmit('submitProductCopy')){
	for($i=1;$i<=$_POST['count'];$i++){
		if (Validate::isLoadedObject($product = new Product((int)(Tools::getValue('id_copy_product')))))
		{
			$id_product_old = $product->id;
			unset($product->id);
			unset($product->id_product);
			$product->name = createMultiLangField($product->name[$cookie->id_lang]." ".$i);
			$product->indexed = 0;
			$product->price = rand($product->price*0.7, $product->price*1.3);
			$product->active = 1;
			if ($product->add()
			AND Category::duplicateProductCategories($id_product_old, $product->id)
			AND ($combinationImages = Product::duplicateAttributes($id_product_old, $product->id)) !== false
			AND GroupReduction::duplicateReduction($id_product_old, $product->id)
			AND Product::duplicateAccessories($id_product_old, $product->id)
			AND Product::duplicateFeatures($id_product_old, $product->id)
			AND Product::duplicateSpecificPrices($id_product_old, $product->id)
			AND Pack::duplicate($id_product_old, $product->id)
			AND Product::duplicateCustomizationFields($id_product_old, $product->id)
			AND Product::duplicateTags($id_product_old, $product->id)
			AND Product::duplicateDownload($id_product_old, $product->id))
			{
				if ($product->hasAttributes())
					Product::updateDefaultAttribute($product->id);

				if (!Image::duplicateProductImages($id_product_old, $product->id, $combinationImages))
					$errors[] = Tools::displayError('An error occurred while copying images.');
				else
				{
					$images = $product->getWsImages();
					$newArray = Array();
					foreach($images as $id_image=>$smth){
						$newArray[] = $id_image;
						$product->setCoverWs($newArray[rand(0, count($newArray)-1)]);
					}
					Hook::addProduct($product);
					Search::indexation(false, $product->id);
				}
			}
			else
				$errors[] = Tools::displayError('An error occurred while creating object.');
		}
	}
	echo '<p class="success">'.$i.' добавлено</p>';
}
p($errors);
?>

<form method="POST" enctype="multipart/form-data"  class="pure-form pure-form-stacked">
	<label>Название товара</label><br />
	<input type="text" name="name" value="<?=@$_POST['name']?>" />
	<label>Цена</label>
	От <input type="text" name="price1" value="<?=@($_POST['price'] ? $_POST['price'] : '1550')?>" /> до <input type="text" name="price2" value="<?=@$_POST['price2']?>" /><br />
	<select name="id_category"><?
	foreach($cats as $cat) echo '<option value="'.$cat['id_category'].'">'.$cat['id_category'].':'.$cat['name'].'</option>';
	?></select><br />
	<label>Изображение</label>
	<input type="file" name="image" /><br />
	<label>Изображение 2</label>
	<input type="file" name="image2" /><br />
	<label>Изображение 3</label>
	<input type="file" name="image3" /><br />
	<label>Изображение 4</label>
	<input type="file" name="image4" /><br />
	Описание
	<textarea name="description" cols="70" rows="10"><?=@$_POST['description']?></textarea>
	<br />
	<input type="submit" name="submitProduct" class="pure-button pure-button-primary" value="Сохранить и добавить">
</form>
<br /><br />
<form method="POST" enctype="multipart/form-data"  class="pure-form pure-form-stacked">
<h3>Сделать копию товара</h3>
ID: <input type="text" name="id_copy_product" value="<?=$product->id?>">
<select name="count">
	<option>4</option><option>10</option><option>20</option>
</select>
<input type="submit" class="pure-button pure-button-primary" name="submitProductCopy" value="Растиражировать">
</form>

<?require_once "foot.php";?>