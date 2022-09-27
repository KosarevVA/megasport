<?
$this->setTitle('Авторизация');
?>
<div class="container row">
    <h2 class="m-t-0">Авторизация</h2>
</div>
<div class="container">
    <p>Для авторизации на сайте введите логин и пароль.</p>
    <form class="form-horizontal" action="/megasport/signin/do" method="POST">
        <div class="form-group">
            <label for="login" class="col-sm-2 control-label">Ваш Email</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="email" name="email" placeholder="Ваш Email" value="<?= $result['input']['email'] ?? '' ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="col-sm-2 control-label">Ваш пароль</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="password" name="password" placeholder="Ваш пароль">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                        <input type="checkbox"> Запомнить меня
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-success">Войти</button>
                <a href="/megasport/signup/" class="btn btn-primary">Зарегистрироваться</a>
            </div>
        </div>
    </form>
	<?if(isset($result['errors'])):?>
		<?foreach ($result['errors'] as $error):?>
            <div class="alert alert-danger" role="alert"><?=$error?></div>
		<?endforeach;?>
	<?endif;?>
</div>