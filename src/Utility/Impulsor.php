<?php
namespace App\Utility;

use Ratchet\ConnectionInterface;
use Ratchet\Wamp\WampServerInterface;

class Impulsor implements WampServerInterface
{
    /**
     * A lookup of all the topics clients have subscribed to
     */
    protected $inscritos = array();

    public function onSubscribe(ConnectionInterface $conn, $inscricao)
    {
        $this->inscritos[$inscricao->getId()] = $inscricao;
    }

    /**
     * @param string JSON'ified string we'll receive from ZeroMQ
     */
    public function onMessage($dados)
    {
        $dados = json_decode($dados, true);

        // If the lookup topic object isn't set there is no one to publish to
        if (!array_key_exists($dados['tipo'], $this->inscritos)) {
            return;
        }

        $inscritosDoTipo = $this->inscritos[$dados['tipo']];

        // re-send the data to all the clients subscribed to that category
        $inscritosDoTipo->broadcast($dados);
    }

    public function onUnSubscribe(ConnectionInterface $conn, $topic)
    {
    }

    public function onOpen(ConnectionInterface $conn)
    {
    }

    public function onClose(ConnectionInterface $conn)
    {
    }

    public function onCall(ConnectionInterface $conn, $id, $topic, array $params)
    {
        // In this application if clients send data it's because the user hacked around in console
        $conn->callError($id, $topic, 'Você não tem permissão para escutar esse canal')->close();
    }

    public function onPublish(ConnectionInterface $conn, $topic, $event, array $exclude, array $eligible)
    {
        // In this application if clients send data it's because the user hacked around in console
        $conn->close();
    }
    public function onError(ConnectionInterface $conn, \Exception $e) {
    }
}
