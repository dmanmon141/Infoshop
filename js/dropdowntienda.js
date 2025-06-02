function mostrarMenuTienda() {
    var dropdown = document.getElementById("myDropdownTienda");
    var rayas = document.getElementById("rayas");
    var overlay = document.getElementById("overlay");
  
    overlay.style.display = "block";

    dropdown.classList.toggle("show");
    rayas.src = "img/rayas.png";
  
    if (dropdown.classList.contains('show')) {
      rayas.src = "img/cross.png";
    } else {
      rayas.src ="img/rayas.png";
      overlay.style.display = "none";
      
     }
    }
  
  window.addEventListener("DOMContentLoaded", () => {

    window.addEventListener("click", function(event) {
      var dropdown = document.getElementById("myDropdownTienda");
      var rayas = document.getElementById("rayas");

  
      if (dropdown.classList.contains('show') && !event.target.closest('.dropbtn')) {
        dropdown.classList.remove('show');
        overlay.style.display = "none";
        rayas.src = "img/rayas.png";
      }
    });
    
    document.getElementById("menuButtonShop").addEventListener("click", function(event) {
      event.stopPropagation();
    });
  })


  