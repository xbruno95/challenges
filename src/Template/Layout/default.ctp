<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>iHeros</title>
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Estilos -->
        <?= $this->Html->css([
            'plugins/bootstrap/bootstrap.min',
            'plugins/adminlte/adminlte.min',
            'plugins/fontawesome/css/all.min',
            'plugins/overlayscrollbars/OverlayScrollbars.min',
        ]); ?>
        <!-- Scripts -->
        <?= $this->Html->script([
            'plugins/jquery/jquery.min',
            'plugins/jquery_mask/jquery.mask',
            'plugins/bootstrap/js/bootstrap.bundle.min',
            'plugins/overlayScrollbars/js/jquery.overlayScrollbars.min',
            'plugins/adminlte/adminlte'
        ]);?>
    </head>

    <body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
        <div class="wrapper">
            <!-- Preloader -->
            <!-- <div class="preloader flex-column justify-content-center align-items-center">
                <img class="animation__wobble" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
            </div> -->
            <?= $this->element('menu_superior') ?>
            <?= $this->element('menu_lateral') ?>
            <div class="content-wrapper">
                <section class="content">
                    <div class="container-fluid">
                        <?= $this->fetch('content'); ?>
                    </div>
                </section>
            </div>
        </div>
    </body>
</html>
