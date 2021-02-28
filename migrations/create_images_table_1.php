<?php

class create_images_table_1 {
	public function up($db) {
		$SQL = 'CREATE TABLE  IF NOT EXISTS images(
     		id INT NOT NULL AUTO_INCREMENT,
	 		contentType VARCHAR(10),
	 		last_modified VARCHAR(30),
            filename VARCHAR(30),
            size int,
	 		PRIMARY KEY (id)
			 );';

		$db->exec($SQL);
	}
	public function down() {
		echo "Down migration create_pizzas_table" . PHP_EOL;
	}
}