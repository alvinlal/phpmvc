<?php

namespace app\core;
use app\core\Database;

class Model extends Database {
	public function query(string $sql, array $args = []) {
		$stmt = parent::query($sql);
		$stmt = parent::prepare($sql);
		$stmt->execute($args);
		$data = $stmt->fetchAll();
		if (sizeof($data) === 1) {
			return $data[0];
		}
		return $data;
	}
}