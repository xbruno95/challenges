<?php

	namespace App\Model\Table;

	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	class AmeacasTable extends Table {

		/**
		 *	Inicializa todas as dependencias
		 */
		public function initialize(array $config){
            $this->setDisplayField('nome');
			$this->addBehavior('Timestamp');
            $this->belongsTo('Rankings', [
                'className' 	=> 'Rankings',
                'foreignKey' 	=> 'ranking_id',
            ]);
		}

		/**
		 *	Realiza as validações dos dados
		 */
		public function validationDefault(Validator $validator){
			$validator
				->notEmpty('nome', 'O campo é obrigatório')
				->notEmpty('ranking_id', 'O campo é obrigatório')
				->notEmpty('latitude', 'O campo é obrigatório')
				->notEmpty('longitude', 'O campo é obrigatório');
				return $validator;
		}

	}
