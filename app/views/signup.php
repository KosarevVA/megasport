<div class="container row">
	<h2 class="m-t-0">Регистрация</h2>
</div>
<div class="container">
	<p>Для регистрации на сайте введите необходимые данные.</p>
	<form class="form-horizontal" action="/megasport/signup/do" method="post">
		<div class="form-group">
			<label for="name" class="col-sm-2 control-label">Ваше имя</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="name" name="name" placeholder="Ваше имя" value="<?= $result['input']['name'] ?? '' ?>">
			</div>
		</div>
		<div class="form-group">
			<label for="email" class="col-sm-2 control-label">Ваш Email</label>
			<div class="col-sm-10">
				<input type="email" class="form-control" id="email" name="email" placeholder="Ваше Email" value="<?= $result['input']['email'] ?? '' ?>">
			</div>
		</div>
		<div class="form-group">
			<label for="phone" class="col-sm-2 control-label">Ваш телефон</label>
			<div class="col-sm-10">
				<input type="tel" class="form-control" id="phone" name="phone" placeholder="Ваше телефон" value="<?= $result['input']['phone'] ?? '' ?>">
			</div>
		</div>
		<div class="form-group">
			<label for="password" class="col-sm-2 control-label">Ваш пароль</label>
			<div class="col-sm-10">
				<input type="password" class="form-control" id="password" name="password" placeholder="Ваш пароль">
			</div>
		</div>
		<div class="form-group">
			<label for="confirmedpassword" class="col-sm-2 control-label">Подтвердите пароль</label>
			<div class="col-sm-10">
				<input type="password" class="form-control" id="confirmedpassword" name="confirmedPassword" placeholder="Подтвердите пароль">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<div class="checkbox">
					<label>
						<input type="checkbox" name="personalData"> Я согласен на обработку персональных данных
					</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-success">Зарегистрироваться</button>
			</div>
		</div>
	</form>
    <?if(isset($result['errors'])):?>
        <?foreach ($result['errors'] as $error):?>
            <div class="alert alert-danger" role="alert"><?=$error?></div>
        <?endforeach;?>
    <?endif;?>
</div>
</div>
<script>
    $(function($) {
        $("#phone").mask("+7 (999) 999-9999",{placeholder:"_"});
    })
</script>