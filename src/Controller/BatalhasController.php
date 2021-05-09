<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Security;

/**
 * Class BatalhasController
 * @package App\Controller
 */
class BatalhasController extends AppController
{

    /**
     * Lista os batalhas
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'limit' => 10
        ];
        $this->loadModel('Herois');
        $batalhas = $this->Batalhas->find('all')->contain([
            'Ameacas' => [
                'Rankings'
            ]
        ])->where([
            'Batalhas.status !=' => 0
        ])->order(['Batalhas.id DESC']);
        $batalhas = $this->paginate($batalhas);
        foreach ($batalhas as $batalha) {
            foreach (explode(',', $batalha->herois) as $heroi_id) {
                $heroi = $this->Herois->get($heroi_id, [
                    'contain' => ['Rankings']
                ]);
                $batalha->herois_nome .= $heroi->nome.'<br>';
            }
        }
        $this->set(compact('batalhas'));
    }

}
