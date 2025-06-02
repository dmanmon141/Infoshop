function usardatos(tarjeta){
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'backend/buscar-datos.php?tarjeta=' + tarjeta, true);
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        var datos = JSON.parse(xhr.responseText);
        console.log
        // Llamar a una función para insertar los datos en los input correspondientes
        insertarDatos(datos);
      }
    };
    xhr.send();
}

function insertarDatos(datos) {
  if(document.getElementById('1')){
  document.getElementById("1").style.display = "none";
  }
  if(document.getElementById('2')){
    document.getElementById("2").style.display = "none";
    }
    if(document.getElementById('3')){
      document.getElementById("3").style.display = "none";
      }
    document.getElementById('tarjeta-input').value = datos.DATOSTAR;

    document.getElementById('nombre-input').value = datos.DATOSNOM;
    document.getElementById('apellidos-input').value = datos.DATOSAPE;
    document.getElementById('ciudad-input').value = datos.DATOSCIU;
    document.getElementById('direccion-input').value = datos.DATOSDIR;
    document.getElementById('codigopost-input').value = datos.DATOSCP;
    document.getElementById('pais-input').value = datos.DATOSPAIS;
    document.getElementById('telefono-input').value = datos.DATOSTEL;
}