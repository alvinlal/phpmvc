<?php

namespace app\core;
use app\core\Database;

class Model extends Database {
	public function sql(string $sql) {
		$stmt = $this->query($sql);
		return $stmt->fetchAll();
	}
}