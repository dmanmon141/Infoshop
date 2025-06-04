$(document).ready(function(){
    $('.slider').slick({
      autoplay: true,
      autoplaySpeed: 3000,
      arrows: true,
      prevArrow: '<button type="button" class="slick-prev custom-arrow"><i class="fa-solid fa-chevron-left"></i></button>',
      nextArrow: '<button type="button" class="slick-next custom-arrow"><i class="fa-solid fa-chevron-right"></i></button>',
      slidesToShow: 5, // Mostrar 5 slides a la vez
      draggable: false,
      responsive: [
        {
          breakpoint: 1368,
          settings: {
            slidesToShow: 2, // Mostrar 2 slides a la vez en pantallas de hasta 868px de ancho
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