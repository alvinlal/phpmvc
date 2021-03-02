<?php

namespace app\Models;

use app\core\Model;
use PDOException;

class Pizza extends Model {

	public function getPizzas() {
		return $this->select('SELECT pizzas.id,title,ingredients,filename FROM pizzas JOIN images ON pizzas.imageId=images.id ORDER BY created_at');
	}
	public function getPizza($id) {
		return $this->selectOne('SELECT pizzas.id,title,ingredients,users.username,created_at,filename FROM pizzas INNER JOIN users ON pizzas.userId=users.id JOIN images ON pizzas.imageId=images.id WHERE pizzas.id=?', [$id]);
	}
	public function deletePizza($id) {
		return $this->delete('DELETE FROM pizzas WHERE id = ?', [$id]);
	}
	public function addPizzaPhoto() {
		$photo = [];

		$uploadPath = __DIR__ . '/../public/uploads/pizzas/';
		$fileName = $this->upload($uploadPath, "photo");
		$filePath = $uploadPath . $fileName;
		$fileSize = filesize($filePath);
		$contentType = mime_content_type($filePath);
		$lastModified = date(DATE_RFC822, filemtime($filePath));

		$photo['filename'] = $fileName;
		$photo['contentType'] = $contentType;
		$photo['last_modified'] = $lastModified;
		$photo['size'] = $fileSize;

		if ($fileName) {
			return $photo;
		}
		return false;
	}
	public function addPizza($data) {
		$data['userId'] = $this->getSession('userId');
		unset($data['photo']);
		$photo = $this->addPizzaPhoto();
		if (!$photo) {
			return false;
		}
		$this->beginTransaction();
		try {
			$this->insert("INSERT INTO images(contentType,last_modified,size,filename) VALUES(:contentType,:last_modified,:size,:filename)", $photo);
			$photoId = $this->lastInsertId();
			$data['imageId'] = $photoId;
			$this->insert("INSERT INTO pizzas(title,userId,ingredients,imageId) VALUES(:title,:userId,:ingredients,:imageId)", $data);
			$this->commit();
			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			$this->rollback();
			return false;
		}
	}
	public static function validateInput($input) {
		$errors = [
			'title' => '',
			'ingredients' => '',
			'photo' => [],
		];
		if (empty($input['title'])) {
			$errors['title'] = 'A title is required';
		} else {
			$title = $input['title'];
			if (!preg_match('/^[a-zA-Z\s]+$/', $title)) {
				$errors['title'] = 'Title must be letters and spaces only';
			}
		}
		if (empty($input['ingredients'])) {
			$errors['ingredients'] = 'Atleast one ingredient is required';
		} else {
			$ingredients = $input['ingredients'];
			if (!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)) {
				$errors['ingredients'] = 'Ingredients must be a comma separated list';
			}
		}
		if ($input['photo']['error'] == UPLOAD_ERR_NO_FILE) {
			array_push($errors['photo'], "Please select a photo");
		} else {
			$fileTypes = ['jpg', 'png', 'jpeg'];
			if ($input['photo']['error'] == UPLOAD_ERR_INI_SIZE) {
				array_push($errors['photo'], "file Size must be less than 2mb");
			}
			if (!in_array($input['photo']['ext'], $fileTypes)) {
				array_push($errors['photo'], "file format not suported");
			}
		}

		return $errors;
	}
}