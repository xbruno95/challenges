<?php

namespace App\Controller\Ajax;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Security;

/**
 * Class HeroisController
 * @package App\Controller
 */
class HeroisController extends AppController
{

    public function index()
    {
        // Desabilita a renderização;
        $this->autoRender = false;
        $this->loadModel('Herois');
        $herois = $this->Herois->find('all')->contain([
            'Rankings'
        ])->where([
            'ativo' => 1,
            'NOT EXISTS(SELECT 1 FROM batalhas WHERE FIND_IN_SET(Herois.id, batalhas.herois) > 0 AND batalhas.status = 0)'
        ]);
        echo json_encode($herois);
    }

}
