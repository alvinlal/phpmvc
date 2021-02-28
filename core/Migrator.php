<?php

namespace app\core;
use app\core\Application;
use Exception;
use PDO;

class Migrator {
	private $db;
	private string $DB_NAME;
	private string $DB_HOST;
	private string $DB_PORT;
	private string $DB_USER;
	private string $DB_PASS;
	private string $DB_DSN;
	private string $MIGRATION_DIR;

	public function __construct($MIGRATION_DIR) {
		$this->MIGRATION_DIR = $MIGRATION_DIR;
		$this->DB_NAME = getenv('DB_NAME');
		$this->DB_HOST = getenv('DB_HOST');
		$this->DB_PORT = getenv('DB_PORT');
		$this->DB_USER = getenv('DB_USER');
		$this->DB_PASS = getenv('DB_PASS');
		$this->DB_DSN = "mysql:host=$this->DB_HOST;dbname=$this->DB_NAME";
		$this->db = new PDO($this->DB_DSN, $this->DB_USER, $this->DB_PASS);
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

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
	public function saveMigrations(array $migrations) {
		$str = implode(',', array_map(fn($m) => "('$m')", $migrations));
		$stmt = $this->db->prepare("INSERT INTO migrations (migrations) VALUES $str");
		$stmt->execute();
	}

	public function createMigrationsTable() {
		$this->db->exec("CREATE TABLE IF NOT EXISTS migrations (
          id INT AUTO_INCREMENT PRIMARY KEY,
          migrations VARCHAR(255) UNIQUE,
          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
      )ENGINE=INNODB;");
	}
	public function getToApplyMigrations($migrationsDir, $appliedMigrations) {
		$files = array_diff(scandir($migrationsDir), array('..', '.'));
		$toApplyMigrations = array_diff($files, $appliedMigrations);
		usort($toApplyMigrations, function ($a, $b) {
			if (!is_numeric($a[-5]) || !is_numeric($b[-5])) {
				throw new Exception("naming format of migrations is incorrect, last character should be the order of execution");
				exit(1);
			}
			return $a[-5] < $b[-5] ? -1 : 1;
		});
		return $toApplyMigrations;
	}
	public function getAppliedMigrations() {
		$stmt = $this->db->prepare("SELECT migrations FROM migrations");
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_COLUMN);
	}
	public function log($message) {
		echo '[' . date('d-m-Y H:i:s') . '] - ' . $message . PHP_EOL;
	}
}