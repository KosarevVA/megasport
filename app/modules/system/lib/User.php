<?php

namespace App\Modules\System;

class User
{
	protected string $id;
	protected string $name;
	protected string $email;
	protected string $phone;
	protected string $registerDate;
	protected string $accessLevel;

	protected Db $db;
	protected Session $session;

	protected array $dbErrors = [
		'23000' => 'Такой Email или номер телефона уже занят'
	];

	public function __construct(Db $db, Session $session)
	{
		$this->db = $db;
		$this->session = $session;
	}

	public function setId(string $id) : void
	{
		$this->id = $id;
	}

	public function setName(string $name) : void
	{
		$this->name = $name;
	}

	public function setEmail(string $email) : void
	{
		$this->email = $email;
	}

	public function setPhone(string $phone) : void
	{
		$this->phone = $phone;
	}

	public function setRegisterDate(string $registerDate) : void
	{
		$this->registerDate = $registerDate;
	}

	public function setAccessLevel(string $accessLevel) : void
	{
		$this->accessLevel = $accessLevel;
	}

	public function isAuthorized() : bool
	{
		return $this->session->has('USER');
	}

	public function authorize()
	{
		$httpContext = Container::getInstance()->get(HttpContext::class);
		$email = $httpContext->getParameter('email');
		$password = $httpContext->getParameter('password');

		$errors = [];

		if(!Validation::emailValidate($email))
		{
			$errors[] = "Неккоректный email!";
		}
		if(!Validation::passwordValidate($password))
		{
			$errors[] = "Неккоректный пароль!";
		}

		if(!$errors)
		{
			try {
				$sql = "SELECT * FROM `users` WHERE `email` = :email";
				$user = $this->db->sqlExecution($sql, [$email]);
				if($user)
				{
					if(password_verify($password, $user['password']))
					{
						$userSessionParameters = [
							'id' => $user['id'],
							'access_level' => $user['access_level']
						];
						$this->session->set('USER', $userSessionParameters);
						header('Location: /megasport/');
						die();
					}else
					{
						$errors[] = "Не верный пароль!";
					}
				}else
				{
					$errors[] = "Такой пользователь не найден!";
				}
			}catch (\Exception $exception)
			{
				$errors[] = "Что-то пошло не так, но мы уже работаем над этим!";
			}
		}
		return [
			'input' => [
				'email' => $email
			],
			'errors' => $errors
		];
	}

	public function registration()
	{
		$httpContext = Container::getInstance()->get(HttpContext::class);
		$login = $httpContext->getParameter('login');
		$name = $httpContext->getParameter('name');
		$email = $httpContext->getParameter('email');
		$phone = $httpContext->getParameter('phone');
		$password = $httpContext->getParameter('password');
		$confirmedPassword = $httpContext->getParameter('confirmedPassword');
		$personalData = $httpContext->getParameter('personalData');

		$errors = [];

		if(!(bool)$personalData)
		{
			$errors[] = "Нужно согласиться на обработку персональных данных!";
		}
		if($password != $confirmedPassword)
		{
			$errors[] = "Пароли не совпадают!";
		}
		if(!Validation::nameValidate($name))
		{
			$errors[] = "Имя должно состоять минимум из двух слов!";
		}
		if(!Validation::emailValidate($email))
		{
			$errors[] = "Неккоректный email!";
		}
		if(!Validation::phoneValidate($phone))
		{
			$errors[] = "Неккоректный номер телефона!";
		}
		if(!Validation::passwordValidate($password))
		{
			$errors[] = "Слишком простой пароль!";
		}
		try {
			$password = password_hash($password, PASSWORD_BCRYPT);
			$registerDate = date('Y-m-j G:i:s');
			$this->db->sqlExecution("INSERT INTO `users` (`name`, `email`, `phone`, `password`, `register_date`) VALUES (:name, :email, :phone, :password, :register_date);", [$name, $email, $phone, $password, $registerDate]);
		}catch (\Exception $exception)
		{
			$errors[] = $this->dbErrors[$exception->getCode()];
		}
		if($errors)
		{
			return [
				'input' => [
					'login' => $login,
					'name' => $name,
					'phone' => $phone,
					'email' => $email,
				],
				'errors' => $errors
			];
		}
		header('Location: /megasport/signin/');
		die();
	}

	public function getId(): string
	{
		return $this -> id;
	}

	public function getName(): string
	{
		return $this -> name;
	}

	public function getEmail(): string
	{
		return $this -> email;
	}

	public function getPhone(): string
	{
		return $this -> phone;
	}

	public function getRegisterDate(): string
	{
		return $this -> registerDate;
	}

	public function getAccessLevel(): string
	{
		return $this -> accessLevel;
	}
}