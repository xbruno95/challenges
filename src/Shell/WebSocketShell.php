<?php
namespace App\Shell;

use App\Utility\Impulsor;
use Cake\Console\Shell;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Wamp\WampServer;
use React\EventLoop\Factory;
use React\Socket\Server;
use React\ZMQ\Context;
use ZMQ;
use ZMQContext;

class WebSocketShell extends Shell
{
    public function main()
    {
        $loop   = Factory::create();
        $impulsor = new Impulsor;

        // Listen for the web server to make a ZeroMQ push after an ajax request
        $contexto = new Context($loop);

        $pull = $contexto->getSocket(ZMQ::SOCKET_PULL);
        $pull->bind('tcp://127.0.0.1:5555'); // Binding to 127.0.0.1 means the only client that can connect is itself
        $pull->on('message', [$impulsor, 'onMessage']);

        $webSock = new Server('0.0.0.0:8888', $loop);

        $webServer = new IoServer(
            new HttpServer(new WsServer(new WampServer($impulsor))),
            $webSock
        );

        $loop->run();
    }
}
