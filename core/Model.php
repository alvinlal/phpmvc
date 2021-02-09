<?php

namespace app\core;
use app\core\Database;

class Model extends Database {
	public function query(string $sql) {
		$stmt = parent::query($sql);
		return $stmt->fetchAll();
	}
}