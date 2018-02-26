<html lang="ru"><head>
  <title>Форма ПД-4 -- распечатка</title>
  <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">

</head><body style="FONT-FAMILY: sans-serif; FONT-SIZE: 8pt">

<table style="FONT-FAMILY: sans-serif; FONT-SIZE: 8pt" align="center" border="0" cellpadding="0" cellspacing="0"><tbody><tr><td>
<table style="FONT-FAMILY: sans-serif; FONT-SIZE: 8pt;BORDER-TOP: black 2px solid; BORDER-BOTTOM: black 2px solid; BORDER-LEFT: black 2px solid; BORDER-RIGHT: black 2px solid" align="center" border="0" cellpadding="0"
cellspacing="0">
  <tbody>
  <tr>
    <td style="BORDER-BOTTOM: black 2px solid" align="center" height="245" width="188">
      <table style="FONT-FAMILY: sans-serif; FONT-SIZE: 8pt" border="0" cellpadding="0" cellspacing="0">
		<tbody>
			<tr><td style="FONT-WEIGHT: bold; FONT-SIZE: 10pt; FONT-FAMILY: 'Times New Roman', serif" align="center" height="100" valign="top">И з в е щ е н и е</td></tr>
			<tr><td style="FONT-WEIGHT: bold; FONT-SIZE: 10pt; FONT-FAMILY: 'Times New Roman', serif" align="center" height="100" valign="bottom">Кассир</td></tr>
      	</tbody>
	  </table>
    </td>
    <td style="BORDER-BOTTOM: black 2px solid; BORDER-LEFT: black 2px solid" height="245" width="16">&nbsp;</td>
    <td style="BORDER-BOTTOM: black 2px solid" height="245">
      <table style="height: 245px;FONT-FAMILY: sans-serif; FONT-SIZE: 8pt" align="center" border="0"
cellpadding="0" cellspacing="0" width="477">
	<tbody><tr>
	  <td height="40">
	    <table style="FONT-FAMILY: sans-serif; FONT-SIZE: 8pt" align="center" border="0" cellpadding="0" cellspacing="0"
width="100%">
	      <tbody><tr>
		<td>&nbsp;</td>
		<td style="FONT-SIZE: 6.5pt; FONT-FAMILY: 'Times New Roman', serif" align="right" valign="middle"><i>Форма № ПД-4</i></td>
	      </tr>
	    </tbody></table>
	  </td>
	</tr>
	<tr>
	  <td style="FONT-WEIGHT: bold; FONT-SIZE: 6.3pt; FONT-FAMILY: Arial, sans-serif;BORDER-BOTTOM: black 1px solid; TEXT-ALIGN: center" align="center" valign="bottom"><p align="center">{$bankform->company}</p></td>
	</tr>
	<tr>
	  <td style="FONT-SIZE: 6.5pt; FONT-FAMILY: 'Times New Roman', serif" align="center" height="10" valign="top">(наименование получателя платежа)</td>
	</tr>
	<tr>
	  <td>
	    <table style="FONT-FAMILY: sans-serif; FONT-SIZE: 8pt" border="0" cellpadding="0" cellspacing="0" width="100%">
	      <tbody><tr>
		<td valign="bottom" width="35%">
		  <table style="FONT-FAMILY: sans-serif; FONT-SIZE: 8pt" border="0" cellpadding="0" cellspacing="0" width="100%">
		    <tbody><tr><!-- ИНН -->
				{foreach from=str_split($bankform->inn) item=letter name=inn}
				<td style="BORDER-LEFT: black 1px solid; BORDER-BOTTOM: black 1px solid;BORDER-TOP: black 1px solid; FONT-WEIGHT: bold;{if $smarty.foreach.inn.last}BORDER-RIGHT: black 1px solid;{/if}" align="center" height="10" width="13px">{$letter}</td>
				{/foreach}
		    </tr>
		  </tbody></table>
		</td>
		<td valign="bottom" width="5%">&nbsp;</td>
		<td valign="bottom" width="60%">
		  <table style="FONT-FAMILY: sans-serif; FONT-SIZE: 8pt" border="0" cellpadding="0" cellspacing="0" width="100%">
		    <tbody><tr><!-- Номер счета -->
			{foreach from=str_split($bankform->account) name=acc item=letter}
		      <td style="BORDER-LEFT: black 1px solid; BORDER-BOTTOM: black 1px solid;BORDER-TOP: black 1px solid; FONT-WEIGHT: bold;{if $smarty.foreach.acc.last}BORDER-RIGHT: black 1px solid;{/if}" align="center" height="10" width="5%">{$letter}</td>
			{/foreach}
			</tr>
		  </tbody></table>
		</td>
	      </tr>
	      <tr>
		<td style="FONT-SIZE: 6.5pt; FONT-FAMILY: 'Times New Roman', serif" align="center" valign="top">(ИНН получателя платежа)</td>
		<td style="FONT-SIZE: 6.5pt; FONT-FAMILY: 'Times New Roman', serif" valign="top">&nbsp;</td>
		<td style="FONT-SIZE: 6.5pt; FONT-FAMILY: 'Times New Roman', serif" align="center" valign="top">(номер счета получателя платежа)</td>
	      </tr>
	    </tbody></table>
	  </td>
	</tr>
	<tr>
	  <td>
	  <table style="FONT-FAMILY: sans-serif; FONT-SIZE: 8pt" border="0" cellpadding="0" cellspacing="0" width="100%">
	    <tbody><tr>
	      <td style="FONT-SIZE: 8.5pt; FONT-FAMILY: 'Times New Roman', serif" valign="bottom" width="10">в</td>
	      <td style="FONT-WEIGHT: bold; FONT-SIZE: 6.3pt; FONT-FAMILY: Arial, sans-serif;BORDER-BOTTOM: black 1px solid; TEXT-ALIGN: center" align="center" valign="bottom">{$bankform->bank}</td>
	      <td style="FONT-SIZE: 8.5pt; FONT-FAMILY: 'Times New Roman', serif" align="right" valign="bottom" width="40">БИК&nbsp;</td>
	      <td valign="bottom" width="27%">
		<table style="FONT-FAMILY: sans-serif; FONT-SIZE: 8pt" border="0" cellpadding="0" cellspacing="0" width="100%">
		  <tbody><tr><!-- БИК -->
		  {foreach name=bik item=letter from=str_split($bankform->bik)}
		  <td style="BORDER-LEFT: black 1px solid; BORDER-BOTTOM: black 1px solid;BORDER-TOP: black 1px solid; FONT-WEIGHT: bold;{if $smarty.foreach.bik.last}BORDER-RIGHT: black 1px solid;{/if}" align="center" height="10" width="10%">{$letter}</td>
		  {/foreach}
		 </tr>
		</tbody></table>
	      </td>
	    </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td style="FONT-SIZE: 6.5pt; FONT-FAMILY: 'Times New Roman', serif" align="center" valign="top">(наименование банка получателя платежа)</td>
	      <td>&nbsp;</td>
	      <td>&nbsp;</td>
	    </tr>
	  </tbody></table>
	</td>
	</tr>
	<tr>
	  <td>
	    <table style="FONT-FAMILY: sans-serif; FONT-SIZE: 8pt" border="0" cellpadding="0" cellspacing="0" width="100%">
	      <tbody><tr>
		<td style="FONT-SIZE: 7.5pt; FONT-FAMILY: 'Times New Roman', serif" valign="bottom">Номер&nbsp;кор./сч.&nbsp;банка&nbsp;получателя&nbsp;платежа</td>
		<td valign="bottom" width="60%">
		  <table style="FONT-FAMILY: sans-serif; FONT-SIZE: 8pt" border="0" cellpadding="0" cellspacing="0" width="100%">
		    <tbody><tr><!-- Кор.сч. -->
			{foreach name=cor item=letter from=str_split($bankform->cor_account)}
			  <td style="BORDER-LEFT: black 1px solid; BORDER-BOTTOM: black 1px solid;BORDER-TOP: black 1px solid; FONT-WEIGHT: bold;{if $smarty.foreach.cor.last}BORDER-RIGHT: black 1px solid;{/if}" align="center" height="10" width="{100/count(str_split($bankform->cor_account))}%">{$letter}</td>
			{/foreach}
			</tr>
		  </tbody></table>
		</td>
	      </tr>
	    </tbody></table>
	  </td>
	</tr>
	<tr>
	  <td>
	    <table style="FONT-FAMILY: sans-serif; FONT-SIZE: 8pt" border="0" cellpadding="0" cellspacing="0" width="100%">
	      <tbody><tr>
			  <td style="FONT-WEIGHT: bold; FONT-SIZE: 6.3pt; FONT-FAMILY: Arial, sans-serif;BORDER-BOTTOM: black 1px solid; TEXT-ALIGN: center" valign="bottom" width="55%">Оплата заказа № {$id_order} от {$dated}.{$datem_digit}.{$datey} Без НДС</td>
		<td width="5%">&nbsp;</td>
		<td style="FONT-WEIGHT: bold; FONT-SIZE: 6.3pt; FONT-FAMILY: Arial, sans-serif;BORDER-BOTTOM: black 1px solid; TEXT-ALIGN: center" valign="bottom"></td>
	      </tr>
	      <tr>
		<td style="FONT-SIZE: 6.5pt; FONT-FAMILY: 'Times New Roman', serif" align="center" valign="top">(наименование платежа)</td>
		<td>&nbsp;</td>
		<td style="FONT-SIZE: 6.5pt; FONT-FAMILY: 'Times New Roman', serif" align="center" valign="top">(номер лицевого счета (код) плательщика)</td>
	      </tr>
	    </tbody></table>
	  </td>
	</tr>
	<tr>
	  <td>
	    <table style="FONT-FAMILY: sans-serif; FONT-SIZE: 8pt" border="0" cellpadding="0" cellspacing="0" width="100%">
	      <tbody><tr>
		<td style="FONT-SIZE: 8.5pt; FONT-FAMILY: 'Times New Roman', serif" valign="bottom" width="1%">Ф.И.О&nbsp;плательщика&nbsp;</td>
		<td style="FONT-WEIGHT: bold; FONT-SIZE: 6.3pt; FONT-FAMILY: Arial, sans-serif;BORDER-BOTTOM: black 1px solid; TEXT-ALIGN: center" valign="bottom">{$customer->lastname} {$customer->firstname}</td>
	      </tr>
	    </tbody></table>
	  </td>
	</tr>
	<tr>
	  <td>
	    <table style="FONT-FAMILY: sans-serif; FONT-SIZE: 8pt" border="0" cellpadding="0" cellspacing="0" width="100%">
	      <tbody><tr>
		<td style="FONT-SIZE: 8.5pt; FONT-FAMILY: 'Times New Roman', serif" valign="bottom" width="1%">Адрес&nbsp;плательщика&nbsp;</td>
		<td style="FONT-WEIGHT: bold; FONT-SIZE: 6.3pt; FONT-FAMILY: Arial, sans-serif;BORDER-BOTTOM: black 1px solid; TEXT-ALIGN: center" valign="bottom">г.{$address->city} {$address->address1}</td>
	      </tr>
	    </tbody></table>
	  </td>
	</tr>
	<tr>
	  <td>
	    <table style="FONT-FAMILY: sans-serif; FONT-SIZE: 8pt" border="0" cellpadding="0" cellspacing="0" width="100%">
	      <tbody><tr>
		<td style="FONT-SIZE: 8.5pt; FONT-FAMILY: 'Times New Roman', serif" valign="bottom" width="1%">Сумма&nbsp;платежа&nbsp;</td>
		<td style="FONT-WEIGHT: bold; FONT-SIZE: 6.3pt; FONT-FAMILY: Arial, sans-serif;BORDER-BOTTOM: black 1px solid; TEXT-ALIGN: center" valign="bottom" width="8%">{$total1}</td>
		<td style="FONT-SIZE: 8.5pt; FONT-FAMILY: 'Times New Roman', serif" valign="bottom" width="1%">&nbsp;руб.&nbsp;</td>
		<td style="FONT-WEIGHT: bold; FONT-SIZE: 6.3pt; FONT-FAMILY: Arial, sans-serif;BORDER-BOTTOM: black 1px solid; TEXT-ALIGN: center" valign="bottom" width="8%">{$total2}</td>
		<td style="FONT-SIZE: 8.5pt; FONT-FAMILY: 'Times New Roman', serif" valign="bottom" width="1%">&nbsp;коп.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Сумма&nbsp;платы&nbsp;за&nbsp;услуги&nbsp;</td>
		<td style="FONT-WEIGHT: bold; FONT-SIZE: 6.3pt; FONT-FAMILY: Arial, sans-serif;BORDER-BOTTOM: black 1px solid; TEXT-ALIGN: center" valign="bottom" width="8%"></td>
		<td style="FONT-SIZE: 8.5pt; FONT-FAMILY: 'Times New Roman', serif" valign="bottom" width="1%">&nbsp;руб.&nbsp;</td>
		<td style="FONT-WEIGHT: bold; FONT-SIZE: 6.3pt; FONT-FAMILY: Arial, sans-serif;BORDER-BOTTOM: black 1px solid; TEXT-ALIGN: center" valign="bottom" width="8%"></td>
		<td style="FONT-SIZE: 8.5pt; FONT-FAMILY: 'Times New Roman', serif" valign="bottom" width="1%">&nbsp;коп.</td>
	      </tr>
	    </tbody></table>
	  </td>
	</tr>
	<tr>
	  <td>
	    <table style="FONT-FAMILY: sans-serif; FONT-SIZE: 8pt" border="0" cellpadding="0" cellspacing="0" width="100%">
	      <tbody><tr>
		<td style="FONT-SIZE: 8.5pt; FONT-FAMILY: 'Times New Roman', serif" valign="bottom" width="5%">Итого&nbsp;</td>
		<td style="FONT-WEIGHT: bold; FONT-SIZE: 6.3pt; FONT-FAMILY: Arial, sans-serif;BORDER-BOTTOM: black 1px solid; TEXT-ALIGN: center" valign="bottom" width="8%"></td>
		<td style="FONT-SIZE: 8.5pt; FONT-FAMILY: 'Times New Roman', serif" valign="bottom" width="5%">&nbsp;руб.&nbsp;</td>
		<td style="FONT-WEIGHT: bold; FONT-SIZE: 6.3pt; FONT-FAMILY: Arial, sans-serif;BORDER-BOTTOM: black 1px solid; TEXT-ALIGN: center" valign="bottom" width="8%"></td>
		<td style="FONT-SIZE: 8.5pt; FONT-FAMILY: 'Times New Roman', serif" valign="bottom" width="5%">&nbsp;коп.&nbsp;</td>
		<td style="FONT-SIZE: 8.5pt; FONT-FAMILY: 'Times New Roman', serif" align="right" valign="bottom" width="20%">&nbsp;"&nbsp;</td>
		<td style="FONT-WEIGHT: bold; FONT-SIZE: 6.3pt; FONT-FAMILY: Arial, sans-serif;BORDER-BOTTOM: black 1px solid; TEXT-ALIGN: center" valign="bottom" width="8%">{$dated}</td>
		<td style="FONT-SIZE: 8.5pt; FONT-FAMILY: 'Times New Roman', serif" valign="bottom" width="1%">&nbsp;"&nbsp;</td>
		<td style="FONT-WEIGHT: bold; FONT-SIZE: 6.3pt; FONT-FAMILY: Arial, sans-serif;BORDER-BOTTOM: black 1px solid; TEXT-ALIGN: center" valign="bottom" width="20%">{$datem}</td>
		<td style="FONT-SIZE: 8.5pt; FONT-FAMILY: 'Times New Roman', serif" valign="bottom" width="1%">&nbsp;&nbsp;</td>
		<td style="FONT-WEIGHT: bold; FONT-SIZE: 6.3pt; FONT-FAMILY: Arial, sans-serif;BORDER-BOTTOM: black 1px solid; TEXT-ALIGN: center" valign="bottom" width="8%">{$datey}</td>
		<td style="FONT-SIZE: 8.5pt; FONT-FAMILY: 'Times New Roman', serif" valign="bottom" width="1%">&nbsp;г.</td>
	      </tr>
	    </tbody></table>
	  </td>
	</tr>
	<tr>
	  <td style="FONT-SIZE: 6.5pt; FONT-FAMILY: 'Times New Roman', serif;text-align: justify" valign="bottom">С условиями приема указанной в платежном документе суммы, в т.ч. с суммой взимаемой платы за&nbsp;услуги банка,&nbsp;ознакомлен&nbsp;и&nbsp;согласен.</td>
	</tr>
	<tr>
	  <td>
	    <table style="FONT-FAMILY: sans-serif; FONT-SIZE: 8pt" border="0" cellpadding="0" cellspacing="0" width="100%">
	      <tbody><tr>
			<td style="FONT-SIZE: 6.5pt; FONT-FAMILY: 'Times New Roman', serif" valign="bottom" width="50%">&nbsp;</td>
			<td style="FONT-SIZE: 7.5pt; FONT-FAMILY: 'Times New Roman', serif" valign="bottom" width="1%"><b>Подпись&nbsp;плательщика&nbsp;</b></td>
			<td style="FONT-WEIGHT: bold; FONT-SIZE: 6.3pt; FONT-FAMILY: Arial, sans-serif;BORDER-BOTTOM: black 1px solid; TEXT-ALIGN: center" valign="bottom" width="40%">&nbsp;</td>
	      </tr>
	    </tbody></table>
	  </td>
	</tr>
	<tr><td style="FONT-SIZE: 1pt" height="1">&nbsp;</td></tr>
      </tbody></table>
    </td>
    <td style="BORDER-BOTTOM: black 2px solid" height="245" width="16">&nbsp;</td>
  </tr>
  <tr>
	  <td style="" align="center" height="245" width="188">
		  <table style="FONT-FAMILY: sans-serif; FONT-SIZE: 8pt" border="0" cellpadding="0" cellspacing="0">
			  <tbody>
			  <tr><td style="FONT-WEIGHT: bold; FONT-SIZE: 10pt; FONT-FAMILY: 'Times New Roman', serif" align="center" height="100" valign="top">К в и т а н ц и я</td></tr>
			  <tr><td style="FONT-WEIGHT: bold; FONT-SIZE: 10pt; FONT-FAMILY: 'Times New Roman', serif" align="center" height="100" valign="bottom">Кассир</td></tr>
			  </tbody>
		  </table>
	  </td>
    <td style="BORDER-LEFT: black 2px solid" height="285" width="16">&nbsp;</td>
    <td height="245" valign="top">
      <table style="height: 285px;FONT-FAMILY: sans-serif; FONT-SIZE: 8pt" align="center" border="0" cellpadding="0" cellspacing="0" width="477">
	<tbody><tr>
		<td style="FONT-WEIGHT: bold; FONT-SIZE: 6.3pt; FONT-FAMILY: Arial, sans-serif;BORDER-BOTTOM: black 1px solid; TEXT-ALIGN: center" align="center" height="30" valign="bottom">
			<p align="center">{$bankform->company}</p>
		</td>
	</tr>
	<tr>
	  <td style="FONT-SIZE: 6.5pt; FONT-FAMILY: 'Times New Roman', serif" align="center" height="10" valign="top">(наименование получателя платежа)</td>
	</tr>
	<tr>
	  <td>
	    <table style="FONT-FAMILY: sans-serif; FONT-SIZE: 8pt" border="0" cellpadding="0" cellspacing="0" width="100%">
	      <tbody><tr>
		<td valign="bottom" width="35%">
		  <table style="FONT-FAMILY: sans-serif; FONT-SIZE: 8pt" border="0" cellpadding="0" cellspacing="0" width="100%">
		    <tbody><tr><!-- ИНН -->
				{foreach from=str_split($bankform->inn) item=letter name=inn}
				<td style="BORDER-LEFT: black 1px solid; BORDER-BOTTOM: black 1px solid;BORDER-TOP: black 1px solid; FONT-WEIGHT: bold;{if $smarty.foreach.inn.last}BORDER-RIGHT: black 1px solid;{/if}" align="center" height="10" width="13px">{$letter}</td>
				{/foreach}</tr>
		  </tbody></table>
		</td>
		<td valign="bottom" width="5%">&nbsp;</td>
		<td valign="bottom" width="60%">
		  <table style="FONT-FAMILY: sans-serif; FONT-SIZE: 8pt" border="0" cellpadding="0" cellspacing="0" width="100%">
		    <tbody><tr><!-- Номер счета -->
			{foreach from=str_split($bankform->account) name=acc item=letter}
		      <td style="BORDER-LEFT: black 1px solid; BORDER-BOTTOM: black 1px solid;BORDER-TOP: black 1px solid; FONT-WEIGHT: bold;{if $smarty.foreach.acc.last}BORDER-RIGHT: black 1px solid;{/if}" align="center" height="10" width="5%">{$letter}</td>
			{/foreach}</tr>
		  </tbody></table>
		</td>
	      </tr>
	      <tr>
		<td style="FONT-SIZE: 6.5pt; FONT-FAMILY: 'Times New Roman', serif" align="center" valign="top">(ИНН получателя платежа)</td>
		<td style="FONT-SIZE: 6.5pt; FONT-FAMILY: 'Times New Roman', serif" valign="top">&nbsp;</td>
		<td style="FONT-SIZE: 6.5pt; FONT-FAMILY: 'Times New Roman', serif" align="center" valign="top">(номер счета получателя платежа)</td>
	      </tr>
	    </tbody></table>
	  </td>
	</tr>
	<tr>
	  <td>
	  <table style="FONT-FAMILY: sans-serif; FONT-SIZE: 8pt" border="0" cellpadding="0" cellspacing="0" width="100%">
	    <tbody><tr>
	      <td style="FONT-SIZE: 8.5pt; FONT-FAMILY: 'Times New Roman', serif" valign="bottom" width="10">в</td>
	      <td style="FONT-WEIGHT: bold; FONT-SIZE: 6.3pt; FONT-FAMILY: Arial, sans-serif;BORDER-BOTTOM: black 1px solid; TEXT-ALIGN: center" align="center" valign="bottom">{$bankform->bank}</td>
	      <td style="FONT-SIZE: 8.5pt; FONT-FAMILY: 'Times New Roman', serif" align="right" valign="bottom" width="40">БИК&nbsp;</td>
	      <td valign="bottom" width="27%">
		<table style="FONT-FAMILY: sans-serif; FONT-SIZE: 8pt" border="0" cellpadding="0" cellspacing="0" width="100%">
		  <tbody><tr><!-- БИК -->
		   {foreach name=bik item=letter from=str_split($bankform->bik)}
		  <td style="BORDER-LEFT: black 1px solid; BORDER-BOTTOM: black 1px solid;BORDER-TOP: black 1px solid; FONT-WEIGHT: bold;{if $smarty.foreach.bik.last}BORDER-RIGHT: black 1px solid;{/if}" align="center" height="10" width="10%">{$letter}</td>
		  {/foreach} </tr>
		</tbody></table>
	      </td>
	    </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td style="FONT-SIZE: 6.5pt; FONT-FAMILY: 'Times New Roman', serif" align="center" valign="top">(наименование банка получателя платежа)</td>
	      <td>&nbsp;</td>
	      <td>&nbsp;</td>
	    </tr>
	  </tbody></table>
	</td>
	</tr>
	<tr>
	  <td>
	    <table style="FONT-FAMILY: sans-serif; FONT-SIZE: 8pt" border="0" cellpadding="0" cellspacing="0" width="100%">
	      <tbody><tr>
		<td style="FONT-SIZE: 7.5pt; FONT-FAMILY: 'Times New Roman', serif" valign="bottom">Номер&nbsp;кор./сч.&nbsp;банка&nbsp;получателя&nbsp;платежа</td>
		<td valign="bottom" width="60%">
		  <table style="FONT-FAMILY: sans-serif; FONT-SIZE: 8pt" border="0" cellpadding="0" cellspacing="0" width="100%">
		    <tbody><tr><!-- Кор.сч. -->
			{foreach name=cor item=letter from=str_split($bankform->cor_account)}
			  <td style="BORDER-LEFT: black 1px solid; BORDER-BOTTOM: black 1px solid;BORDER-TOP: black 1px solid; FONT-WEIGHT: bold;{if $smarty.foreach.cor.last}BORDER-RIGHT: black 1px solid;{/if}" align="center" height="10" width="{100/count(str_split($bankform->cor_account))}%">{$letter}</td>
			{/foreach}
			</tr>
		  </tbody></table>
		</td>
	      </tr>
	    </tbody></table>
	  </td>
	</tr>
	<tr>
	  <td>
	    <table style="FONT-FAMILY: sans-serif; FONT-SIZE: 8pt" border="0" cellpadding="0" cellspacing="0" width="100%">
	      <tbody><tr>
		<td style="FONT-WEIGHT: bold; FONT-SIZE: 6.3pt; FONT-FAMILY: Arial, sans-serif;BORDER-BOTTOM: black 1px solid; TEXT-ALIGN: center" valign="bottom" width="55%">Оплата заказа № {$id_order} от {$dated}.{$datem_digit}.{$datey} Без НДС</td>
		<td width="5%">&nbsp;</td>
		<td style="FONT-WEIGHT: bold; FONT-SIZE: 6.3pt; FONT-FAMILY: Arial, sans-serif;BORDER-BOTTOM: black 1px solid; TEXT-ALIGN: center" valign="bottom"></td>
	      </tr>
	      <tr>
		<td style="FONT-SIZE: 6.5pt; FONT-FAMILY: 'Times New Roman', serif" align="center" valign="top">(наименование платежа)</td>
		<td>&nbsp;</td>
		<td style="FONT-SIZE: 6.5pt; FONT-FAMILY: 'Times New Roman', serif" align="center" valign="top">(номер лицевого счета (код) плательщика)</td>
	      </tr>
	    </tbody></table>
	  </td>
	</tr>
	<tr>
	  <td>
	    <table style="FONT-FAMILY: sans-serif; FONT-SIZE: 8pt" border="0" cellpadding="0" cellspacing="0" width="100%">
	      <tbody><tr>
		<td style="FONT-SIZE: 8.5pt; FONT-FAMILY: 'Times New Roman', serif" valign="bottom" width="1%">Ф.И.О&nbsp;плательщика&nbsp;</td>
		<td style="FONT-WEIGHT: bold; FONT-SIZE: 6.3pt; FONT-FAMILY: Arial, sans-serif;BORDER-BOTTOM: black 1px solid; TEXT-ALIGN: center" valign="bottom">{$customer->lastname} {$customer->firstname}</td>
	      </tr>
	    </tbody></table>
	  </td>
	</tr>
	<tr>
	  <td>
	    <table style="FONT-FAMILY: sans-serif; FONT-SIZE: 8pt" border="0" cellpadding="0" cellspacing="0" width="100%">
	      <tbody><tr>
		<td style="FONT-SIZE: 8.5pt; FONT-FAMILY: 'Times New Roman', serif" valign="bottom" width="1%">Адрес&nbsp;плательщика&nbsp;</td>
		<td style="FONT-WEIGHT: bold; FONT-SIZE: 6.3pt; FONT-FAMILY: Arial, sans-serif;BORDER-BOTTOM: black 1px solid; TEXT-ALIGN: center" valign="bottom">г.{$address->city} {$address->address1}</td>
	      </tr>
	    </tbody></table>
	  </td>
	</tr>
	<tr>
	  <td>
	    <table style="FONT-FAMILY: sans-serif; FONT-SIZE: 8pt" border="0" cellpadding="0" cellspacing="0" width="100%">
	      <tbody><tr>
		<td style="FONT-SIZE: 8.5pt; FONT-FAMILY: 'Times New Roman', serif" valign="bottom" width="1%">Сумма&nbsp;платежа&nbsp;</td>
		<td style="FONT-WEIGHT: bold; FONT-SIZE: 6.3pt; FONT-FAMILY: Arial, sans-serif;BORDER-BOTTOM: black 1px solid; TEXT-ALIGN: center" valign="bottom" width="8%">{$total1}</td>
		<td style="FONT-SIZE: 8.5pt; FONT-FAMILY: 'Times New Roman', serif" valign="bottom" width="1%">&nbsp;руб.&nbsp;</td>
		<td style="FONT-WEIGHT: bold; FONT-SIZE: 6.3pt; FONT-FAMILY: Arial, sans-serif;BORDER-BOTTOM: black 1px solid; TEXT-ALIGN: center" valign="bottom" width="8%">{$total2}</td>
		<td style="FONT-SIZE: 8.5pt; FONT-FAMILY: 'Times New Roman', serif" valign="bottom" width="1%">&nbsp;коп.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Сумма&nbsp;платы&nbsp;за&nbsp;услуги&nbsp;</td>
		<td style="FONT-WEIGHT: bold; FONT-SIZE: 6.3pt; FONT-FAMILY: Arial, sans-serif;BORDER-BOTTOM: black 1px solid; TEXT-ALIGN: center" valign="bottom" width="8%"></td>
		<td style="FONT-SIZE: 8.5pt; FONT-FAMILY: 'Times New Roman', serif" valign="bottom" width="1%">&nbsp;руб.&nbsp;</td>
		<td style="FONT-WEIGHT: bold; FONT-SIZE: 6.3pt; FONT-FAMILY: Arial, sans-serif;BORDER-BOTTOM: black 1px solid; TEXT-ALIGN: center" valign="bottom" width="8%"></td>
		<td style="FONT-SIZE: 8.5pt; FONT-FAMILY: 'Times New Roman', serif" valign="bottom" width="1%">&nbsp;коп.</td>
	      </tr>
	    </tbody></table>
	  </td>
	</tr>
	<tr>
	  <td>
	    <table style="FONT-FAMILY: sans-serif; FONT-SIZE: 8pt" border="0" cellpadding="0" cellspacing="0" width="100%">
	      <tbody><tr>
		<td style="FONT-SIZE: 8.5pt; FONT-FAMILY: 'Times New Roman', serif" valign="bottom" width="5%">Итого&nbsp;</td>
		<td style="FONT-WEIGHT: bold; FONT-SIZE: 6.3pt; FONT-FAMILY: Arial, sans-serif;BORDER-BOTTOM: black 1px solid; TEXT-ALIGN: center" valign="bottom" width="8%"></td>
		<td style="FONT-SIZE: 8.5pt; FONT-FAMILY: 'Times New Roman', serif" valign="bottom" width="5%">&nbsp;руб.&nbsp;</td>
		<td style="FONT-WEIGHT: bold; FONT-SIZE: 6.3pt; FONT-FAMILY: Arial, sans-serif;BORDER-BOTTOM: black 1px solid; TEXT-ALIGN: center" valign="bottom" width="8%"></td>
		<td style="FONT-SIZE: 8.5pt; FONT-FAMILY: 'Times New Roman', serif" valign="bottom" width="5%">&nbsp;коп.&nbsp;</td>
		<td style="FONT-SIZE: 8.5pt; FONT-FAMILY: 'Times New Roman', serif" align="right" valign="bottom" width="20%">&nbsp;"&nbsp;</td>
		<td style="FONT-WEIGHT: bold; FONT-SIZE: 6.3pt; FONT-FAMILY: Arial, sans-serif;BORDER-BOTTOM: black 1px solid; TEXT-ALIGN: center" valign="bottom" width="8%">{$dated}</td>
		<td style="FONT-SIZE: 8.5pt; FONT-FAMILY: 'Times New Roman', serif" valign="bottom" width="1%">&nbsp;"&nbsp;</td>
		<td style="FONT-WEIGHT: bold; FONT-SIZE: 6.3pt; FONT-FAMILY: Arial, sans-serif;BORDER-BOTTOM: black 1px solid; TEXT-ALIGN: center" valign="bottom" width="20%">{$datem}</td>
		<td style="FONT-SIZE: 8.5pt; FONT-FAMILY: 'Times New Roman', serif" valign="bottom" width="1%">&nbsp;&nbsp;</td>
		<td style="FONT-WEIGHT: bold; FONT-SIZE: 6.3pt; FONT-FAMILY: Arial, sans-serif;BORDER-BOTTOM: black 1px solid; TEXT-ALIGN: center" valign="bottom" width="8%">{$datey}</td>
		<td style="FONT-SIZE: 8.5pt; FONT-FAMILY: 'Times New Roman', serif" valign="bottom" width="1%">&nbsp;г.</td>
	      </tr>
	    </tbody></table>
	  </td>
	</tr>
	<tr>
	  <td style="FONT-SIZE: 6.5pt; FONT-FAMILY: 'Times New Roman', serif;text-align: justify" valign="bottom">С условиями приема указанной в платежном документе суммы, в т.ч. с суммой взимаемой платы за&nbsp;услуги банка,&nbsp;ознакомлен&nbsp;и&nbsp;согласен.</td>
	</tr>
	<tr>
	  <td>
	    <table style="FONT-FAMILY: sans-serif; FONT-SIZE: 8pt" border="0" cellpadding="0" cellspacing="0" width="100%">
	      <tbody><tr>
		<td style="FONT-SIZE: 6.5pt; FONT-FAMILY: 'Times New Roman', serif" valign="bottom" width="50%">&nbsp;</td>
		<td style="FONT-SIZE: 7.5pt; FONT-FAMILY: 'Times New Roman', serif" valign="bottom" width="1%"><b>Подпись&nbsp;плательщика&nbsp;</b></td>
		<td style="FONT-WEIGHT: bold; FONT-SIZE: 6.3pt; FONT-FAMILY: Arial, sans-serif;BORDER-BOTTOM: black 1px solid; TEXT-ALIGN: center" valign="bottom" width="40%">&nbsp;</td>
	      </tr>
	    </tbody></table>
	  </td>
	</tr>

      </tbody></table>
    </td>
    <td width="16">&nbsp;</td>
  </tr>
</tbody></table>
</td></tr>
<tr><td>
  &nbsp;<br>
</td></tr></tbody></table>

</body></html>