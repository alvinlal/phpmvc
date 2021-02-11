<?php

namespace app\Models;

use app\core\Model;

class User extends Model {

	public function getPizzas() {
		return $this->query('SELECT * FROM pizzas WHERE id=?', [2]);
	}
}