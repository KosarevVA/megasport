<?php

use App\Modules\System\Route;

return [
	'/megasport/example/{int}/{string}' => new Route('Example', 'example'),
	'/megasport/signup/' => new Route('Signup', 'index'),
	'/megasport/signup/do' => new Route('Signup', 'signUp'),
];