<?php

	namespace App\Model\Table;

	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	class BatalhasTable extends Table {

		/**
		 *	Inicializa todas as dependencias
		 */
		public function initialize(array $config){
			$this->addBehavior('Timestamp');
            $this->belongsTo('Ameacas', [
                'className' 	=> 'Ameacas',
                'foreignKey' 	=> 'ameaca_id',
            ]);
		}

	}
