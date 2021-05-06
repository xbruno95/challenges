<nav class="main-header navbar navbar-expand navbar-dark">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle menu-header" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown">
                <span class="d-none d-sm-inline">
                    <i class="fas fa-cog"></i>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                <?= $this->Html->link(
                    '<i class="fas fa-key"></i> Alterar Senha',
                    ['controller' => 'Usuarios', 'action' => 'alterarSenha'],
                    ['class' => 'nav-link', 'escape' => false]
                ); ?>
                <?= $this->Html->link(
                    '<i class="fas fa-sign-out-alt"></i> Sair',
                    ['controller' => 'Login', 'action' => 'logout'],
                    ['class' => 'nav-link', 'escape' => false]
                ); ?>
            </div>
        </li>
        <!-- <li class="nav-item dropdown">
            <?= $this->Html->link(
                '<i class="fas fa-sign-out-alt"></i> Sair',
                ['controller' => 'Login', 'action' => 'logout'],
                ['class' => 'nav-link', 'escape' => false]
            ); ?>
        </li> -->
    </ul>
</nav>
