<div class="d-flex p-2 align-items-center">
    <div class="p-2">
        <h4 class="m-0">Painel de controle</h4>
    </div>
</div>
<div id="map" style="width:100%;height:400px;"></div>
<hr>
<div class="row">
    <div class="col-m-4">
        <button class="btn btn-danger" id="criar">Criar Ameaça</button>
    </div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDezWJoTnJxJZX0d2E0wWYEdr3rjEFWuQ8&callback=intanciaMapa" async>
</script>
<script>
    const icone_ameaca = "<?= $this->Url->image('icone_ameaca'); ?>";
    const icone_heroi = "<?= $this->Url->image('icone_heroi'); ?>";

    let map;
    function intanciaMapa() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: -16.226514, lng: -50.097995 },
            zoom: 4,
        });
    }

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
            });
        },
        error: function(dados){
            alert('Erro ao buscar os heróis')
        },
        dataType: 'json'
    });

    $.ajax({
        url: '<?= ENDERECO ?>/ajax/ameacas',
        success: function(dados){
            console.log(dados);
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
            });
        },
        error: function(dados){
            alert('Erro ao buscar os ameaças')
        },
        dataType: 'json'
    });

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
</script>
