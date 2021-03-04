<?php

namespace app\models;
use app\core\Model;

class User extends Model {

	public $id;
	public $name;

	public function signup($data) {
		return $this->insert('INSERT INTO users (name,username,email,password) VALUES(:name,:username,:email,:password)', [
			'name' => trim($data['name']),
			'username' => $data['username'],
			'email' => $data['email'],
			'password' => password_hash($data['password'], PASSWORD_DEFAULT, ['cost' => 10]),
		]);
	}
	public function validateSignupInput($input) {
		$errors = [
			'name' => '',
			'username' => '',
			'email' => '',
			'password' => [],
			'confirmPassword' => '',
		];
		if (empty(trim($input['name']))) {
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

	public function validateLoginInput($data) {
		$errors = [
			'authKey' => '',
			'password' => '',
			'invalidCredentials' => '',
		];
		if (empty(trim($data['authKey']))) {
			$errors['authKey'] = 'Please provide a username or email';
		} else {
			$authKeyExists = $this->selectOne('SELECT id,name FROM users WHERE username=:authKey OR email=:authKey', ['authKey' => $data['authKey']]);
			if (!$authKeyExists) {
				$errors['invalidCredentials'] = 'Incorrect credentials';
			} else {
				$this->id = $authKeyExists['id'];
				$this->name = $authKeyExists['name'];
			}

			if (empty($data['password'])) {
				$errors['password'] = 'Please provide a password';
			} else if (!$errors['invalidCredentials'] && !$errors['authKey']) {
				$row = $this->selectOne('SELECT password FROM users WHERE username=:authKey OR email=:authKey', ['authKey' => $data['authKey']]);
				if (!password_verify($data['password'], $row['password'])) {
					$errors['invalidCredentials'] = 'Incorrect credentials';
				}
			}

		}
		return $errors;

	}
}