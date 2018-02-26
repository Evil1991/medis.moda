<style>
	.images_combinations {
		border-collapse: collapse;
		width: 500px;
	}

	.images_combinations .image {
		padding-right: 20px;
	}

	.images_combinations td {
		padding: 10px 0;
		border-bottom: 1px solid #000;
	}

	.images_combinations tr:last-child td {
		border-bottom: none;
	}
	.listForm{
		list-style:none;
	}
	.listFor label{
		cursor:pointer;
	}
</style>

<script>
	$(document).ready(function () {
		$('.images_combinations a.select_all').click(function () {

			$(this).siblings('div').find('li input[type=checkbox]').prop('checked', 'checked');

			return false;
		});
        $('.images_combinations .listForm>li :checkbox').shiftcheckbox();
	});
</script>

{if !empty($images)}

	<table class="images_combinations">
		{foreach from=$images item=image}
			<tr>
				<td class="image">
					<img class="ui-li-thumb" src="{$link->getImageLink($link_rewrite, $image.id_image, 'home_default')|escape:'html'}" />
				</td>

				<td class="combs">
					{if !empty($comb_array)}
						{assign var="id_image" value=$image.id_image}
						<input type="hidden" name="imgArray[]" value="{$id_image}" />
						<div style="overflow-y:scroll;height:300px;padding:0 10px;min-width:500px;">
						<ul class="listForm">
							{foreach from=$comb_array item=comb}
								{assign var="id_product_attribute" value=$comb.id_product_attribute}
								<li><input type="checkbox" id="images_combinations_{$id_image}_{$id_product_attribute}" name="images_combinations[{$id_image}][{$id_product_attribute}]" {if isset($images_combinations.$id_image.$id_product_attribute)}checked="checked"{/if} value="1" />
									<label class="t" for="images_combinations_{$id_image}_{$id_product_attribute}">
										{foreach from=$comb.attributes item=comb_item}
											{$comb_item.0} - {$comb_item.1}
										{/foreach}
									</label>
								</li>
							{/foreach}
						</ul>
						</div>
						<br />
						<a href="#" class="select_all">Выделить все</a>
					{/if}
				</td>
			</tr>

		{/foreach}
	</table>
	
	<div class="panel-footer">
		<a href="{$link->getAdminLink('AdminProducts')|escape:'html':'UTF-8'}" class="btn btn-default"><i class="process-icon-cancel"></i> {l s='Cancel'}</a>
		<button type="submit" name="submitAddproduct" class="btn btn-default pull-right"><i class="process-icon-save"></i> {l s='Save'}</button>
		<button type="submit" name="submitAddproductAndStay" class="btn btn-default pull-right"><i class="process-icon-save"></i> {l s='Save and stay'}</button>
		<a href="#" id="desc-product-newCombination" class="btn btn-default pull-right"><i class="process-icon-new"></i> <span>{l s="New combination"}</span></a>
	</div>

{else}
	<p>Изображения отсутствуют</p>
{/if}