<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="/ihero/painel" class="brand-link">
        <?= $this->Html->image('logo', ['class' => 'brand-image', 'style' => 'opacity: .8']); ?>
        <span class="brand-text font-weight-light">iHeros</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <!-- <div class="image">
                <img src="" class="img-circle elevation-2" alt="User Image">
            </div> -->
            <div class="info">
                <a href="#" class="d-block"><?= $this->request->getSession()->read('Auth.User.nome'); ?></a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">Geral</li>
                <li class="nav-item">
                    <?= $this->Html->link(
                        '<i class="nav-icon fas fa-exclamation-triangle"></i> <p>Painel de controle</p>',
                        ['controller' => 'Painel', 'action' => 'index'],
                        ['class' => 'nav-link', 'escape' => false]
                    ); ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(
                        '<i class="nav-icon fas fa-mask"></i> <p>Heróis</p>',
                        ['controller' => 'Herois', 'action' => 'index'],
                        ['class' => 'nav-link', 'escape' => false]
                    ); ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(
                        '<i class="nav-icon fas fa-users"></i> <p>Usuarios</p>',
                        ['controller' => 'Usuarios', 'action' => 'index'],
                        ['class' => 'nav-link', 'escape' => false]
                    ); ?>
                </li>
            </ul>
        </nav>
    </div>
</aside>
