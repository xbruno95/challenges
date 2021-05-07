<?php

namespace App\Controller\Ajax;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Security;

/**
 * Class HeroisController
 * @package App\Controller
 */
class AmeacasController extends AppController
{

    public function index()
    {
        // Desabilita a renderização;
        $this->autoRender = false;
        $this->loadModel('Ameacas');
        $ameacas = $this->Ameacas->find('all')->contain([
            'Rankings'
        ])->where([
            'status' => 1
        ]);
        echo json_encode($ameacas);
    }

}
