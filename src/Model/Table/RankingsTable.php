<?php

	namespace App\Model\Table;

	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	class RankingsTable extends Table {

		/**
		 *	Inicializa todas as dependencias
		 */
		public function initialize(array $config){
            $this->displayField(function ($e) {
                return $e->get('rank').' - Herói responsável por ameaças nível '.$e->get('ameaca');
            });
			$this->addBehavior('Timestamp');
		}

	}
