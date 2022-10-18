<?php

namespace App\Modules\Sale;

use App\Modules\System\Container;
use App\Modules\System\Db;
use App\Modules\System\HttpContext;
use App\Modules\System\Session;

class Orders
{
	protected Db $db;

	public function __construct(Db $db)
	{
		$this->db = $db;
	}

	public function createOrder()
	{
		$container = Container::getInstance();
		$context = $container->get(HttpContext::class);

		$session = $container->get(Session::class);
		$user = $session->get('USER');

		$deliveryType = $context->getParameter('delivery_type');
		$paymentType = $context->getParameter('payment_type');
		$address = $context->getParameter('address');
		$city = $context->getParameter('city');

		$date = date('Y-m-j G:i:s');

		$errors = [];
		if(!$city)
		{
			$errors[] = "Введите город";
		}
		if(!$address)
		{
			$errors[] = "Введите адрес";
		}

		if($errors)
		{
			return $errors;
		}
		try {
			$sql = "SELECT `basket`.*, `order_items`.`order`  FROM `basket` LEFT JOIN `order_items` ON `basket`.`id` = `order_items`.`basket` WHERE `user` = :user AND `order` IS NULL;";
			$basketItems = $this->db->sqlExecution($sql, [$user['id']]);
			if(!$basketItems)
			{
				throw new \Exception();
			}
			$sql = "SELECT * FROM `cities` WHERE `name` = :name";
			if(!$cityExist = $this->db->sqlExecution($sql, [$city]))
			{
				$sql = "INSERT INTO `cities` (`name`) VALUES (:city)";
				$cityId = $this->db->sqlExecution($sql, [$city]);
			}else
			{
				$cityId = $cityExist[0]['id'];
			}

			$sql = "INSERT INTO `deliveries` (`city`, `delivery_type`, `address`) VALUES (:city, :deliveryType, :address)";
			$delivery = $this->db->sqlExecution($sql, [$cityId, $deliveryType, $address]);

			$sql = "INSERT INTO `payments` (`created_date`, `payment_type`) VALUES (:date, :paymentType)";
			$payment = $this->db->sqlExecution($sql, [$date, $paymentType]);

			$sql = "INSERT INTO `orders` (`created_date`, `delivery`, `payment`, `user`) VALUES (:date, :delivery, :payment, :user);";
			$orderId = $this->db->sqlExecution($sql, [$date, $delivery, $payment, $user['id']]);
			foreach($basketItems as $basketItem)
			{
				$sql = "INSERT INTO `order_items` (`order`, `basket`) VALUES (:order, :basket);";
				$this->db->sqlExecution($sql, [$orderId, $basketItem['id']]);
			}
		}catch (\Exception $exception)
		{
			$errors[] = "Что-то пошло не так( Попробуйте позже";
		}
		return $errors;
	}

	public function getOrders()
	{
		$container = Container::getInstance();
		$session = $container->get(Session::class);
		$user = $session->get('USER');

		$sql = "SELECT `orders`.*, `statuses`.`name` as 'st_name', `payments`.`paid`, `payment_types`.`name` as 'pt_name' FROM `orders` JOIN `statuses` ON `orders`.`status` = `statuses`.`id` JOIN `payments` ON `orders`.`payment` = `payments`.`id` JOIN `payment_types` ON `payments`.`payment_type` = `payment_types`.`id` WHERE `orders`.`user` = :user";
		return $this->db->sqlExecution($sql, [$user['id']]);
	}
}