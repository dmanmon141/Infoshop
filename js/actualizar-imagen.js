document.addEventListener('DOMContentLoaded', function() {

const inputImagen = document.getElementById('inputFile');
const imagenPerfil = document.getElementById('imagen');



inputImagen.addEventListener('input', function() {
  const file = inputImagen.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
        imagenPerfil.src = e.target.result;
    }
    reader.readAsDataURL(file);
  }
});
});

function abrirInputFile(){
    const inputImagen = document.getElementById('inputFile');

    inputImagen.click();
    var boton = document.getElementById('aplicarimagen');
        boton.style.display = "flex";
 
}