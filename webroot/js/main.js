$(document).ready(function(){
    $('.latitude, .longitude').mask('A99Z.99999999', {
        translation: {
            'A': {
                pattern: /[-]/,
                optional: true
            },
            'Z': {
                pattern: /[0-9]/,
                optional: true
            }
        }
    });
});
