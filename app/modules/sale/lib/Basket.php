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
				$basketItem = $this->getBasketItem($userId, $productId)[0];
				if(isset($basketItem) && !$basketItem['order'])
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
				header('Location: /megasport/basket/');
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

	public function getBasketByUserId(int $userId) : array
	{
		$sql = "SELECT `basket`.*, `order_items`.`order`, `products`.*  FROM `basket` LEFT JOIN `order_items` ON `basket`.`id` = `order_items`.`basket` JOIN `products` ON `basket`.`product` = `products`.`id` WHERE `user` = :user AND `order` IS NULL;";
		$basketItems = $this->db->sqlExecution($sql, [$userId]);
		foreach($basketItems as $index => $item)
		{
			$basketItems[$index]['full_price'] = $item['count'] * $item['price'];
			$basketItems[$index]['detail_page'] = '/megasport/product/' . $item['id'];
		}
		return $basketItems;
	}

	public function getOrderPriceByBasketItems(array $basketItems) : int
	{
		$orderPrice = 0;
		foreach($basketItems as $item)
		{
			$orderPrice += $item['count'] * $item['price'];
		}
		return $orderPrice;
	}

	public function addOneItemToBasketByProductId(int $productId) : bool
	{
		$container = Container::getInstance();
		$session = $container->get(Session::class);
		$user = $session->get('USER');
		$basketItem = $this->getBasketItem($user['id'], $productId);
		$currentBasketItemCount = ++$basketItem[0]['count'];
		$sql = "UPDATE `basket` SET `count` = :count WHERE `id` = :id";
		return $this->db->sqlExecution($sql, [$currentBasketItemCount, $basketItem[0]['id']]);
	}

	public function deleteOneItemToBasketByProductId(int $productId) : bool
	{
		$container = Container::getInstance();
		$session = $container->get(Session::class);
		$user = $session->get('USER');
		$basketItem = $this->getBasketItem($user['id'], $productId);
		$currentBasketItemCount = --$basketItem[0]['count'];
		if($currentBasketItemCount == 0)
		{
			$sql = "DELETE FROM `megasport`.`basket` WHERE (`id` = :id)";
			return $this->db->sqlExecution($sql, [$basketItem[0]['id']]);
		}
		$sql = "UPDATE `basket` SET `count` = :count WHERE `id` = :id";
		return $this->db->sqlExecution($sql, [$currentBasketItemCount, $basketItem[0]['id']]);
	}

	public function getBasketItemCountByBasketItems(array $basketItems, int $productId) : int
	{
		foreach($basketItems as $basketItem)
		{
			if($basketItem['id'] == $productId)
			{
				return $basketItem['count'];
			}
		}
		return 0;
	}

	public function getBasketItemPriceByBasketItems(array $basketItems, int $productId) : int
	{
		foreach($basketItems as $basketItem)
		{
			if($basketItem['id'] == $productId)
			{
				return $basketItem['count'] * $basketItem['price'];
			}
		}
		return 0;
	}
}