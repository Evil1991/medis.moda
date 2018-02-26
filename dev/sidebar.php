<script type="text/javascript">
    $(document).ready(function(){
        function isInt(n) {
            return typeof n === 'number' && n % 1 == 0;
        }
        $("#nav #hook").live("submit", function() {
            var url = "/dev/ajax.php";
            $.ajax({
                type: "POST",
                url: url,
                data: $(this).serialize(),
                success: function(data)
                {
                    if(data == "1") $('#nav #hook .alert').removeClass('warning').addClass('success').html('Успешно добавлено');
                    else $('#nav #hook .alert').removeClass('success').addClass('warning').html(data);
                }
            });
            return false;
        });
        $("#nav #cms").live("submit", function() {
            var url = "/dev/ajax.php";
            $.ajax({
                type: "POST",
                url: url,
                data: $(this).serialize(),
                dataType : "json",
                success: function(data)
                {
                    if(data.id_cms && data.link_rewrite) $('#nav #cms .alert').removeClass('warning').addClass('success').html('Успешно добавлено /content/'+data.id_cms+'-'+data.link_rewrite);
                    else $('#nav #cms .alert').removeClass('success').addClass('warning').html(data);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown)
                {
                    console.log(arguments);
                    alert("TECHNICAL ERROR: unable to save adresses \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
                }
            });
            return false;
        });
    })
</script>
<div id="nav" class="pure-u">
	<a href="#" class="nav-menu-button">Меню</a>
	<div class="nav-inner">
		<div class="pure-menu pure-menu-open">
			<ul>
				<li><a href="/dev/cat.php">Категории</a></li>
				<li><a href="/dev/products.php">Товары</a></li>
				<li><a href="/dev/cms.php">CMS страницы</a></li>
				<li><a href="/dev/modules.php">Модули</a></li>
				<li><a href="/dev/vars.php">Переменные</a></li>
                <li><a href="/dev/reset.php">Создать сотрудника</a></li>
			</ul>
		</div>
        <form class="pure-form pure-form-stacked" id="hook">
            <div class="alert"></div>
            <fieldset>
                <input type="hidden" name="action" value="hook" />
                <legend>Расположить модуль</legend>
                <label for="module">Модуль</label>
                <input id="module" type="text" name="module">
                <label for="hook">Hook</label>
                <input id="hook" type="text" name="hook">
                <button type="submit" class="pure-button pure-button-primary">Расположить</button>
            </fieldset>
        </form>

        <form class="pure-form pure-form-stacked" id="cms">
            <div class="alert"></div>
            <fieldset>
                <input type="hidden" name="action" value="cms" />
                <legend>Создать CMS страницу</legend>
                <label for="name">Название</label>
                <input id="name" type="text" name="name">
                <label for="content">Контент</label>
                <textarea id="content" name="content">Редактировать в Админ Панели -> Инструменты -> Страницы</textarea>
                <button type="submit" class="pure-button pure-button-primary">Создать</button>
            </fieldset>
        </form>
	</div>

</div>