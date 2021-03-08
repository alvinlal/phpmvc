<?php

namespace alvin\phpmvc;

class Model extends Database {
	public function beginTransaction() {
		parent::beginTransaction();
	}
	public function lastInsertId() {
		return parent::lastInsertId();
	}
	public function rollback() {
		parent::rollBack();
	}
	public function commit() {
		parent::commit();
	}
	public function select(string $sql, array $args = []) {
		$stmt = parent::prepare($sql);
		$stmt->execute($args);
		return $stmt->fetchAll();
	}
	public function selectOne(string $sql, array $args = []) {
		$stmt = parent::prepare($sql);
		$stmt->execute($args);
		return $stmt->fetch(\PDO::FETCH_ASSOC);
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
	public function upload(string $uploadPath, string $fileName) {
		return Application::$app->fileStorage->put($uploadPath, $fileName);
	}

}