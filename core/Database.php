<?php

namespace app\core;
use \PDO;

class Database {
	public $db;
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
		$this->db = new PDO($this->DB_DSN, $this->DB_USER, $this->DB_PASS);
	}
	public function query(string $string) {
		return $this->db->query($string);
	}
}