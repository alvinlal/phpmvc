<?php

namespace app\models;
use app\core\Model;

class User extends Model {
	public function signup($data) {
		$dataToInsert = [];
		$dataToInsert['name'] = $data['name'];
		$dataToInsert['username'] = $data['username'];
		$dataToInsert['email'] = $data['email'];
		$dataToInsert['password'] = password_hash($data['password'], PASSWORD_DEFAULT, ['cost' => 10]);
		return $this->insert('INSERT INTO users (name,username,email,password) VALUES(:name,:username,:email,:password)', [
			'name' => $dataToInsert['name'],
			'username' => $dataToInsert['username'],
			'email' => $dataToInsert['email'],
			'password' => $dataToInsert['password'],
		]);
	}
	public function validateInput($input) {
		$errors = [
			'name' => '',
			'username' => '',
			'email' => '',
			'password' => [],
			'confirmPassword' => '',
		];
		if (empty($input['name'])) {
			$errors['name'] = 'Name is required';
		}
		if (empty($input['username'])) {
			$errors['username'] = 'Username is required';
		} else {
			$username = $input['username'];
			if (!preg_match('/^[a-zA-Z0-9_]*$/', $username)) {
				$errors['username'] = 'Username must contain only letters,numbers and underscores';
			}

		}
		if (empty($input['email'])) {
			$errors['email'] = 'Email is required';
		} else {
			$email = $input['email'];
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$errors['email'] = 'Email is not valid';
			}
		}
		if (empty($input['password'])) {
			array_push($errors['password'], "Password is required");
		} else {
			$password = $input['password'];
			if (!preg_match('/^[a-zA-Z0-9]+$/', $password)) {
				array_push($errors['password'], "Password must contain only letters and numbers");
			}
			if (strlen($password) < 6) {
				array_push($errors['password'], "Password must contain atleast six characters");
			}
		}
		if (sizeof($errors['password']) == 0 && $input['password'] != $input['confirmPassword']) {
			$errors['confirmPassword'] = "Passwords don't match";
		}
		if (!$errors['username']) {
			$usernameExists = $this->exists('SELECT id FROM users WHERE username = ?', [$input['username']]);
			if ($usernameExists) {
				$errors['username'] = 'Username has been taken';
			}
		}
		if (!$errors['email']) {
			$emailExists = $this->exists('SELECT id FROM users WHERE email = ?', [$input['email']]);
			if ($emailExists) {
				$errors['email'] = 'Account already exists please login';
				foreach ($errors as $key => $value) {
					$key != 'email' && $errors[$key] = '';
				}
			}
		}

		return $errors;
	}
}