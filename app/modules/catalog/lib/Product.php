<?php

namespace App\Modules\Catalog;

use App\Modules\System\Db;

class Product
{
	protected Db $db;
	public function __construct(Db $db)
	{
		$this->db = $db;
	}

	public function getProductsByCategoryId(int $categoryId)
	{
		$sql = "SELECT * FROM `products` JOIN `catalog` ON `products`.`id` = `catalog`.`product` WHERE `catalog`.`category` = :id;";
		$products = $this->db->sqlExecution($sql, [$categoryId]);
		foreach($products as $index => $product)
		{
			$sql = "SELECT * FROM `property_values` JOIN `properties` ON `property_values`.`property` = `properties`.`id` WHERE `properties`.`category` = :category AND `property_values`.`product` = :product;";
			$additionalFields = $this->db->sqlExecution($sql, [$categoryId, $product['id']]);
			if($additionalFields)
			{
				$products[$index]['ADDITIONAL_FIELDS'] = $additionalFields;
			}
		}
		return $products;
	}

	public function getProductById(int $productId)
	{
		$sql = "SELECT * FROM `products` WHERE `id` = :id";
		$product = $this->db->sqlExecution($sql, [$productId]);
		$sql = "SELECT * FROM `property_values` JOIN `properties` ON `property_values`.`property` = `properties`.`id` WHERE `property_values`.`product` = :product;";
		$additionalFields = $this->db->sqlExecution($sql, [$productId]);
		$product['ADDITIONAL_FIELDS'] = $additionalFields;
		return $product;
	}
}