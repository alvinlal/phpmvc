<?php

class create_pizzas_table_2 {
	public function up($db) {
		$SQL = 'CREATE TABLE IF NOT EXISTS pizzas(
     		id INT NOT NULL AUTO_INCREMENT,
            userId INT,
	 		title VARCHAR(20),
	 		ingredients VARCHAR(255),
	 		created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            imageId INT NOT NULL,
	 		PRIMARY KEY (id),
			FOREIGN KEY (imageId) REFERENCES images(id)
			 );';

		$db->exec($SQL);
	}
	public function down() {
		echo "Down migration create_pizzas_table" . PHP_EOL;
	}
}