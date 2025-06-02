
window.onload = function() {
const currentUrl = window.location.href;

// Crea un objeto URLSearchParams con la cadena de consulta de la URL
const searchParams = new URLSearchParams(currentUrl);

// Crea un objeto vacío para almacenar los productos
const products = [];

// Itera sobre los parámetros de la URL
for (const param of searchParams) {
  const paramName = param[0];
  const paramValue = param[1];

  const index = parseInt(paramName.substring(paramName.length - 1));

    if (!isNaN(index)) {
      // Verificar si el producto ya existe en el array
      if (products[index]) {
        // Actualizar los detalles del producto existente
        products[index][paramName] = paramValue;
      } else {
        // Crear un nuevo objeto de producto con los detalles iniciales
        products[index] = {
          [paramName]: paramValue
        };
      }
    }
  }

const productsJSON = JSON.stringify(products);

// Enviar los productos al archivo PHP a través de una solicitud AJAX
$.ajax({
  url: 'backend/carrito-checkout-guardar.php',
  method: 'POST',
  data: { products: productsJSON },
  success: function(response) {
    console.log('Productos enviados correctamente.');
  },
  error: function() {
    console.error('Error al enviar los productos.');
  }
});

// Imprime los productos en la consola
console.log(products);
}