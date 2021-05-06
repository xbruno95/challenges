<?= $this->Form->create('', ['id' => 'log-in']); ?>
    <?= $this->Html->image('logo', ['class' => 'mb-4', 'width' => '72', 'height' => '57']); ?>
    <h1 class="text-white">iHeros</h1>
    <?= $this->Flash->render(); ?>
    <div class="form-floating">
        <input type="email" name="email" class="form-control" id="floatingInput" placeholder="E-mail">
        <label for="floatingInput">E-mail</label>
    </div>
    <div class="form-floating">
        <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Senha">
        <label for="floatingPassword">Senha</label>
    </div>
    <?= $this->Form->input('login', [
        'type'          => 'hidden',
        'class'         => 'form-control',
        'value'         => true
    ]); ?>
    <button class="w-100 btn btn-lg btn-primary" type="submit">Acessar</button>
    <p class="mt-5 mb-3 text-white">Copyright &copy; <?= date('Y'); ?></p>
</form>
