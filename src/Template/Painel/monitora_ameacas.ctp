<?= $this->Html->script([
    'plugins/socket.io/socket.io.v2.js',
]);?>
<script>
    const socket = io.connect("https://zrp-challenge-socket.herokuapp.com", {
        transports: ["websocket"]
    });

    socket.connect(function (event) {
        console.log('Conectado')
    })
    socket.on("disconnect", function () {
        console.log('Disconectado')
    });

    socket.on('occurrence', function (ameaca) {
        $.ajax({
            url: '<?= ENDERECO ?>/ajax/ameacas/novaAmeaca/'+ameaca.monsterName+'/'+ameaca.location[0].lat+'/'+ameaca.location[0].lng+'/'+ameaca.dangerLevel,
            success: function (dados) {
                if (dados == 'sucesso') {
                    console.log('Nova ameaça cadastrada.');
                }
            }
        });
    });

    socket.on("connect_error", (err) => {
        console.log(`Erro - ${err}`);
    });

</script>
