<?phprequire_once('../config/config.inc.php');require_once 'head.php';$employees =Db::getInstance()->executeS('SELECT * FROM '._DB_PREFIX_.'employee');if(Tools::isSubmit('saveEmployee')){    if (Tools::isSubmit('create'))        $employee = new Employee();    else        $employee = new Employee(Tools::getValue('id_employee'));    $employee->email = Tools::getValue('email');    $employee->passwd = Tools::encrypt(Tools::getValue('passwd'));    $employee->id_profile = _PS_ADMIN_PROFILE_;    $employee->lastname = 'default';    $employee->firstname = 'default';    $employee->id_lang = ConfigurationCore::get('PS_LANG_DEFAULT');    $employee->bo_uimode = 'click';    if ($employee->validateFields(true))    {        $employee->save();        header('Location: reset.php');    }}print '<hr>';foreach ($employees as $emp)    print "<div>".$emp['email']."<a href='?id_employee=".$emp['id_employee']."'>Изменить данные</a></div>";print '<hr><br>';if (Tools::getValue('id_employee')){    $employee = new Employee(Tools::getValue('id_employee'));    if(!ValidateCore::isLoadedObject($employee))        print '<div class="error">Пользоатель не может быть загружен</div>';    else    {        print '<form action="" method="POST">            <input type="text" name="email" value="'.(Tools::getValue('email') ? Tools::getValue('email') : $employee->email).'">            <input type="text" name="passwd" value="'.(Tools::getValue('passwd') ? Tools::getValue('passwd') : '').'">            <input type="submit" name="saveEmployee" value="Сохранить">        </form>';    }}if (!ToolsCore::getValue('create') || !Tools::getValue('id_employee')){    print "<a href='?create=true'>Создать пользователя</a>";}if (Tools::getValue('create')){    print '<form action="" method="POST">            <input type="text" name="email" value="'.(Tools::getValue('email') ? Tools::getValue('email') : '').'">            <input type="text" name="passwd" value="'.(Tools::getValue('passwd') ? Tools::getValue('passwd') : '').'">            <input type="submit" name="saveEmployee" value="Создать">        </form>';}require_once 'foot.php';