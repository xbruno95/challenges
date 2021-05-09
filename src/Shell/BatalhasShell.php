<?php

    namespace App\Shell;

    use Cake\Console\Shell;
    use Cake\I18n\Time;
    use Cake\Core\Configure;
    use React\ZMQ\Context;
    use ZMQ;
    use ZMQContext;

    class BatalhasShell extends Shell
    {
        public function main()
        {
            $this->loadModel('Batalhas');
            $this->loadModel('Ameacas');
            $this->loadModel('Herois');

            $this->out('INICIANDO SCRIPT');
            $this->hr();
            // Busca a ameaça mais antiga
            $ameaca = $this->Ameacas->find('all')->contain([
                'Rankings'
            ])->where([
                'status' => 1,
                'NOT EXISTS(SELECT 1 FROM batalhas WHERE Ameacas.id = batalhas.ameaca_id > 0 AND batalhas.status = 0)'
            ])->order(['Ameacas.created'])->first();
            // Verifica se encontrou alguma ameaça
            if (!$ameaca) {
                $this->out('Nenhuma ameaça encontrada.');
                die();
            }
            // Busca os heróis
            $herois = $this->Herois->find('all')->contain([
                'Rankings'
            ])->where([
                'ativo' => 1,
                'NOT EXISTS(SELECT 1 FROM batalhas WHERE FIND_IN_SET(Herois.id, batalhas.herois) > 0 AND batalhas.status = 0)'
            ])->order([
                "ST_Distance_Sphere(point(Herois.longitude, Herois.latitude), point({$ameaca->longitude}, {$ameaca->latitude}))",
                "ABS(ranking_id - {$ameaca->ranking_id})"
            ]);
            // Aloca os heróis necessários para conter a ameaça
            $ameaca_saude = $ameaca->ranking->classificacao;
            $herois_alocados = [];
            $nome_herois_alocados = '';
            foreach ($herois as $heroi) {
                $this->out($heroi->nome.' alocado!');
                $herois_alocados[] = $heroi->id;
                $nome_herois_alocados .= $heroi->nome.'<br>';
                $ameaca_saude = $ameaca_saude - $heroi->ranking->classificacao;
                if ($ameaca_saude <= 0) {
                    break;
                }
            }
            if (!empty($herois_alocados)) {
                $batalha = $this->Batalhas->newEntity();
                $batalha = $this->Batalhas->patchEntity($batalha, [
                    'ameaca_id' => $ameaca->id,
                    'herois' => implode(',', $herois_alocados),
                ]);
                if ($this->Batalhas->save($batalha)) {
                    // Envia push para o websocket
                    $this->websocket('batalha', [
                        'ameaca' => $ameaca->nome,
                        'herois' => $nome_herois_alocados
                    ]);
                    $this->out('Batalha Iniciada!');
                }
            } else {
                $this->out('Não foi possivel iniciar a batalha.');
            }
        }

        public function encerrar()
        {
            $this->loadModel('Batalhas');
            $this->loadModel('Ameacas');
            $this->loadModel('Herois');

            $this->out('INICIANDO SCRIPT');
            $this->hr();
            // Busca a batalha mais antiga
            $batalha = $this->Batalhas->find('all')->contain([
                'Ameacas' => [
                    'Rankings'
                ]
            ])->where([
                'Batalhas.status' => 0
            ])->order(['Batalhas.created'])->first();
            // Verifica se encontrou alguma batalha
            if (!$batalha) {
                $this->out('Nenhuma batalha encontrada.');
                die();
            }
            // Somo o poder total dos heróis
            $poder_total = 0;
            foreach (explode(',', $batalha->herois) as $heroi_id) {
                $heroi = $this->Herois->get($heroi_id, [
                    'contain' => ['Rankings']
                ]);
                $poder_total += $heroi->ranking->classificacao;
            }
            if ($batalha->ameaca->ranking->classificacao <= $poder_total) {
                $status = 1;
                // Marca a ameaça como derrotada
                $ameaca = $this->Ameacas->get($batalha->ameaca_id);
                $ameaca = $this->Ameacas->patchEntity($ameaca, [
                    'status' => 0
                ]);
                $this->Ameacas->save($ameaca);
            } else {
                $status = 2;
            }
            // Encerra a batalha
            $batalha = $this->Batalhas->patchEntity($batalha, [
                'status' => $status
            ]);
            $this->Batalhas->save($batalha);
            // Envia push para o websocket
            $this->websocket('encerrar', [
                'ameaca' => $batalha->ameaca->nome,
                'status' => $status
            ]);
            $this->out('Batalha encerrada.');
        }

        public function websocket($tipo, $dados)
        {
            $context = new ZMQContext();
            $socket = $context->getSocket(ZMQ::SOCKET_PUSH, 'my pusher');
            $socket->connect("tcp://localhost:5555");
            $socket->send(json_encode([
                'tipo' => $tipo,
                'batalha' => $dados
            ]));
        }
    }

?>
