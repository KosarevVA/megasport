<?php

namespace App\Modules\Sale;

use App\Modules\System\Db;

class DeliveryCompanies
{
	protected Db $db;

	public function __construct(Db $db)
	{
		$this->db = $db;
	}

	public function getDeliveryCompanies()
	{
		$sql = "SELECT * FROM `delivery_types`";
		return $this->db->sqlExecution($sql);
	}
}