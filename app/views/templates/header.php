<?
use App\Modules\System\Container;
use App\Modules\System\User;
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="shortcut icon" href="assets/icon.png" type="image/x-icon">
	<title>#TITLE#</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>
    <style>
        body{background-color:#d1d1d1 !important;}
        .navbar-brand { position: relative; z-index: 2; }
        .navbar-nav.navbar-right .btn { position: relative; z-index: 2; padding: 4px 20px; margin: 10px auto; }
        .navbar .navbar-collapse { position: relative; }
        .navbar .navbar-collapse .navbar-right > li:last-child { padding-left: 22px; }
        .navbar .nav-collapse { position: absolute; z-index: 1; top: 0; left: 0; right: 0; bottom: 0; margin: 0; padding-right: 120px; padding-left: 80px; width: 100%; }
        .navbar.navbar-default .nav-collapse { background-color: #f8f8f8; }
        .navbar.navbar-inverse .nav-collapse { background-color: #222; }
        .navbar .nav-collapse .navbar-form { border-width: 0; box-shadow: none; }
        .nav-collapse>li { float: right; }
        .btn.btn-circle { border-radius: 50px; }
        .btn.btn-outline { background-color: transparent; }
        @media screen and (max-width: 767px) {
            .navbar .navbar-collapse .navbar-right > li:last-child { padding-left: 15px; padding-right: 15px; }
            .navbar .nav-collapse { margin: 7.5px auto; padding: 0; }
            .navbar .nav-collapse .navbar-form { margin: 0; }
            .nav-collapse>li { float: none; }
        }

        a {
            text-decoration: none !important;
        }

        .section-link {
            color: black;
        }

        .m-t-0 {
            margin-top: 0;
        }

        textarea {
            max-width: 100%;
        }
    </style>
</head>
<body>
<div class="container-fluid">
	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-3">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/megasport/">MEGASPORT</a>
			</div>
			<div class="collapse navbar-collapse" id="navbar-collapse-3">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="/megasport/categories/">Каталог</a></li>
					<li><a href="company.html">Компания</a></li>
					<li><a href="contacts.html">Контакты</a></li>
					<li><a href="news.html">Новости</a></li>
                    <?
                    $user = Container::getInstance()->get(User::class);
                    if($user->isAuthorized()):
                    ?>
					<li><a href="/megasport/logout/">Выйти</a></li>
                    <?else:?>
                    <li><a href="/megasport/signin/">Войти</a></li>
                    <?endif;?>
					<li>
						<a class="btn btn-default btn-outline btn-circle" data-toggle="collapse" href="#nav-collapse3" aria-expanded="false" aria-controls="nav-collapse3">Поиск</a>
					</li>
				</ul>
				<div class="collapse nav navbar-nav nav-collapse" id="nav-collapse3">
					<form class="navbar-form navbar-right" role="search">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Например... Велосипед" />
						</div>
						<button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
					</form>
				</div>
			</div>
		</div>
	</nav>