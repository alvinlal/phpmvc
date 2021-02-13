<?php

namespace app\Models;

use app\core\Model;

class Pizza extends Model {

	public function getPizzas() {
		return $this->select('SELECT id,title,ingredients FROM pizzas ORDER BY created_at');
	}
	public function getPizza($id) {
		return $this->selectOne('SELECT * FROM pizzas WHERE id = ?', [$id]);
	}
	public function deletePizza($id) {
		return $this->delete('DELETE FROM pizzas WHERE id = ?', [$id]);
	}
	public function addPizza($data) {
		return $this->insert("INSERT INTO pizzas(email,title,ingredients) VALUES(:email,:title,:ingredients)", $data);
	}
	public static function validateInput($input) {
		$errors = [
			'email' => '',
			'title' => '',
			'ingredients' => '',
		];
		if (empty($input['email'])) {
			$errors['email'] = 'An email is required';
		} else {
			$email = $input['email'];
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$errors['email'] = 'Email is not valid';
			}
		}
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
		return $errors;
	}
}