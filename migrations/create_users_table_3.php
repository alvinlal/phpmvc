<?php

class create_users_table_3 {
	public function up($db) {
		$SQL = 'CREATE TABLE IF NOT EXISTS users(
            id INT AUTO_INCREMENT,
            name VARCHAR(30),
            username VARCHAR(30) UNIQUE,
            email VARCHAR(30) UNIQUE,
            password VARCHAR(128),
            PRIMARY KEY (id)
        );';
		$db->exec($SQL);
	}
	public function down() {
		echo "Down migration create_pizzas_table" . PHP_EOL;
	}
}