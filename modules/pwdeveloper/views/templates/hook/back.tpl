<div class="panel" id="fieldset_0">
	<div class="panel-heading"><i class="icon-cogs"></i> Настройки</div>
	<div class="form-wrapper">
		<form method="POST">
			<div class="form-group">
				<input id="submitUnistallModule" type="submit" class="hidden" name="submitUnistallModule" value="Очистить" />
				<label for="submitUnistallModule" class="btn btn-default"><i class="icon-trash"></i> Удалить ненужные модули</label>
			</div>
			{if (!$pwDeveloperOn && empty($smarty.post.submitOnDeveloper)) || $smarty.post.submitOffDeveloper}
			<div class="form-group">
				<input id="submitOnDeveloper" type="submit" class="hidden" name="submitOnDeveloper" value="Очистить" />
				<label for="submitOnDeveloper" class="btn btn-success"><i class="icon-plus"></i> Включить инструменты</label>
			</div>
			{else}
			<div class="form-group">
				<input id="submitOffDeveloper" type="submit" class="hidden" name="submitOffDeveloper" value="Очистить" />
				<label for="submitOffDeveloper" class="btn btn-warning"><i class="icon-minus"></i> Выключить инструменты</label>
			</div>
			{/if}
		</form>
	</div>
</div>