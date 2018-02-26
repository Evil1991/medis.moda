{*
* 2007-2014 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2014 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
{if isset($HOOK_HOME_TAB_CONTENT) && $HOOK_HOME_TAB_CONTENT|trim}
    {if isset($HOOK_HOME_TAB) && $HOOK_HOME_TAB|trim}
<!--IMAGE BANNERS STATIC BLOCK-->	
	<div class="image_banners">
		{getBelvgBlockContent id="img_b1"} 
		{getBelvgBlockContent id="img_b2"} 
		{getBelvgBlockContent id="img_b3"} 
	</div>
<!--end image banners-->
     <!--  <ul id="home-page-tabs" class="nav nav-tabs clearfix">
			{$HOOK_HOME_TAB}
		</ul> 
		-->
			<div style="clear:both"></div>
	{/if}
	<div class="tab-content">{$HOOK_HOME_TAB_CONTENT}</div>
{/if}
<!--MOST POPULAR STATIC BLOCK-->
     <div class="fb">
        <a href="http://www.prestashop.com">{getBelvgBlockContent id="fb1"}</a> 
        <a href="http://www.prestashop.com">{getBelvgBlockContent id="fb2"}</a> 
        <a href="http://www.prestashop.com"><span style="margin-right:0px!important;">{getBelvgBlockContent id="fb3"}</span></a>
	 </div>
	 <!--IMAGE BANNERS STATIC BLOCK-->	
	 	 {getBelvgBlockContent id="bfluid"}
	 {*<div class="footer_banners">{getBelvgBlockContent id="most_popular_title"} *}
	                         {*<ul class="bxslider5">    *}
{*<li>{getBelvgBlockContent id="b01"} </li>*}
{*<li>	<span style="margin-right:0px!important;"> {getBelvgBlockContent id="b02"}  </span></li>*}
	                                         {*<li>  {getBelvgBlockContent id="b03"} </li>*}
	{*<li><span style="margin-right:0px!important;"> {getBelvgBlockContent id="b04"}  </span></li></ul>*}
	{*</div>*}
<!--end image banners-->
	  <!--<div class="rb_title">OUR SUPPORT </div>-->
	 {getBelvgBlockContent id="rb1"}
	 {getBelvgBlockContent id="rb2"}
	 {getBelvgBlockContent id="rb3"}
	 {getBelvgBlockContent id="rb4"}
	 {getBelvgBlockContent id="rb5"}

{if isset($HOOK_HOME) && $HOOK_HOME|trim}

	<div class="clearfix">{$HOOK_HOME}</div>
		
		
		
{/if}