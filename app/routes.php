<?php

use App\Modules\System\Route;

return [
	'/megasport/example/{int}/(?<name>[a-zA-Z]+)/' => new Route('Example', 'example'),
	'/megasport/signin/' => new Route('Signin', 'index'),
	'/megasport/signin/do' => new Route('Signin', 'signIn'),
	'/megasport/signup/' => new Route('Signup', 'index'),
	'/megasport/signup/do' => new Route('Signup', 'signUp'),
	'/megasport/' => new Route('Index', 'index'),
	'/megasport/categories/' => new Route('Categories', 'index'),
];