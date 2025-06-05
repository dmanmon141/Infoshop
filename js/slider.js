$(document).ready(function() {
  const $slider = $('.slider');

  $slider.on('init reInit afterChange', function(event, slick, currentSlide) {
    const current = currentSlide || 0;
    const slidesToShow = slick.options.slidesToShow;

    // Ocultar flecha izquierda si está en el primer slide
    if (current === 0) {
      $('.slick-prev').hide();
    } else {
      $('.slick-prev').show();
    }

    // Ocultar flecha derecha si está en el último slide visible
    if (current >= slick.slideCount - slidesToShow) {
      $('.slick-next').hide();
    } else {
      $('.slick-next').show();
    }
  });

  $slider.slick({
    arrows: true,
    infinite: false,
    draggable: false,
    slidesToShow: 5,
    prevArrow: '<button type="button" class="slick-prev custom-arrow"><i class="fa-solid fa-chevron-left"></i></button>',
    nextArrow: '<button type="button" class="slick-next custom-arrow"><i class="fa-solid fa-chevron-right"></i></button>',
    responsive: [
      {
        breakpoint: 1368,
        settings: {
          slidesToShow: 2,
        }
      },
      {
        breakpoint: 868,
        settings: {
          slidesToShow: 1,
        }
      }
    ]
  });
});


  function scrollToSection(id){
    const element = document.getElementById(id);
    if(element){
      element.scrollIntoView({ behavior: 'smooth' });
    }
  }