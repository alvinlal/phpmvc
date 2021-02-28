<?php

namespace app\core;
use app\core\Controller;
use \PDO;

class Database extends Controller {
	public $sqldb;
	public string $dbType;
	private string $DB_NAME;
	private string $DB_HOST;
	private string $DB_PORT;
	private string $DB_USER;
	private string $DB_PASS;
	private string $DB_DSN;

	public function __construct(string $dbType = 'sql') {
		$this->dbType = $dbType;
		switch ($dbType) {
		case 'sql':{
				$this->setupSQL();
			}
		}
	}
	private function setupSQL() {
		$this->DB_NAME = getenv('DB_NAME');
		$this->DB_HOST = getenv('DB_HOST');
		$this->DB_PORT = getenv('DB_PORT');
		$this->DB_USER = getenv('DB_USER');
		$this->DB_PASS = getenv('DB_PASS');
		$this->DB_DSN = "mysql:host=$this->DB_HOST;dbname=$this->DB_NAME";
		$this->sqldb = new PDO($this->DB_DSN, $this->DB_USER, $this->DB_PASS);
		$this->sqldb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	public function query(string $string) {
		return $this->sqldb->query($string);
	}
	public function prepare(string $sql) {
		return $this->sqldb->prepare($sql);
	}
	public function beginTransaction() {
		$this->sqldb->beginTransaction();
	}
	public function rollBack() {
		$this->sqldb->rollBack();
	}
	public function commit() {
		$this->sqldb->commit();
	}
	public function lastInsertId() {
		return $this->sqldb->lastInsertId();
	}
}