<?php

namespace alvin\phpmvc;

/**
 * Database migrations class
 */
class Migrator {

	/**
	 * \PDO instance
	 * @var object
	 */
	private $db;

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
	 * path to migrations directory
	 * @var string
	 */
	private string $MIGRATION_DIR;

	/**
	 * Creates a new migrator instance
	 *
	 * @param string $MIGRATION_DIR path to migrations directory
	 */
	public function __construct($MIGRATION_DIR) {
		$this->MIGRATION_DIR = $MIGRATION_DIR;
		$this->DB_NAME = getenv('DB_NAME');
		$this->DB_HOST = getenv('DB_HOST');
		$this->DB_PORT = getenv('DB_PORT');
		$this->DB_USER = getenv('DB_USER');
		$this->DB_PASS = getenv('DB_PASS');
		$this->DB_DSN = "mysql:host=$this->DB_HOST;port=$this->DB_PORT;dbname=$this->DB_NAME";
		$this->db = new \PDO($this->DB_DSN, $this->DB_USER, $this->DB_PASS);
		$this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
	}

	/**
	 * Applies all specified migration.
	 *
	 * Scans for all migarations file and applies them in specified order
	 *
	 * @return void
	 */
	public function applyMigrations() {
		$this->createMigrationsTable();
		$appliedMigrations = $this->getAppliedMigrations();
		$toApplyMigrations = $this->getToApplyMigrations($this->MIGRATION_DIR, $appliedMigrations);
		$newMigrations = [];
		foreach ($toApplyMigrations as $migration) {
			require_once $this->MIGRATION_DIR . '/' . $migration;
			$className = pathinfo($migration, PATHINFO_FILENAME);
			$instance = new $className();
			$this->log("Applying migration $migration");
			$instance->up($this->db);
			$this->log("Applied migration $migration");
			$newMigrations[] = $migration;
		}

		if (!empty($newMigrations)) {
			$this->saveMigrations($newMigrations);
		} else {
			$this->log("All migrations are applied");
		}
	}

	/**
	 * Saves applied migration info to the database.
	 *
	 * @param array $migrations The migrations to save
	 * @return void
	 */
	public function saveMigrations(array $migrations) {
		$str = implode(',', array_map(fn($m) => "('$m')", $migrations));
		$stmt = $this->db->prepare("INSERT INTO migrations (migrations) VALUES $str");
		$stmt->execute();
	}

	/**
	 * Creates a migrations table.
	 *
	 * @return void
	 */
	public function createMigrationsTable() {
		$this->db->exec("CREATE TABLE IF NOT EXISTS migrations (
          id INT AUTO_INCREMENT PRIMARY KEY,
          migrations VARCHAR(255) UNIQUE,
          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
      )ENGINE=INNODB;");
	}

	/**
	 * Returns migrations to apply.
	 *
	 * Compares already applied migrations from db and existing migrations to apply
	 *
	 * @param string $migrationsDir Path to migrations directory
	 * @param array $appliedMigrations Already applied migrations
	 * @return array
	 */
	public function getToApplyMigrations($migrationsDir, $appliedMigrations) {
		$files = array_diff(scandir($migrationsDir), array('..', '.'));
		$toApplyMigrations = array_diff($files, $appliedMigrations);
		usort($toApplyMigrations, function ($a, $b) {
			if (!is_numeric($a[-5]) || !is_numeric($b[-5])) {
				throw new \Exception("naming format of migrations is incorrect, last character should be the order of execution");
				exit(1);
			}
			return $a[-5] < $b[-5] ? -1 : 1;
		});
		return $toApplyMigrations;
	}

	/**
	 * Returns already applied migrations
	 *
	 * @return array
	 */
	public function getAppliedMigrations() {
		$stmt = $this->db->prepare("SELECT migrations FROM migrations");
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_COLUMN);
	}

	/**
	 * logs a message
	 *
	 * @param string $message
	 * @return void
	 */
	public function log($message) {
		echo '[' . date('d-m-Y H:i:s') . '] - ' . $message . PHP_EOL;
	}
}