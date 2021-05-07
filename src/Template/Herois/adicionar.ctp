<div class="d-flex p-2 align-items-center">
    <div class="p-2 mr-auto">
        <h2 class="m-0">Adicionar Herói</h2>
    </div>
    <div class="p-2">
        <?= $this->Html->link('Heróis', ['controller' => 'Herois', 'action' => 'index'], ['class' => 'btn btn-info btn-sm']); ?>
    </div>
</div>
<hr>
<?= $this->Flash->render() ?>
<?= $this->Form->create($heroi) ?>
<div class="form-row">
    <div class="form-group col-md-6">
        <label><span class="text-danger">*</span> Nome</label>
        <?= $this->Form->control('nome', ['class' => 'form-control', 'placeholder' => 'Nome completo', 'label' => false, 'autocomplete' => 'off']) ?>
    </div>
    <div class="form-group col-md-6">
        <label><span class="text-danger">*</span> Ranking</label>
        <?= $this->Form->control('ranking_id', [
            'class'     => 'form-control',
            'options'   => $rankings,
            'label'     => false
        ]); ?>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-6">
        <label><span class="text-danger">*</span> Latitude</label>
        <?= $this->Form->control('latitude', ['class' => 'form-control latitude', 'placeholder' => 'Ex: -5.836597', 'label' => false, 'autocomplete' => 'off']) ?>
    </div>
    <div class="form-group col-md-6">
        <label><span class="text-danger">*</span> Longitude</label>
        <?= $this->Form->control('longitude', ['class' => 'form-control longitude', 'placeholder' => 'Ex: -35.236007', 'label' => false, 'autocomplete' => 'off']) ?>
    </div>
</div>
<hr>
<?= $this->Form->button('Salvar', ['class' => 'btn btn-success']) ?>
<?= $this->Form->end() ?>
<?= $this->Html->script(['main']);?>
