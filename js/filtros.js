window.addEventListener('DOMContentLoaded', function () {
  // Obtener parámetros de la URL
  var urlParams = new URLSearchParams(window.location.search);

  // Obtener valores de los parámetros
  var query = urlParams.get('query');
  var categoriasParam = urlParams.get('categorias');
  var marcasParam = urlParams.get('marcas');
  var precioParam = urlParams.get('precio');

  // Establecer valores de los filtros en la página
  if (query) {
    document.querySelector('.busqueda-texto').value = query;
  }

  if (categoriasParam) {
    var categoriasSeleccionadas = categoriasParam.split(',');
    categoriasSeleccionadas.forEach(function (categoria) {
      var checkbox = document.querySelector('input[name="filtrocategoria"][value="' + categoria + '"]');
      if (checkbox) {
        checkbox.checked = true;
      }
    });
  }

  if (marcasParam) {
    var marcasSeleccionadas = marcasParam.split(',');
    marcasSeleccionadas.forEach(function (marca) {
      var checkbox = document.querySelector('input[name="filtromarca"][value="' + marca + '"]');
      if (checkbox) {
        checkbox.checked = true;
      }
    });
  }

  if (precioParam) {
    var precioSeleccionado = precioParam;
    var radio = document.querySelector('input[name="filtroprecio"][value="' + precioSeleccionado + '"]');
    if (radio) {
      radio.checked = true;
    }
  }



});

function aplicarFiltro() {
  var query = document.querySelector('.busqueda-texto').value.trim();
  var checkboxesCategoria = document.getElementsByName('filtrocategoria');
  var checkboxesMarca = document.getElementsByName('filtromarca');
  var checkboxesPrecio = document.getElementsByName('filtroprecio');
  var categoriasSeleccionadas = [];
  var marcasSeleccionadas = [];
  var precioSeleccionado = '';

  

  for (var i = 0; i < checkboxesCategoria.length; i++) {
    if (checkboxesCategoria[i].checked) {
      categoriasSeleccionadas.push(checkboxesCategoria[i].value);
    }
  }

  for (var i = 0; i < checkboxesMarca.length; i++) {
    if (checkboxesMarca[i].checked) {
      marcasSeleccionadas.push(checkboxesMarca[i].value);
    }
  }

  for (var i = 0; i < checkboxesPrecio.length; i++) {
    if (checkboxesPrecio[i].checked) {
      precioSeleccionado = checkboxesPrecio[i].value;
      break;
    }else{
    precioSeleccionado = '';
    }
  }

  var parametros = [];

  if (query) {
    parametros.push('query=' + encodeURIComponent(query));
  }

  if (categoriasSeleccionadas.length > 0) {
    parametros.push('categorias=' + categoriasSeleccionadas.join(','));
  }

  if (marcasSeleccionadas.length > 0) {
    parametros.push('marcas=' + marcasSeleccionadas.join(','));
  }

  if (precioSeleccionado !== '') {
    parametros.push('precio=' + precioSeleccionado);
  }

  var url = 'buscar';

  if (parametros.length > 0) {
    url += '?' + parametros.join('&');
  }

  window.location.href = url;
}
