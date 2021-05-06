<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Security;

/**
 * Class UsuariosController
 * @package App\Controller
 */
class UsuariosController extends AppController
{

    /**
     * Lista os usuários
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'limit' => 40
        ];
        $conditions = ['Usuarios.id !=' => $this->Auth->user('id')];
        if ($this->request->is(['post', 'put'])) {
            if ($this->request->data['nome'] != '') {
                $conditions[] = ['Usuarios.nome LIKE' => '%'.$this->request->data['nome'].'%'];
            }
            if($this->request->data['ativo'] == '0') {
                $conditions[] = ['Usuarios.ativo' => '0'];
            } else {
                $conditions[] = ['Usuarios.ativo' => '1'];
            }
        }
        $usuarios = $this->paginate(
            $this->Usuarios->find('all')->where($conditions)
        );
        $this->set(compact('usuarios'));
    }

    /**
     * Adiciona um usuário
     *
     * @return void
     */
    public function adicionar()
    {
        $usuario = $this->Usuarios->newEntity();
        if ($this->request->is('post')) {
            $usuario = $this->Usuarios->patchEntity($usuario, $this->request->data());
            if ($this->Usuarios->save($usuario)) {
                $this->Flash->success(('Usuário cadastrado com sucesso.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->danger(('Usuário não foi cadastrado.'));
        }
        $this->set(compact('usuario'));
    }

    /**
     * Altera o usuário
     *
     * @param string|null $id
     */
    public function alterar($id = null)
    {
        $usuario = $this->Usuarios->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $usuario = $this->Usuarios->patchEntity($usuario, $this->request->data());
            if ($this->Usuarios->save($usuario)) {
                $this->Flash->success('Usuário alterado com sucesso');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->danger('Não foi possível alterar o usuário');
        }
        $this->set(compact('usuario'));
    }

    /**
     * Altera o status do usuário
     *
     * @param string|null $id
     */
    public function status($id = null)
    {
        $usuario = $this->Usuarios->get($id);
        $usuario = $this->Usuarios->patchEntity($usuario, [
            'ativo' => $usuario->ativo ? 0 : 1
        ]);
        if ($this->Usuarios->save($usuario)) {
            $this->Flash->success('Usuário ' . ($usuario->ativo ? 'ativado' : 'desativado') . ' com sucesso');
        } else {
            $this->Flash->danger('Não foi possível ' . ($usuario->ativo ? 'ativar' : 'desativar') . ' o usuário');
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Altera a senha do usuário logado
     *
     * @param string|null $id
     */
    public function alterarSenha()
    {
        if ($this->request->is(['patch', 'post', 'put'])) {
            $usuario = $this->Usuarios->get($this->Auth->user('id'));
            $usuario = $this->Usuarios->patchEntity($usuario, $this->request->data());
            if ($this->Usuarios->save($usuario)) {
                $this->Flash->success('Sua senha foi alterada com sucesso.');
            } else {
                $this->Flash->danger('Não foi possível alterar a sua senha.');
            }
            return $this->redirect(['controller' => 'Painel', 'action' => 'index']);
        }
    }

}
