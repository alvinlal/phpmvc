<?php

namespace app\core;
use app\core\Database;

class Model extends Database {
	public function select(string $sql, array $args = []) {
		$stmt = parent::query($sql);
		$stmt = parent::prepare($sql);
		$stmt->execute($args);
		return $stmt->fetchAll();
	}
	public function insert(string $sql, array $args = []) {
		$stmt = parent::query($sql);
		$stmt = parent::prepare($sql);
		return $stmt->execute($args);
	}
	public function delete(string $sql, array $args = []) {
		$stmt = parent::query($sql);
		$stmt = parent::prepare($sql);
		return $stmt->execute($args);
	}
}