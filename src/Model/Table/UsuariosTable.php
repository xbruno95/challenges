<?php

	namespace App\Model\Table;

	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	class UsuariosTable extends Table {

		/**
		 *	Inicializa todas as dependencias
		 */
		public function initialize(array $config){
            $this->displayField('nome');
			$this->addBehavior('Timestamp');
		}

		/**
		 *	Realiza as validações dos dados
		 */
		public function validationDefault(Validator $validator){
			$validator
				->notEmpty('nome', 'O campo é obrigatório')
				->notEmpty('email', 'O campo é obrigatório')
				->add('email', [
					'unico' => [
						'rule' => 'validateUnique',
						'provider' => 'table',
						'message' => 'Já existe um usuário cadastrado com esse e-mail'
					]
				])
				->notEmpty('password', 'O campo é obrigatório')
				->add('password', [
					'tamanhoMinimo' => [
						'rule' => ['minLength', 6],
						'message' => 'A senha deve conter pelo menos 6 caracteres'
					]
				])
				->add('confirmacao', [
					'tamanhoMinimo' => [
						'rule' => ['minLength', 6],
						'message' => 'A senha deve conter pelo menos 6 caracteres'
					],
					'confirmacao' => [
						'rule' => function($valor, $contexto){
							/**
							 * Verifica se a senha passada é maior que 6 digitos
							 * e se é igual a sua confirmação
							 */
							if($contexto['data']['password'] == $valor){
								return true;
							}
							return false;
						},
						'message' => 'As senhas não conferem'
					]
				]);
				return $validator;
		}

	}
