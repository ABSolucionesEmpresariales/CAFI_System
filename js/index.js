function check(e) {
        tecla =  e.keyCode ;
        if (tecla == 8 || tecla == 3 || tecla == 32 ) {
            return true;
        }
        patron = /[A-Za-z0-9/@._-]/;
        tecla_final = String.fromCharCode(tecla);
        return patron.test(tecla_final);
}

function codigo(e){
        tecla =  e.keyCode ;
        if (tecla == 8 || tecla == 13 || tecla == 32) {
            return true;
        }
        patron = /[A-Za-z0-9@._-]/;
        tecla_final = String.fromCharCode(tecla);
        return patron.test(tecla_final);
}

function check2(e) {
        tecla =  e.keyCode ;
        if (tecla == 8 || tecla == 13 || tecla == 32) {
            return true;
        }
        patron = /[A-Za-z0-9/_-@.]/;
        tecla_final = String.fromCharCode(tecla);
        return patron.test(tecla_final);
}





