<div class="d-flex p-2 align-items-center">
    <div class="p-2 mr-auto">
        <h2 class="m-0">Adicionar Usuário</h2>
    </div>
    <div class="p-2">
        <?= $this->Html->link('Usuários', ['controller' => 'Usuarios', 'action' => 'index'], ['class' => 'btn btn-info btn-sm']); ?>
    </div>
</div>
<hr>
<?= $this->Flash->render() ?>
<?= $this->Form->create($usuario) ?>
<div class="form-row">
    <div class="form-group col-md-6">
        <label><span class="text-danger">*</span> Nome</label>
        <?= $this->Form->control('nome', ['class' => 'form-control', 'placeholder' => 'Nome completo', 'label' => false, 'autocomplete' => 'off']) ?>
    </div>
    <div class="form-group col-md-6">
        <label><span class="text-danger">*</span> E-mail</label>
        <?= $this->Form->control('email', ['class' => 'form-control', 'placeholder' => 'Seu melhor e-mail', 'label' => false, 'autocomplete' => 'off']) ?>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-6">
        <label><span class="text-danger">*</span> Senha</label>
        <?= $this->Form->control('password', ['class' => 'form-control', 'placeholder' => 'A senha deve ter no minimo 6 caracteres', 'label' => false, 'autocomplete' => 'off']) ?>
    </div>
</div>
<hr>
<?= $this->Form->button('Salvar', ['class' => 'btn btn-success']) ?>
<?= $this->Form->end() ?>
