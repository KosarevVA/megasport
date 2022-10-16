<?php

namespace App\Modules\Sale;

use App\Modules\System\Db;

class PaymentTypes
{
	protected Db $db;

	public function __construct(Db $db)
	{
		$this->db = $db;
	}

	public function getPaymentTypes()
	{
		$sql = "SELECT * FROM `payment_types`";
		return $this->db->sqlExecution($sql);
	}
}