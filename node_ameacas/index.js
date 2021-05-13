const io = require("socket.io-client");

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
    var XMLHttpRequest = require("xmlhttprequest").XMLHttpRequest;
    var xhr = new XMLHttpRequest();
    xhr.open("POST", 'https://localhost/iheros/ajax/ameacas/novaAmeaca', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.send(JSON.stringify({
        nome: ameaca.monsterName,
        latitude: ameaca.location[0].lat,
        longitude: ameaca.location[0].lng,
        rank: ameaca.dangerLevel
    }));
});

socket.on("connect_error", (err) => {
    console.log(`Erro - ${err}`);
});
