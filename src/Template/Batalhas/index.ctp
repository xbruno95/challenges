<div class="d-flex p-2 align-items-center">
    <div class="p-2 mr-auto">
        <h2 class="m-0">Batalhas</h2>
    </div>
</div>
<hr>
<?= $this->Flash->render() ?>
<?php if ($batalhas->count() > 0) : ?>
    <div class="row row-cols-1 row-cols-md-2 g-4">
        <?php foreach ($batalhas as $batalha): ?>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <b>
                                Resultado:
                                <span class="<?= $batalha->status == 1 ? 'text-success' : 'text-danger'; ?>">
                                    <?= $batalha->status == 1 ? 'Vitória' : 'Derrota'; ?>
                                </span><br>
                                Nível da Ameaça: <?= $batalha->ameaca->ranking->ameaca ?><br>
                                Data: <?= $batalha->created->format('d/m/Y'); ?>
                            </b>
                        </h5>
                        <div class="card-text text-center p-3">
                            <h4><?= $batalha->herois_nome ?></h4>
                            <h5>VS</h4>
                            <h4><?= $batalha->ameaca->nome ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?= $this->element('paginacao'); ?>
<?php else: ?>
<div class="alert alert-info">Nenhum registro encontrado no momento</div>
<?php endif; ?>
