<?php
require_once(dirname(__FILE__).'/func.php');
class BankFormCom extends Module
{
	private $_html = '';
	private $_postErrors = array();

	public $company;
	public $address;
	public $tel;
	public $email;
	public $inn;
	public $kpp;
	public $account;
	public $bik;
	public $bank;
	public $cor_account;
	public $director;
	public $buh;
	public $stamp;

	public function __construct()
	{
		$this->name = 'bankformcom';
		$this->tab = 'Payment';
		$this->version = '0.1';
		$this->author = 'Joe icq 6662265';

		$config = Configuration::getMultiple(array('BF_company', 'BF_address','BF_stamp', 'BF_tel', 'BF_email', 'BF_inn', 'BF_kpp', 'BF_account', 'BF_bik', 'BF_bank','BF_cor_account','BF_director','BF_buh'));
		$this->company = @$config['BF_company'];
		$this->address = @$config['BF_address'];
		$this->tel = @$config['BF_tel'];
		$this->email = @$config['BF_email'];
		$this->inn = @$config['BF_inn'];
		$this->kpp = @$config['BF_kpp'];
		$this->account = @$config['BF_account'];
		$this->bik = @$config['BF_bik'];
		$this->bank = @$config['BF_bank'];
		$this->cor_account = @$config['BF_cor_account'];
		$this->director = @$config['BF_director'];
		$this->buh = @$config['BF_buh'];
		$this->stamp = @$config['BF_stamp'];

		parent::__construct();

		$this->displayName = $this->l('Банковская квитанция для юридических лиц.');
		$this->description = $this->l('Печать банковской квитанции');
	}

	public function install()
	{
		$this->registerHook('displayAdminOrder');
		$this->registerHook('displayOrderDetail');
		if (!parent::install())
			return false;
		return true;
	}

	public function uninstall()
	{
		if (Configuration::updateValue('BF_company')
			OR !Configuration::deleteByName('BF_address')
			OR !Configuration::deleteByName('BF_tel')
			OR !Configuration::deleteByName('BF_email')
			OR !Configuration::deleteByName('BF_inn')
			OR !Configuration::deleteByName('BF_kpp')
			OR !Configuration::deleteByName('BF_account')
			OR !Configuration::deleteByName('BF_bik')
			OR !Configuration::deleteByName('BF_bank')
			OR !Configuration::deleteByName('BF_cor_account')
			OR !Configuration::deleteByName('BF_director')
			OR !Configuration::deleteByName('BF_buh')
			OR !Configuration::deleteByName('BF_stamp')
			OR !parent::uninstall())
			return false;
		return true;
	}

	private function _postProcess()
	{
		if (isset($_POST['btnSubmit']))
		{
			Configuration::updateValue('BF_company', $_POST['company']);
			Configuration::updateValue('BF_address', $_POST['address']);
			Configuration::updateValue('BF_tel', $_POST['tel']);
			Configuration::updateValue('BF_email', $_POST['email']);
			Configuration::updateValue('BF_inn', $_POST['inn']);
			Configuration::updateValue('BF_kpp', $_POST['kpp']);
			Configuration::updateValue('BF_account', $_POST['account']);
			Configuration::updateValue('BF_bik', $_POST['bik']);
			Configuration::updateValue('BF_bank', $_POST['bank']);
			Configuration::updateValue('BF_cor_account', $_POST['cor_account']);
			Configuration::updateValue('BF_director', $_POST['director']);
			Configuration::updateValue('BF_buh', $_POST['buh']);
			Configuration::updateValue('BF_stamp', $_POST['stamp']);
		}
		$this->_html .= '<div class="conf confirm"><img src="../img/admin/ok.gif" alt="'.$this->l('ok').'" /> '.$this->l('Настройки обновлены').'</div>';
	}


	private function _displayForm()
	{
		$this->_html .=
		'
		<form style="float:right; width:200px; margin:15px; text-align:center;">
		</form>
<form action="'.$_SERVER['REQUEST_URI'].'" method="post">
			<fieldset>
			<legend><img src="../img/admin/contact.gif" />'.$this->l('Банковские реквизиты').'</legend>
				<table border="0" width="500" cellpadding="0" cellspacing="0" id="form">
					<tr><td colspan="2">'.$this->l('Введите реквизиты получателя платежа').'.<br /><br /></td></tr>
                <tr><td width="200" style="height: 35px;">Ваша фирма: </td><td><input type="text" name="company" value="'.htmlentities(Tools::getValue('company', $this->company), ENT_COMPAT, 'UTF-8').'" style="width: 300px;" /></td></tr>
                <tr><td width="200" style="height: 35px;">Адрес: </td><td><input type="text" name="address" value="'.htmlentities(Tools::getValue('address', $this->address), ENT_COMPAT, 'UTF-8').'" style="width: 300px;" /></td></tr>
                <tr><td width="200" style="height: 35px;">Телефон: </td><td><input type="text" name="tel" value="'.htmlentities(Tools::getValue('tel', $this->tel), ENT_COMPAT, 'UTF-8').'" style="width: 300px;" /></td></tr>
                <tr><td width="200" style="height: 35px;">Почта: </td><td><input type="text" name="email" value="'.htmlentities(Tools::getValue('email', $this->email), ENT_COMPAT, 'UTF-8').'" style="width: 300px;" /></td></tr>
                <tr><td width="200" style="height: 35px;">ИНН: </td><td><input type="text" name="inn" value="'.htmlentities(Tools::getValue('inn', $this->inn), ENT_COMPAT, 'UTF-8').'" style="width: 300px;" /></td></tr>
                <tr><td width="200" style="height: 35px;">КПП: </td><td><input type="text" name="kpp" value="'.htmlentities(Tools::getValue('kpp', $this->kpp), ENT_COMPAT, 'UTF-8').'" style="width: 300px;" /></td></tr>
                <tr><td width="200" style="height: 35px;">Рассчетный счет: </td><td><input type="text" name="account" value="'.htmlentities(Tools::getValue('account', $this->account), ENT_COMPAT, 'UTF-8').'" style="width: 300px;" /></td></tr>
                <tr><td width="200" style="height: 35px;">БИК: </td><td><input type="text" name="bik" value="'.htmlentities(Tools::getValue('bik', $this->bik), ENT_COMPAT, 'UTF-8').'" style="width: 300px;" /></td></tr>
                <tr><td width="200" style="height: 35px;">Банк: </td><td><input type="text" name="bank" value="'.htmlentities(Tools::getValue('bank', $this->bank), ENT_COMPAT, 'UTF-8').'" style="width: 300px;" /></td></tr>
                <tr><td width="200" style="height: 35px;">Корр. счет: </td><td><input type="text" name="cor_account" value="'.htmlentities(Tools::getValue('cor_account', $this->cor_account), ENT_COMPAT, 'UTF-8').'" style="width: 300px;" /></td></tr>
                <tr><td width="200" style="height: 35px;">Директор: </td><td><input type="text" name="director" value="'.htmlentities(Tools::getValue('director', $this->director), ENT_COMPAT, 'UTF-8').'" style="width: 300px;" /></td></tr>
                <tr><td width="200" style="height: 35px;">Бухгалтер: </td><td><input type="text" name="buh" value="'.htmlentities(Tools::getValue('buh', $this->buh), ENT_COMPAT, 'UTF-8').'" style="width: 300px;" /></td></tr>
                <tr><td width="200" style="height: 35px;">Ссылка на печать и подпись: </td><td><input type="text" name="stamp" value="'.htmlentities(Tools::getValue('stamp', $this->stamp), ENT_COMPAT, 'UTF-8').'" style="width: 300px;" /></td></tr>

					<tr><td colspan="2" align="center"><input class="button" name="btnSubmit" value="'.$this->l('Обновить').'" type="submit" /></td></tr>
				</table>
			</fieldset>
		</form>';
	}

	public function getContent()
	{
		$this->_html = '<h2>'.$this->displayName.'</h2>';

		if (!empty($_POST))
		{
			$this->_postProcess();
		}
		else
			$this->_html .= '<br />';

		$this->_displayForm();

		return $this->_html;
	}

	public static function assignVars($id_order){
		$order = new Order(intval($id_order));
		$customer = $order->getCustomer();
		$id_address = $order->id_address_delivery;
		$address = new Address($id_address);
		$order_date = date("d m Y г.",strtotime($order->date_add));
		$price1 = $order->total_paid;
		$price2 = $order->total_products_wt;
		$pric = explode('.', $price2);
		$total = explode('.', $price1);
		$add = explode('.', $order->total_shipping);
		$products = $order->getProductsDetail();
		$currency = new Currency($order->id_currency);
		$date = strtotime($order->date_upd);

		$bankform = new bankformcom();
		$context = Context::getContext();
		$context->smarty->assign(Array(
			'bankform' => $bankform,
			'order_date' => $order_date
		));
		$context->smarty->assign(array(
			'id_order' => $order->reference,
			'products' => $products,
			'prod1' => $pric[0],
			'prod2' => isset($pric[1])?$pric[1]:'00',
			'total1' => $total[0],
			'total2' => isset($total[1])?$total[1]:'00',
			'shipping1' => $add[0],
			'shipping2' => isset($add[1])?$add[1]:'00',
			'datem' => self::getMonthName($date),
			'datem_digit'=> date('m', $date),
			'dated' => date('d', $date),
			'datey' => date('Y', $date),
			'customer' => $customer,
			'address' => $address,
		));
		return $order->reference;
	}

	public static function generateDOC($id_order){
		include("html_to_doc.inc.php");
		$reference = self::assignVars($id_order);
		$context = Context::getContext();
		$htmltodoc= new HTML_TO_DOC();
		return $htmltodoc->createDoc($context->smarty->fetch(dirname(__FILE__).'/pd4.tpl'), "Заказ#".$reference, false);
	}
	
	public static function getMonthName($unixTimeStamp = false) {
	  
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

   public static function generatePDF($id_order){
        $order = new Order(intval($id_order));
        $order_date = date("d m Y г.",strtotime($order->date_add));
        $products = $order->getProductsDetail();
        $currency = new Currency($order->id_currency);

        $bankform = new bankformcom();
	   $context = Context::getContext();
	   $context->smarty->assign(
            Array(
            'bankform' => $bankform,
            'order_date' => $order_date
            )
        );
        $price1 = ceil($order->total_paid)." руб.";
        $price2 = ceil($order->total_products_wt)." руб.";

	   $context->smarty->assign(array(
            'id_order' => $order->id,
            'products' => $products,
            'total' => $price2,
            'total_str' => num2str($price2)
        ));

        $html = $context->smarty->fetch(dirname(__FILE__).'/'.'form.tpl');
        include_once(_PS_TOOL_DIR_.'tcpdf/tcpdf.php');
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetTitle('Счет №'.$order->id);
        $pdf->SetSubject('');
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->setFontSubsetting(true);
        $pdf->setHeaderFont(Array('freeserif', '', 10, '', false));
        $pdf->setFooterFont(Array('freeserif', '', 8, '', false));
        $pdf->SetFont('freeserif', '', 10, '', false);

        $pdf->AddPage();

        $html = $context->smarty->fetch(dirname(__FILE__).'/'.'form.tpl');

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->lastPage();

        return $pdf->Output('Nakladnaya №'.$order->id.'.pdf', 'S');
    }
	
	public function hookDisplayOrderDetail($params)
	{
		$id_order = $params['order']->id;
		return '<div class="bankformcom"><div class="row"><div class="col-xs-12 col-sm-6"><div class="alternate_item box"><div class="page-subheading">Файлы</div><ul><li><a target="_blank" href="/modules/bankformcom/pd4.php?id_order='.$id_order.'&doc=1">Квитанция ПД-4</a></li></ul></div></div></div></div>';
//		return '<div class="bankformcom"><div class="row"><div class="col-xs-12 col-sm-6"><div class="alternate_item box"><div class="page-subheading">Файлы</div><ul><li><a target="_blank" href="/modules/bankformcom/form.php?id_order='.$id_order.'&pdf=1">Квитанция ПД-4</a></li></ul></div></div></div></div>';
	}
	
	public function hookDisplayAdminOrder($params)
	{
		$id_order = $params['id_order'];
		return '<div id="bankformcom" class="row"><div class="col-lg-6"><div class="panel"><div class="panel-heading"><i class="icon-file-text"></i> Файлы</div><div class="well hidden-print"><a class="btn btn-default" target="_blank" href="/modules/bankformcom/apd4.php?id_order='.$id_order.'&doc=1">Квитанция ПД-4</a></div></div></div></div>';
//		return '<div id="bankformcom" class="row"><div class="col-lg-6"><div class="panel"><div class="panel-heading"><i class="icon-file-text"></i> Файлы</div><div class="well hidden-print"><a class="btn btn-default" target="_blank" href="/modules/bankformcom/form.php?id_order='.$id_order.'&pdf=1">Квитанция ПД-4</a></div></div></div></div>';
	}
	
//	public function hookDisplayOrderConfirmation($params)
//	{
//		$id_order = $params['objOrder']->id;
//		$script = '<script>$(document).ready(function(){$("#bankformcom").insertBefore(".cart_navigation")});</script>';
//		return $script.'<div id="bankformcom" class="box"><strong>Квитанция для оплаты.</strong><p><a target="_blank" class="button exclusive" href="/modules/bankformcom/pd4.php?id_order='.$id_order.'&doc=1">Скачать квитанцию для оплаты</a></p></div>';
//	}
}
