<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Security;

/**
 * Class LoginController
 * @package App\Controller
 */
class LoginController extends AppController
{

    /**
     * Método index do login
     *
     * @return \Cake\Network\Response|void
     */
    public function index()
    {
        // Força remover qualquer sessão existente
        $this->_apagarSessao();
        // Altera o layout
        $this->layout = 'login';
        if ($this->request->is('post')) {
            $usuario = $this->Auth->identify();
            if ($usuario) {
                if ($usuario['ativo']) {
                    $this->Auth->setUser($usuario);
                    return $this->redirect($this->Auth->redirectUrl());
                }
                $this->Flash->error('Usuário desativado.');
            } else {
                $this->Flash->error('E-mail ou senha inválidos, tente novamente.');
            }
        }
    }

    /**
     * Encerra a sessão
     *
     * @return \Cake\Network\Response|void
     */
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    /**
     * Apaga a sessão
     *
     * @return void
     */
    private function _apagarSessao()
    {
		$redirect = $this->request->session()->read('Auth.redirect', '/');
        $this->request->session()->delete('Auth');
		$this->request->session()->write('Auth.redirect', $redirect);
        $this->request->session()->delete('Parceiro');
    }

}
