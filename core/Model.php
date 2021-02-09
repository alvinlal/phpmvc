<?php

namespace app\core;
use app\core\Database;

class Model extends Database {
	public function query(string $sql, array $args = []) {
		$stmt = parent::query($sql);
		$stmt = parent::prepare($sql);
		$stmt->execute($args);
		return $stmt->fetchAll();
	}
}