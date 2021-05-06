<?php

	namespace App\Model\Entity;

	use Cake\Auth\DefaultPasswordHasher;
	use Cake\ORM\Entity;

	class Usuario extends Entity {

		protected $_acceddible = ['*' => true];

		// Criptografa a senha
		protected function _setPassword($password){
			return (new DefaultPasswordHasher)->hash($password);
		}

	}
