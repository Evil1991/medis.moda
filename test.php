<?
require './config/config.inc.php';
/*
$cart  = new Cart;
$cart->id_customer = 7;
$cart->updateQty(1, 161);
$cart->id_address_delivery = $cart->id_address_invoice;

*/
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=cvit.doc');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: 20000000');
require_once _PS_MODULE_DIR_.'bankformcom/bankformcom.php';
echo BankFormCom::generateDOC(77); //Рендер накладной через модуль
?>