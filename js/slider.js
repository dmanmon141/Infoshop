$(document).ready(function(){
    $('.slider').slick({
      autoplay: true,
      autoplaySpeed: 3000,
      arrows: true,
      slidesToShow: 5, // Mostrar 3 slides a la vez
      draggable: false,
      responsive: [
        {
          breakpoint: 1368,
          settings: {
            slidesToShow: 2, // Mostrar 2 slides a la vez en pantallas de hasta 768px de ancho
          }
        },
        {
          breakpoint: 868,
          settings: {
            slidesToShow: 1, // Mostrar 1 slide a la vez en pantallas de hasta 480px de ancho
          }
        }
      ]
    });
  });