{capture name=path}{l s='Оформление заказа' mod='yamodule'}{/capture}


{include file="$tpl_dir./errors.tpl"}
<div class="ord-confirmation">
    <h1 class="page-heading">{l s='Заказ принят' mod="yamodule"}</h1>
    <p class="conf-text">
        {$conf_text}
    </p>
</div>
<p class="cart_navigation exclusive">
    <a class="button-exclusive btn btn-default" href="{$link->getPageLink('history', true)|escape:'html':'UTF-8'}" title="{l s='Перейти к заказам' mod="yamodule"}"><i class="icon-chevron-left"></i>{l s='Перейти к заказам' mod="yamodule"}</a>
</p>