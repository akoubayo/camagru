function forgot() {
    document.getElementById('formConnexion').style.display = 'none';
    document.getElementById('formInsc').style.display = 'none';
    document.getElementById('formForgot').style.display = 'block';
};
function connexion() {
    document.getElementById('formConnexion').style.display = 'block';
    document.getElementById('formInsc').style.display = 'none';
    document.getElementById('formForgot').style.display = 'none';
};
function inscription() {
    document.getElementById('formConnexion').style.display = 'none';
    document.getElementById('formInsc').style.display = 'block';
    document.getElementById('formForgot').style.display = 'none';
};

window.onload = function(){
}

