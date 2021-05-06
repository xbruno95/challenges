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
            'Controller/Login/index',
            'plugins/bootstrap/bootstrap.min',
            'plugins/fontawesome/css/all.min',
        ]); ?>
        <!-- Scripts -->
        <?= $this->Html->script([
            'main',
            'plugins/jquery/jquery.min',
            'plugins/bootstrap/js/bootstrap.min',
        ]);?>
    </head>
    <body class="text-center">
        <main class="form-login">
            <?= $this->fetch('content'); ?>
        </main>
    </body>

</html>
