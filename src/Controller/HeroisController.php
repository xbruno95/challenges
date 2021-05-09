<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Security;

/**
 * Class HeroisController
 * @package App\Controller
 */
class HeroisController extends AppController
{

    /**
     * Lista os herois
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'limit' => 15
        ];
        $conditions = [];
        if ($this->request->is(['post', 'put'])) {
            if ($this->request->data['nome'] != '') {
                $conditions[] = ['Herois.nome LIKE' => '%'.$this->request->data['nome'].'%'];
            }
            if($this->request->data['ativo'] == '0') {
                $conditions[] = ['Herois.ativo' => '0'];
            } else {
                $conditions[] = ['Herois.ativo' => '1'];
            }
        }
        $herois = $this->paginate(
            $this->Herois->find('all')->contain(['Rankings'])->where($conditions)
        );
        $this->set(compact('herois'));
    }

    /**
     * Adiciona um heroi
     *
     * @return void
     */
    public function adicionar()
    {
        $this->LoadModel('Rankings');
        $rankings = $this->Rankings->find('list');
        $heroi = $this->Herois->newEntity();
        if ($this->request->is('post')) {
            $heroi = $this->Herois->patchEntity($heroi, $this->request->data());
            if ($this->Herois->save($heroi)) {
                $this->Flash->success(('Herói cadastrado com sucesso.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->danger(('Herói não foi cadastrado.'));
        }
        $this->set(compact('heroi', 'rankings'));
    }

    /**
     * Altera o herói
     *
     * @param string|null $id
     */
    public function alterar($id = null)
    {
        $this->LoadModel('Rankings');
        $rankings = $this->Rankings->find('list');
        $heroi = $this->Herois->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $heroi = $this->Herois->patchEntity($heroi, $this->request->data());
            if ($this->Herois->save($heroi)) {
                $this->Flash->success('Herói alterado com sucesso');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->danger('Não foi possível alterar os dados do herói');
        }
        $this->set(compact('heroi', 'rankings'));
    }

    /**
     * Altera o status do herói
     *
     * @param string|null $id
     */
    public function status($id = null)
    {
        $heroi = $this->Herois->get($id);
        $heroi = $this->Herois->patchEntity($heroi, [
            'ativo' => $heroi->ativo ? 0 : 1
        ]);
        if ($this->Herois->save($heroi)) {
            $this->Flash->success('Herói ' . ($heroi->ativo ? 'ativado' : 'desativado') . ' com sucesso');
        } else {
            $this->Flash->danger('Não foi possível ' . ($heroi->ativo ? 'ativar' : 'desativar') . ' o herói');
        }
        return $this->redirect(['action' => 'index']);
    }

}
