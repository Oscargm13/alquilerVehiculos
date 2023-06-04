window.addEventListener('load', eventos);
const $ = id => document.getElementById(id);

function eventos() {
    $("btn").addEventListener('submit', validar)
    function validar() {

        if($('id').value == ''||$('mail').value == ''||$('tlf').value == ''||$('password').value == ''||$('ciudad').value == ''||$('pass')) {
            $("error").innerHTML = "Hay campos obligatorios sin rellenar";
            return false;
        }else {
            $("error").innerHTML = "";
        }

        if($("pass")!=$("password")) {
            alert("Las contraseñas no coinciden");
            return false
        }
        
        return true;
    }
    
}