<div class="d-flex p-2 align-items-center">
    <div class="p-2">
        <h2 class="m-0">Alterar Senha</h2>
    </div>
</div>
<hr>
<?= $this->Flash->render() ?>
<?= $this->Form->create('') ?>
<div class="form-row">
    <div class="form-group col-md-6">
        <label><span class="text-danger">*</span> Senha</label>
        <?= $this->Form->control('password', ['value' => '', 'class' => 'form-control', 'placeholder' => 'A senha deve ter no minimo 6 caracteres', 'label' => false, 'autocomplete' => 'off']) ?>
    </div>
</div>
<hr>
<?= $this->Form->button('Salvar', ['class' => 'btn btn-success']) ?>
<?= $this->Form->end() ?>
