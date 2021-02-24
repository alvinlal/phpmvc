<?php

namespace app\Models;

use app\core\Model;

class Pizza extends Model {

	public function getPizzas() {
		return $this->select('SELECT id,title,ingredients FROM pizzas ORDER BY created_at');
	}
	public function getPizza($id) {
		return $this->selectOne('SELECT pizzas.id,title,ingredients,users.username,created_at FROM pizzas INNER JOIN users ON pizzas.userId=users.id WHERE pizzas.id=?', [$id]);
	}
	public function deletePizza($id) {
		return $this->delete('DELETE FROM pizzas WHERE id = ?', [$id]);
	}
	public function addPizza($data) {
		$data['userId'] = $this->getSession('userId');
		unset($data['photo']);
		$fileName = $this->upload("pizzas", "photo");
		if ($fileName) {
			$data['image'] = $fileName;
		} else {
			return false;
		}

		return $this->insert("INSERT INTO pizzas(userId,title,ingredients,image) VALUES(:userId,:title,:ingredients,:image)", $data);
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