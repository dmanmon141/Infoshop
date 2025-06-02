function permitirEditar(dato){

var input = document.getElementById(dato);
var boton = document.getElementById("aplicar");
var mensajeElemento = document.getElementById("mensaje");
if(input.readOnly === true){
    if(dato === "contraseña"){
        input.value = "";
    }
input.classList.remove("disabled");
input.readOnly = false;
boton.style.display = "block";
}else{
    input.classList.add("disabled");
    mensajeElemento.style.display = "none";
    input.readOnly = true;
    boton.style.display = "none";
    if(dato === "contraseña"){
        input.value = "*******************";
    }
}
}

function mostrarPopup(event){

    event.preventDefault();
 var popup = document.getElementById("popup");
   popup.style.display = "flex";
}

function cerrarPopup(){
    var popup = document.getElementById("popup");
    popup.style.display = "none";
}

function cambiarDatos(){
      
    // Obtener los valores del formulario
    var nombre = document.getElementById('nombre').value;
    var apellidos = document.getElementById('apellidos').value;
    var correo = document.getElementById('correo').value;
    var contraseña = document.getElementById('contraseña').value;
    var mensajeElemento = document.getElementById("mensaje");

    if (correo.trim() === "" || contraseña.trim() === "" || nombre.trim() === "" || apellidos.trim() === ""){ 
    mensajeElemento.style.display = "block";
    mensajeElemento.innerHTML = "No pueden haber campos vacíos.";
    mensajeElemento.style.color = "red";
    cerrarPopup();
    return;
    }
    
    function validarContraseña(contraseña) {
        // Comprobar si la contraseña tiene al menos 8 caracteres, una mayúscula, una minúscula y un símbolo
        var regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}$/;
        if (regex.test(contraseña)) {
            return true;
        }else {
          mensajeElemento.style.display = "block";
            mensajeElemento.innerHTML = "La contraseña debe de ser de 8 caracteres, contener mayúsculas y minúsculas, un símbolo (*, #, º) y un dígito (1, 4, 9).";
            mensajeElemento.style.color = "red";
            return false;
        }
      }
if(contraseña !== "*******************"){
      if (!validarContraseña(contraseña)){
        cerrarPopup();
        return;
      }
    }
      

    // Crear un objeto FormData y agregar los datos del formulario
    var formData = new FormData();
    formData.append('nombre', nombre);
    formData.append('apellidos', apellidos);
    formData.append('correo', correo);
    if(contraseña !== "*******************"){
    formData.append('contraseña', contraseña);
    }

    // Crear una instancia de XMLHttpRequest
    var xhr = new XMLHttpRequest();

    // Configurar la solicitud AJAX
    xhr.open('POST', 'editar-datos', true);

    // Enviar la solicitud AJAX con los datos del formulario
    xhr.send(formData);

    // Manejar la respuesta del servidor
    xhr.onreadystatechange = function() { 


      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          var respuesta = xhr.responseText;
          console.log(respuesta);
          if( respuesta === "success") {
            mensajeElemento.style.display = "none";
            window.location.reload(); 
          }else{
            console.log(respuesta);
            mensajeElemento.style.display = "block";
            mensajeElemento.innerHTML = "El correo introducido ya tiene una cuenta asociada";
            mensajeElemento.style.color = "red";
          }
        } else {
          // Hubo un error en la solicitud
          console.error('Error en la solicitud AJAX');
        }
      }
    };
 dejarEditar();
}

function  dejarEditar(){
    var inputs = document.getElementsByClassName("input");
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].getElementsByTagName("input")[0].readOnly = true;
      }
}