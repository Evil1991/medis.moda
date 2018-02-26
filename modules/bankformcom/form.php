<?php

include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/../../init.php');
require_once(dirname(__FILE__).'/func.php');
require_once(dirname(__FILE__).'/bankformcom.php');

if(!$id_order=Tools::getValue('id_order'))
	die('no id_order');

$order=new Order(intval($id_order));
$order_date = date("d m Y г.",strtotime($order->date_add));
if($order->id_customer!=$cookie->id_customer && !isset($_GET['view'])){
	Tools::redirect('authentication.php?back='.urlencode('modules\bankformcom\form.php?id_order=').$id_order);
}
$price1 = ceil($order->total_paid)." руб.";
$price2 = ceil($order->total_products_wt)." руб.";
$price3 = ceil($order->total_discounts)." руб.";

$products = $order->getProductsDetail();
$currency=new Currency($order->id_currency);

$bankform = new bankformcom();
		$smarty->assign(array(
			'bankform' => $bankform,
			'order_date' => $order_date));
		$smarty->assign(array(
			'id_order' => $order->id,
			'products' => $products,
			'total' => $price2,
			'total_discounts' => $price3,
			'total_str' => num2str($price2),
		));
if(Tools::getValue('pdf')){
    $html = $smarty->fetch(dirname(__FILE__).'/'.'form.tpl');
    include_once(_PS_TOOL_DIR_.'tcpdf/tcpdf.php');
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    // set document information
    //$pdf->SetCreator(PDF_CREATOR);
    //$pdf->SetAuthor('Nicola Asuni');
    $pdf->SetTitle('Накладная №'.$order->id);
    $pdf->SetSubject('');
    //$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

    // set default header data
    //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    //set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    //set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    //set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    //set some language-dependent strings
    //$pdf->setLanguageArray();

    // ---------------------------------------------------------

    // set font
    $pdf->setFontSubsetting(true);
    $pdf->setHeaderFont(Array('freeserif', '', 10, '', false));
    $pdf->setFooterFont(Array('freeserif', '', 8, '', false));
    $pdf->SetFont('freeserif', '', 10, '', false);

    // add a page
    $pdf->AddPage();

    // writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
    // writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

    // create some HTML content
    $html = $smarty->fetch(dirname(__FILE__).'/'.'form.tpl');

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');
    // reset pointer to the last page
    $pdf->lastPage();

    // ---------------------------------------------------------

    //Close and output PDF document
    $pdf->Output('/Nakladnaya №'.$order->id.'.pdf', 'I');
}else $smarty->display(dirname(__FILE__).'/'.'form.tpl');

?>