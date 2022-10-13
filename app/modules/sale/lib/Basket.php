<?php

namespace App\Modules\Sale;

use App\Modules\System\Container;
use App\Modules\System\Db;
use App\Modules\System\Session;
use App\Modules\System\User;

class Basket
{
	protected Db $db;

	public function __construct(Db $db)
	{
		$this->db = $db;
	}

	public function addProductToBasket(int $productId)
	{
		$container = Container::getInstance();
		$user = $container->get(User::class);
		$session = $container->get(Session::class);
		if($user->isAuthorized())
		{
			$userId = $session->get('USER')['id'];
			if($userId)
			{
				$basketItem = $this->getBasketItem($userId, $productId);
				if(!$basketItem['order'])
				{
					$basketItemId = $basketItem['id'];
					$currentBasketItemCount = ++$basketItem['count'];
					$sql = "UPDATE `basket` SET `count` = :count WHERE `id` = :id";
					$this->db->sqlExecution($sql, [$currentBasketItemCount, $basketItemId]);
				}else
				{
					$sql = "INSERT INTO `basket` (`product`, `user`) VALUES (:productId, :userId)";
					$this->db->sqlExecution($sql , [$productId, $userId]);
				}
				header('Location: /megasport/categories/');
			}
		}else
		{
			header('Location: /megasport/signin/');
		}
		die();
	}

	public function getBasketItem(int $userId, int $productId)
	{
		$sql = "SELECT `basket`.*, `order_items`.`order`  FROM `basket` LEFT JOIN `order_items` ON `basket`.`id` = `order_items`.`basket` WHERE `product` = :product AND `user` = :user ORDER BY `basket`.`id` desc LIMIT 1";
		return $this->db->sqlExecution($sql, [$productId, $userId]);
	}
}