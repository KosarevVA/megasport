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
		return $this->db->sqlExecution($sql, [$categoryId]);
	}
}