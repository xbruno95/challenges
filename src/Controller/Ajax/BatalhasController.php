<?php

namespace App\Controller\Ajax;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Security;

/**
 * Class BatalhasController
 * @package App\Controller
 */
class BatalhasController extends AppController
{

    public function index()
    {
        // Desabilita a renderização;
        $this->autoRender = false;
        $this->loadModel('Batalhas');
        $this->loadModel('Herois');
        $batalhas = $this->Batalhas->find('all')->contain([
            'Ameacas'
        ])->where([
            'Batalhas.status' => 0,
        ]);
        foreach ($batalhas as $batalha) {
            foreach (explode(',', $batalha->herois) as $heroi_id) {
                $heroi = $this->Herois->get($heroi_id, [
                    'contain' => ['Rankings']
                ]);
                $batalha->herois_nome .= $heroi->nome.'<br>';
            }
        }
        $this->response->body(json_encode($batalhas));
        return $this->response;
    }

}
