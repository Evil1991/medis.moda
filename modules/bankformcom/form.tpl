<html><head>
    <title>Счёт на оплату</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>

<body bgcolor="#FFFFFF" text="#000000">

<table style="font-size: small;" height="100" border="0" cellpadding="5" cellspacing="0" width="100%">
    <tbody>
    <tr>
        <td height="1" width="50%"></td>
        <td height="1" width="100%"><h3 align="right"><font face="Arial">
                    <b>{$bankform->company}</b></font></h3>
        </td>
    </tr>
    <tr>
        <td height="9" width="35	2">&nbsp; </td>
        <td height="9" width="614"><p align="right">{$bankform->address}<br>
                {$bankform->tel}, E-mail: <a href="mailto:{$bankform->email}">{$bankform->email}</a>
            </p></td>
    </tr>
    </tbody>
</table>

<hr noshade="noshade">

<table style="font-size: small;" width="983">
    <tbody><tr>
        <td width="115">ИНН: </td>
        <td width="860">{$bankform->inn}</td>
    </tr>
    <tr>
        <td width="115">КПП: </td>
        <td width="860">{$bankform->kpp}</td>
    </tr>
    <tr>
        <td width="115">Расчётный счёт:</td>
        <td width="860">{$bankform->account}</td>
    </tr>
    {if $bankform->bik}
        <tr>
            <td width="115">БИК:</td>
            <td width="860">{$bankform->bik}</td>
        </tr>
    {/if}
    {if $bankform->bank}
        <tr>
            <td width="115">Банк:</td>
            <td width="860">{$bankform->bank}</td>
        </tr>
    {/if}
    <tr>
        <td width="115">Кор. счёт</td>
        <td width="860">{$bankform->cor_account}</td>
    </tr>
    </tbody></table>

<h2 align="center"><font face="Arial">Счёт N {$id_order} от {$order_date}
    </font></h2>
<font face="Arial">
    <table style="font-size: small;">
        <tbody><tr>
            <td>Плательщик:</td><td><b><i></i></b></td>
        </tr><tr>
            <td>Адрес:</td><td><b><i></i></b></td>
        </tr></tbody>
    </table>
</font>
<table style="font-size: small;" border="1" cellpadding="1" width="100%">
    <tbody><tr>
        <td align="center" width="2%">N</td>
        <td align="center" width="50%">Наименование товара (описание выполненных работ, оказанных услуг) <sup>*</sup></td>
        <td align="center" width="4%">Кол-во</td>
        <td align="center" width="7%">Ед</td>
        <td align="center" width="10%">Стоимость</td>
        <td align="center" width="10%">НДС, 18%</td>
        <td align="center" width="10%">Сумма (руб)</td>
    </tr>
    {if $products}
        {foreach from=$products item=product}
            <tr>
                <td align="right" width="2%">1.</td>
                <td align="center" width="50%">{$product.product_name}</td>
                <td align="center" width="4%">{$product.product_quantity}</td>
                <td align="center" width="7%">шт.</td>
                <td align="right" width="10%">{displayPrice price=$product.product_price}</td>
                <td align="center" width="10%">-</td>
                <td align="right" width="10%">{displayPrice price=$product.product_price*$product.product_quantity}</td>
            </tr>
        {/foreach}
    {/if}
    <tr>
        <td colspan="2" align="right" width="52%"><b>Скидка:</b></td>
        <td align="center" width="4%">&nbsp;</td>
        <td align="center" width="7%">&nbsp;</td>
        <td align="right" width="10%">{$total_discounts}</td>
        <td align="center" width="10%">-</td>
        <td align="right" width="10%">{$total_discounts}</td>
    </tr>
    <tr>
        <td colspan="2" align="right" width="52%"><b>Итого начислено:</b></td>
        <td align="center" width="4%">&nbsp;</td>
        <td align="center" width="7%">&nbsp;</td>
        <td align="right" width="10%">{$total}</td>
        <td align="center" width="10%">-</td>
        <td align="right" width="10%">{$total}</td>
    </tr>
    </tbody>
</table>
<p align="left">
    <b>Итого к оплате: {$total}</b><br>
    <small>Сумма прописью:   <u>{$total_str}</u></small>
</p>
<table height="126" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody><tr>
        <td height="126" width="20%">
            Генеральный директор:
            <br><br>
            Главный бухгалтер:
        </td>
        <td height="126" width="20%">{if $bankform->stamp}<img src="{$bankform->stamp}">{/if}</td>

        <td height="126" width="20%">
            {$bankform->director}
            <br><br>
            {$bankform->buh}
        </td></tr>
    </tbody></table><br>
<i><small><sup>*</sup> Детализация услуг прилагается<br>
        !!! Убедительно просим оплачивать счета согласно позициям, расписывая услуги и сумму</small></i></body></html>