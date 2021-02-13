<?php

namespace app\core;
use app\core\Database;

class Model extends Database {
	public function select(string $sql, array $args = []) {
		$stmt = parent::prepare($sql);
		$stmt->execute($args);
		return $stmt->fetchAll();
	}
	public function insert(string $sql, array $args = []) {
		$stmt = parent::prepare($sql);
		return $stmt->execute($args);
	}
	public function delete(string $sql, array $args = []) {
		$stmt = parent::prepare($sql);
		return $stmt->execute($args);
	}
	public function exists(string $sql, array $args = []) {
		$stmt = parent::prepare($sql);
		$stmt->execute($args);
		$row = $stmt->fetch(\PDO::FETCH_ASSOC);
		if (!$row) {
			return false;
		}
		return true;
	}

}