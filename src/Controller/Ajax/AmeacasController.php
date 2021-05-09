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

    public function beforeFilter(Event $evento)
    {
        parent::beforeFilter($evento);

        $this->Auth->allow([
            'novaAmeaca'
        ]);
    }

    public function index()
    {
        // Desabilita a renderização;
        $this->autoRender = false;
        $this->loadModel('Ameacas');
        $ameacas = $this->Ameacas->find('all')->contain([
            'Rankings'
        ])->where([
            'status' => 1,
            'NOT EXISTS(SELECT 1 FROM batalhas WHERE Ameacas.id = batalhas.ameaca_id > 0 AND batalhas.status = 0)'
        ]);
        echo json_encode($ameacas);
    }

    public function novaAmeaca($nome, $latitude, $longitude, $rank)
    {
        // Desabilita a renderização;
        $this->autoRender = false;
        $this->loadModel('Rankings');
        $this->loadModel('Ameacas');
        // Busca o ranking
        $ranking = $this->Rankings->find('all')->where([
            'ameaca' => $rank
        ])->first();
        // Cria nova ameaça
        $ameaca = $this->Ameacas->newEntity();
        $ameaca = $this->Ameacas->patchEntity($ameaca, [
            'nome' => $nome,
            'ranking_id' => $ranking->id,
            'latitude' => $latitude,
            'longitude' => $longitude
        ]);
        if ($this->Ameacas->save($ameaca)) {
            echo 'sucesso';
        } else {
            echo 'erro';
        }
    }

}
