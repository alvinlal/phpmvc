<?php

namespace alvin\phpmvc;

/**
 * Base class for models.
 */
class Model extends Database {

	/**
	 * Begins a database transaction.
	 *
	 * Uses beginTransaction method on alvin\phpmvc\Database class
	 *
	 * @return void
	 */
	public function beginTransaction() {
		parent::beginTransaction();
	}

	/**
	 * Returns id of lastly inserted record.
	 *
	 * Uses lastInsertId method on alvin\phpmvc\Database class
	 *
	 * @return string
	 */
	public function lastInsertId() {
		return parent::lastInsertId();
	}

	/**
	 * Rollbacks a database transaction.
	 *
	 * Uses rollback method on alvin\phpmvc\Database class
	 *
	 * @return void
	 */
	public function rollback() {
		parent::rollBack();
	}

	/**
	 * Commits a database transaction.
	 *
	 * Uses commit method on alvin\phpmvc\Database class
	 *
	 * @return void
	 */
	public function commit() {
		parent::commit();
	}

	/**
	 * Selects multiple records.
	 *
	 * Uses prepare method on alvin\phpmvc\Database to prepare and select records
	 *
	 * @param string $sql The sql statement to execute
	 * @param array $args Arguments for prepared statements
	 * @return array
	 */
	public function select(string $sql, array $args = []) {
		$stmt = parent::prepare($sql);
		$stmt->execute($args);
		return $stmt->fetchAll();
	}

	/**
	 * Select a single record.
	 *
	 * Uses prepare method on alvin\phpmvc\Database to prepare and select a single record
	 *
	 * @param string $sql The sql statement to execute
	 * @param array $args Arguments for prepared statements
	 * @return object
	 */
	public function selectOne(string $sql, array $args = []) {
		$stmt = parent::prepare($sql);
		$stmt->execute($args);
		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}

	/**
	 * Insert records.
	 *
	 * Uses prepare method on alvin\phpmvc\Database to prepare and insert records
	 *
	 * @param string $sql The sql statement to execute
	 * @param array $args Arguments for prepared statements
	 * @return bool
	 */
	public function insert(string $sql, array $args = []) {
		$stmt = parent::prepare($sql);
		return $stmt->execute($args);
	}

	/**
	 * delete records.
	 *
	 * Uses prepare method on alvin\phpmvc\Database to prepare and delete records
	 *
	 * @param string $sql The sql statement to execute
	 * @param array $args Arguments for prepared statements
	 * @return bool
	 */
	public function delete(string $sql, array $args = []) {
		$stmt = parent::prepare($sql);
		return $stmt->execute($args);
	}

	/**
	 * Check if a particular record exists.
	 *
	 * Uses prepare method on alvin\phpmvc\Database to prepare and check for records
	 *
	 * @param string $sql The sql statement to execute
	 * @param array $args Arguments for prepared statements
	 * @return bool
	 */
	public function exists(string $sql, array $args = []) {
		$stmt = parent::prepare($sql);
		$stmt->execute($args);
		$row = $stmt->fetch(\PDO::FETCH_ASSOC);
		if (!$row) {
			return false;
		}
		return true;
	}

	/**
	 * Store a file.
	 *
	 * Uses put method on alvin\phpmvc\FileStorage to store a file
	 *
	 * @param string $uploadPath The path of the file to store
	 * @param string $fileName The name of the file
	 * @return string The name of the stored file
	 */
	public function upload(string $uploadPath, string $fileName) {
		return Application::$app->fileStorage->put($uploadPath, $fileName);
	}

}