<?php

namespace App\Modules\Catalog;

use App\Modules\System\Db;

class Category
{
	protected Db $db;
	public function __construct(Db $db)
	{
		$this->db = $db;
	}

	public function getCategories() : array
	{
		$categories = [];
		$sql = "SELECT `categories`.`name`, `categories`.`edit_date`, count(`catalog`.`product`) as 'product_count', `categories`.`preview_picture` FROM `categories` JOIN `catalog` ON `categories`.`id` = `catalog`.`category`;";
		$categories = $this->db->sqlExecution($sql);
		return $categories;
	}
}