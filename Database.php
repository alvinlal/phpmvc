<?php

namespace alvin\phpmvc;

/**
 * Base class for exposing database methods
 */
class Database {

	/**
	 * PDO instance.
	 * @var \PDO
	 */
	public $sqldb;

	/**
	 * Type of datastore
	 * @var string
	 */
	public string $dbType;

	/**
	 * database name
	 * @var string
	 */
	private string $DB_NAME;

	/**
	 * database host name
	 * @var string
	 */
	private string $DB_HOST;

	/**
	 * database port
	 * @var string
	 */
	private string $DB_PORT;

	/**
	 * database user
	 * @var string
	 */
	private string $DB_USER;

	/**
	 * database password
	 * @var string
	 */
	private string $DB_PASS;

	/**
	 * data source name
	 * @var string
	 */
	private string $DB_DSN;

	/**
	 * Creates a new Database instance.
	 *
	 * @param string $dbType type of database to instantiate
	 */
	public function __construct(string $dbType = 'sql') {
		$this->dbType = $dbType;
		switch ($dbType) {
		case 'sql':{
				$this->setupSQL();
			}
		}
	}

	/**
	 * Setup SQL database connection.
	 *
	 * Sets up sql database connection using environment variables and instantiates pdo
	 *
	 * @return void
	 */
	private function setupSQL() {
		$this->DB_NAME = getenv('DB_NAME');
		$this->DB_HOST = getenv('DB_HOST');
		$this->DB_PORT = getenv('DB_PORT');
		$this->DB_USER = getenv('DB_USER');
		$this->DB_PASS = getenv('DB_PASS');
		$this->DB_DSN = "mysql:host=$this->DB_HOST:$this->DB_PORT;dbname=$this->DB_NAME";
		$this->sqldb = new \PDO($this->DB_DSN, $this->DB_USER, $this->DB_PASS);
		$this->sqldb->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
	}

	/**
	 * Query.
	 *
	 * Uses \PDO::query()
	 *
	 * @param string $string sql statement
	 * @return object|false
	 */
	public function query(string $string) {
		return $this->sqldb->query($string);
	}

	/**
	 * Prepare an sql statement.
	 *
	 * Uses \PDO::prepare() for prepared statements
	 *
	 * @param string $string sql statement
	 * @return object|false
	 */
	public function prepare(string $sql) {
		return $this->sqldb->prepare($sql);
	}

	/**
	 * Begin an sql transaction.
	 *
	 * Uses \PDO::beginTransaction() for beginning transactions
	 *
	 * @return boolean
	 */
	public function beginTransaction() {
		$this->sqldb->beginTransaction();
	}

	/**
	 * Rollback an sql transaction.
	 *
	 * Uses \PDO::rollBack() for rolling back transactions
	 *
	 * @return boolean
	 */
	public function rollBack() {
		$this->sqldb->rollBack();
	}

	/**
	 * Commit an sql transaction.
	 *
	 * Uses \PDO::commit() for commiting transactions
	 *
	 * @return boolean
	 */
	public function commit() {
		$this->sqldb->commit();
	}

	/**
	 * Get id for last inserted record.
	 *
	 * Uses \PDO::lastInsertId()
	 *
	 * @return boolean
	 */
	public function lastInsertId() {
		return $this->sqldb->lastInsertId();
	}
}