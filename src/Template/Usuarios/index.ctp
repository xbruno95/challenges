<div class="d-flex p-2 align-items-center">
    <div class="p-2 mr-auto">
        <h2 class="m-0">Usuários</h2>
    </div>
    <div class="p-2">
    <?= $this->Html->link('Adicionar', ['controller' => 'Usuarios', 'action' => 'adicionar'], ['class' => 'btn btn-success btn-sm']); ?>
    </div>
</div>
<hr>
<?= $this->Flash->render() ?>
<?= $this->Form->create(''); ?>
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <?= $this->Form->control('nome', [
                            'label'     => false,
                            'class'     => 'form-control form-resize',
                            'placeholder' => 'Nome'
                        ]);
                    ?>
                </div>
                <div class="col-md-3">
                    <?= $this->Form->control('ativo', [
                            'label'     => false,
                            'options'   => ['0' => 'Não', '1' => 'Sim'],
                            'empty'     => 'Ativo',
                            'class'     => 'form-control form-resize'
                    ]); ?>
                </div>
                <div class=" col-md-3">
                    <?= $this->Form->button(
                        '<i class="fas fa-fw fa-search"></i> Buscar',
                        ['escape' => false, 'class' => 'btn btn-primary']
                    ); ?>
                    <?php if ($this->request->is(['post', 'put'])) : ?>
                        <?= $this->Html->link(
                            '<i class="fas fa-fw fa-times"></i>', ['action' => 'index'],
                            ['escape' => false, 'class' => 'btn btn-danger']
                        ); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?= $this->Form->end(); ?>
<?php if ($usuarios->count() > 0) : ?>
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th class="d-sm-table-cell">E-mail</th>
                    <th class="d-sm-table-cell">Ativo</th>
                    <th class="d-lg-table-cell">Data do Cadastro</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?= h($usuario->nome) ?></td>
                        <td class="d-sm-table-cell">
                            <?= h($usuario->email) ?>
                        </td>
                        <td class="d-sm-table-cell">
                            <?= h($usuario->ativo) ? '<b class="text-success">Sim</b>' : '<b class="text-danger">Não</b>' ?>
                        </td>
                        <td class="d-lg-table-cell">
                            <?= h($usuario->created->format('d/m/Y H:i:s')) ?>
                        </td>
                        <td>
                            <span class="d-md-block">
                                <?= $this->Html->link('<i class="fa fa-fw fa-pencil-alt"></i>', ['controller' => 'Usuarios', 'action' => 'alterar', $usuario->id], ['escape' => false, 'class' => 'btn btn-warning btn-sm text-light', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Alterar Usuário']) ?>
                                <?php
                                    $botao = $usuario->ativo ? 'btn-success' : 'btn-danger';
                                    $tooltip = $usuario->ativo ? 'Desativar Usuário' : 'Ativar Usuário';
                                    $confirm = $usuario->ativo ? 'desativar' : 'ativar';
                                    $icone = $usuario->ativo ? 'fa-toggle-on' : 'fa-toggle-off';
                                ?>
                                <?= $this->Form->postLink("<i class='fa fa-fw {$icone}'></i>", ['controller' => 'Usuarios', 'action' => 'status', $usuario->id], ['escape' => false, 'class' => "btn {$botao} btn-sm", 'confirm' => "Deseja {$confirm} o registro especificado?", $usuario->id, 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => "{$tooltip}"]) ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?= $this->element('paginacao'); ?>
    </div>
<?php else: ?>
    <div class="alert alert-info">Nenhum registro encontrado no momento</div>
<?php endif; ?>

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
