<?php

include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/../../init.php');
require_once(dirname(__FILE__).'/func.php');
require_once(dirname(__FILE__).'/bankformcom.php');

if(!$id_order=Tools::getValue('id_order'))
	die('no id_order');

BankFormCom::assignVars($id_order);

if(Tools::getValue('doc')){
	include("html_to_doc.inc.php");
	$htmltodoc= new HTML_TO_DOC();
	
	$htmltodoc->createDoc($smarty->fetch('pd4.tpl'), "Заказ#".$id_order, true);
	// $htmltodoc->createDocFromURL("http://shop.1mo.ru/modules/bankformcom/apd4.php?id_order=".$id_order, "Заказ#".$id_order, true);
}
$smarty->display(dirname(__FILE__).'/'.'pd4.tpl');


function getMonthName($unixTimeStamp = false) {
  
  // Если не задано время в UNIX, то используем текущий
  if (!$unixTimeStamp) {
    $mN = date('m');
  
  
  // Если задано определяем месяц времени
  } else {
    $mN = date('m', (int)$unixTimeStamp);
  }
  
  
  $monthAr = array(
    1 => 'Января',
    2 => 'Февраля',
    3 => 'Марта',
    4 => 'Апреля',
    5 => 'Мая',
    6 => 'Июня',
    7 => 'Июля',
    8 => 'Августа',
    9 => 'Сентября',
    10=> 'Октября',
    11=> 'Ноября',
    12=> 'Декабря'
  );
  
  return $monthAr[(int)$mN];
}
?>