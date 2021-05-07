<?php

    namespace App\Shell;

    use Cake\Console\Shell;
    use Cake\I18n\Time;
    use Cake\Core\Configure;

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
            foreach ($herois as $heroi) {
                $this->out($heroi->nome.' alocado!');
                $herois_alocados[] = $heroi->id;
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
                    $this->out('Batalha Iniciada!');
                }
            } else {
                $this->out('Não foi possivel iniciar a batalha.');
            }
        }
    }

?>
