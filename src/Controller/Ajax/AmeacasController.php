<?php

namespace App\Controller\Ajax;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Security;
use Cake\Core\Configure;
use React\ZMQ\Context;
use ZMQ;
use ZMQContext;

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

    public function novaAmeaca()
    {
        // Desabilita a renderização;
        $this->autoRender = false;
        $this->loadModel('Rankings');
        $this->loadModel('Ameacas');
        if ($this->request->is('post')) {
            // Busca o ranking
            $ranking = $this->Rankings->find('all')->where([
                'ameaca' => $this->request->data('rank')
            ])->first();
            // Cria nova ameaça
            $ameaca = $this->Ameacas->newEntity();
            $ameaca = $this->Ameacas->patchEntity($ameaca, [
                'nome' => $this->request->data('nome'),
                'ranking_id' => $ranking->id,
                'latitude' => $this->request->data('latitude'),
                'longitude' => $this->request->data('longitude')
            ]);
            if ($this->Ameacas->save($ameaca)) {
                echo 'sucesso';
                $context = new ZMQContext();
                $socket = $context->getSocket(ZMQ::SOCKET_PUSH, 'my pusher');
                $socket->connect("tcp://localhost:5555");
                $socket->send(json_encode([
                    'tipo' => 'ameaca',
                    'ameaca' => [
                        'nome' => $this->request->data('nome'),
                        'rank' => $ranking->ameaca
                    ]
                ]));
            } else {
                echo 'erro';
            }
        } else {
            echo 'erro';
        }
    }

}
