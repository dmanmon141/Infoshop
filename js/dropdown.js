function mostrarMenu() {
    var dropdown = document.getElementById("myDropdown");
    var flecha = document.getElementById("flecha");
  
    dropdown.classList.toggle("show");
    flecha.classList.toggle("rotar-180");
  
    if (dropdown.classList.contains('show')) {
      flecha.classList.remove('rotar-0');
    } else {
      flecha.classList.add('rotar-0');
     }
    }
  
  
  
  window.addEventListener("DOMContentLoaded", () => { 

window.addEventListener("click", function(event) {
      var dropdown = document.getElementById("myDropdown");
      var flecha = document.getElementById("flecha");
  
      if (dropdown.classList.contains('show') && !event.target.closest('.cuenta')) {
        dropdown.classList.remove('show');
        flecha.classList.remove('rotar-180');
        flecha.classList.add('rotar-0');
      }
    });
  
    document.getElementById("menuButton").addEventListener("click", function(event) {
      event.stopPropagation();
    });

  })
  
  
  
  
    function cerrarSesion() {
        window.location.href = "logout";
      };
      //xhr.send();

  