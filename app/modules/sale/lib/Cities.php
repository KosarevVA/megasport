<?php

namespace App\Modules\Sale;

use App\Modules\System\Db;

class Cities
{
	protected Db $db;

	public function __construct(Db $db)
	{
		$this->db = $db;
	}

	public function getCities()
	{
		$sql = "SELECT * FROM `cities`";
		return $this->db->sqlExecution($sql);
	}
}