<div class="d-flex p-2 align-items-center">
    <div class="p-2">
        <h4 class="m-0">Painel de controle</h4>
    </div>
</div>
<div id="map" style="width:100%;height:400px;"></div>
<hr>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDezWJoTnJxJZX0d2E0wWYEdr3rjEFWuQ8&callback=intanciaMapa" async>
</script>
<?= $this->Html->script([
    'plugins/autobahn/autobahn',
]);?>
<script>
    const icone_ameaca = "<?= $this->Url->image('icone_ameaca.png'); ?>";
    const icone_heroi = "<?= $this->Url->image('icone_heroi.png'); ?>";
    const icone_batalha = "<?= $this->Url->image('icone_batalha.png'); ?>";

    let ameacas_markers = [];
    let herois_markers = [];
    let batalhas_markers = [];

    let map;
    function intanciaMapa() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: -16.226514, lng: -50.097995 },
            zoom: 4,
        });
    }

    var conn = new ab.Session('ws://localhost:8888',
        () => {
            conn.subscribe('batalha', (tipo, dados) => {
                Swal.fire({
                    title: '<strong>Batalha iniciada</strong>',
                    html:
                        '<div class="text-center">' +
                            '<h3>'+dados.batalha.herois+'</h3>' +
                            '<?= $this->Html->image('vs.gif', ['class' => 'img-fluid', 'style' => 'width: 80px; padding: 10px;']); ?>' +
                            '<h3>'+dados.batalha.ameaca+'</h3>' +
                        '</div>',
                    showCloseButton: true
                });
                removeMarkers();
                buscaHerois();
                buscaAmeacas();
                buscaBatalhas();
            });
            conn.subscribe('encerrar', (tipo, dados) => {
                var status = dados.batalha.status == 1 ? 'Derrotado' : 'Ainda está de pé'
                Swal.fire({
                    title: '<strong>Batalha Encerrada</strong>',
                    icon: dados.batalha.status == 1 ? 'success' : 'danger',
                    html:
                        '<div class="text-center">' +
                            '<h2>'+dados.batalha.ameaca+'</h2>' +
                            '<h5>'+status+'</h5>' +
                        '</div>',
                    showCloseButton: true
                });
                removeMarkers();
                buscaHerois();
                buscaAmeacas();
                buscaBatalhas();
            });
        },
        function() {
            console.log('Conexão com WebSocket encerrada');
        },
        {'skipSubprotocolCheck': true}
    );

    // Dados iniciais
    buscaHerois();
    buscaAmeacas();
    buscaBatalhas();

    // $('#criar').click(function(){

    //     informacoes =
    //         '<div id="content" style="color: #000">' +
    //             '<h3>Monstro</h3>' +
    //             '<div>' +
    //                 'Nível da ameaça: Dragon<br>' +
    //                 'Status: Ativo' +
    //             '</div>' +
    //         '</div>';
    //     var infowindow = new google.maps.InfoWindow({
    //         content: informacoes,
    //     });
    //     var marker = new google.maps.Marker({
    //         position: { lat: -21.2153, lng: -47.7712 },
    //         map,
    //         title: 'Ameaça',
    //         animation: google.maps.Animation.DROP,
    //         icon: icone_ameaca
    //     });
    //     map.setCenter(marker.getPosition());
    //     marker.addListener("click", () => {
    //         infowindow.open(map, marker);
    //     });
    //     setTimeout(function(){
    //         map.setZoom(8);
    //         infowindow.open(map, marker);
    //     }, 500);
    //     setTimeout(function(){
    //         infowindow.close(map, marker);
    //     }, 5000);
    // });

    function buscaHerois() {
        $.ajax({
            url: '<?= ENDERECO ?>/ajax/herois',
            success: function(dados){
                dados.forEach(function(heroi) {
                    var marker = new google.maps.Marker({
                        position: { lat: parseFloat(heroi.latitude), lng: parseFloat(heroi.longitude) },
                        map,
                        title: 'Herói',
                        icon: icone_heroi
                    });
                    informacoes = '<div id="content" style="color: #000">' +
                        '<h5>' + heroi.nome + '</h5>' +
                        '<div>' +
                            'Classe: ' + heroi.ranking.rank +
                        '</div>' +
                    '</div>';
                    var infowindow = new google.maps.InfoWindow({
                        content: informacoes,
                    });
                    marker.addListener("click", () => {
                        infowindow.open(map, marker);
                    });
                    herois_markers.push(marker);
                });
            },
            error: function(dados){
                alert('Erro ao buscar os heróis')
            },
            dataType: 'json'
        });
    }

    function buscaAmeacas() {
        $.ajax({
            url: '<?= ENDERECO ?>/ajax/ameacas',
            success: function(dados){
                dados.forEach(function(ameaca) {
                    var marker = new google.maps.Marker({
                        position: { lat: parseFloat(ameaca.latitude), lng: parseFloat(ameaca.longitude) },
                        map,
                        title: 'Ameaça',
                        icon: icone_ameaca
                    });
                    informacoes = '<div id="content" style="color: #000">' +
                        '<h5>' + ameaca.nome + '</h5>' +
                        '<div>' +
                            'Nível da ameaça: ' + ameaca.ranking.ameaca + '<br>' +
                            'Status: Ativo' +
                        '</div>' +
                    '</div>';
                    var infowindow = new google.maps.InfoWindow({
                        content: informacoes,
                    });
                    marker.addListener("click", () => {
                        infowindow.open(map, marker);
                    });
                    ameacas_markers.push(marker);
                });
            },
            error: function(dados){
                alert('Erro ao buscar os ameaças')
            },
            dataType: 'json'
        });
    }

    function buscaBatalhas() {
        $.ajax({
            url: '<?= ENDERECO ?>/ajax/batalhas',
            success: function(dados){
                dados.forEach(function(batalha) {
                    var marker = new google.maps.Marker({
                        position: { lat: parseFloat(batalha.ameaca.latitude), lng: parseFloat(batalha.ameaca.longitude) },
                        map,
                        title: 'Batalha',
                        icon: icone_batalha
                    });
                    informacoes = '<div id="content" style="color: #000">' +
                        '<h5>Batalha</h5>' +
                        '<div class="text-center">' +
                            batalha.herois_nome +
                            '<div class="p-2">VS<div><br>' +
                            batalha.ameaca.nome +
                        '</div>' +
                    '</div>';
                    var infowindow = new google.maps.InfoWindow({
                        content: informacoes,
                    });
                    marker.addListener("click", () => {
                        infowindow.open(map, marker);
                    });
                    batalhas_markers.push(marker);
                });
            },
            error: function(dados){
                alert('Erro ao buscar os ameaças')
            },
            dataType: 'json'
        });
    }

    function removeMarkers() {
        herois_markers.forEach(function(marker) {
            marker.setMap(null);
        });
        ameacas_markers.forEach(function(marker) {
            marker.setMap(null);
        });
        batalhas_markers.forEach(function(marker) {
            marker.setMap(null);
        });
        herois_markers = [];
        ameacas_markers = [];
        batalhas_markers = [];
    }
</script>
