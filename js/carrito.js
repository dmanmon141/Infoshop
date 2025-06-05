const cartMenu = document.getElementById("cart-menu");
const cartSidebar = document.getElementById("cart-sidebar");
const productCounts = new Map();

function addToCart(productName, productImage, productPrice) {
  // Crear el elemento de la lista de productos del carrito
  const cartItems = document.getElementById('cart-items');


  const emptyMessage = document.getElementById('empty-message');
  if (emptyMessage) {
    emptyMessage.style.display = 'none';
  }

  if (productCounts.has(productName)) {
    const count = productCounts.get(productName) + 1;
    productCounts.set(productName, count);
    const duplicateItem = cartItems.querySelector(`li[data-product="${productName}"]`);
    const countElement = duplicateItem.querySelector('.product-count');
    countElement.textContent = 'x' + count;
  } else {

    const footer = document.getElementById('cart-sidebar-footer');
    const li = document.createElement('li');
    li.classList.add('product-item');
    li.dataset.product = productName;

    const imageElement = document.createElement('img');
    imageElement.src = productImage;
    li.appendChild(imageElement);
    const nameElement = document.createElement('span');
    nameElement.textContent = productName;
    nameElement.classList.add("productname");
    li.appendChild(nameElement);

    const countElement = document.createElement('span');
    countElement.textContent = 'x1';
    countElement.classList.add('product-count');
    li.appendChild(countElement);

    const priceElement = document.createElement('span');
    priceElement.textContent = productPrice;
    priceElement.classList.add("precio");
    li.appendChild(priceElement);






    const deleteButton = document.createElement('button');
    deleteButton.classList.add("eliminar-btn");


    li.appendChild(deleteButton);





    // Agregar el producto al carrito

    if (cartItems.innerHTML === "<p>No hay artículos en tu carrito</p>") {
      cartItems.innerHTML = "";
    }

    cartItems.addEventListener('click', function (event) {
      if (event.target.classList.contains('eliminar-btn')) {
        const listItem = event.target.closest('li');
        listItem.remove();
        updateTotalPrice();
        saveCartToSession();

        event.stopPropagation();
      }
    });

    console.log(li);


    footer.classList.toggle("hide");


    cartItems.appendChild(li);
    productCounts.set(productName, 1);
  }


  // Actualizar el precio total
  updateTotalPrice();

  // Guardar el carrito en variables de sesión utilizando AJAX
  saveCartToSession();



  openCartSidebar();

  event.stopPropagation();

}

// Función para actualizar el precio total del carrito
function updateTotalPrice() {
  let totalPrice = 0;

  // Calcular el precio total sumando los precios de todos los productos en el carrito
  const cartItems = document.getElementById('cart-items');
  if(cartItems){
    cartItems.querySelectorAll('li').forEach(item => {
    const priceElement = item.querySelector('.precio');
    const countElement = item.querySelector('.product-count');
    const price = parseFloat(priceElement.textContent);
    const count = parseInt(countElement.textContent.slice(1));
    totalPrice += price * count;
  });
  
  cartItems.querySelectorAll('li').forEach(item => {
    const priceElement = item.querySelector('.precio');
    const countElement = item.querySelector('.product-count');
    const price = parseFloat(priceElement.textContent);
    const count = parseInt(countElement.textContent.slice(1));
    totalPrice += price * count;
  });
  
  // Mostrar el precio total en el elemento correspondiente
  const cartTotal = document.getElementById('cart-total');
  cartTotal.textContent = 'TOTAL ' + totalPrice.toFixed(2) + '€';
}
}

// Función para guardar el carrito en variables de sesión utilizando AJAX
function saveCartToSession() {

  const cartContent = document.getElementById('cart-items').innerHTML;

  // Enviar los datos al servidor utilizando AJAX
  $.ajax({
    url: 'backend/guardar_carrito.php',
    type: 'POST',
    data: { cartContent: cartContent },
    success: function (response) {
      console.log('Carrito guardado en la sesión de PHP');
    },
    error: function (xhr, status, error) {
      console.error('Error al guardar el carrito en la sesión de PHP:', error);
    }
  });
}

function loadCartFromSession() {
  // Obtener el carrito desde las variables de sesión utilizando AJAX
  $.ajax({
    url: 'backend/obtener_carrito.php',
    type: 'GET',
    success: function (response) {
      // Actualizar el contenido del carrito con los productos guardados en la sesión
      const cartItems = document.getElementById('cart-items');
      if (response.trim() === '') {
        const emptyMessage = document.getElementById('empty-message');
        if (emptyMessage) emptyMessage.style.display = 'block';

        const footer = document.getElementById("cart-sidebar-footer");
        if (footer) footer.classList.toggle("hide");

      } else {
        const emptyMessage = document.getElementById('empty-message');
        // Actualizar el contenido del carrito con los productos guardados en la sesión
        if (emptyMessage) {
          document.getElementById('empty-message').style.display = 'none'
        };
        if (cartItems) {
          cartItems.innerHTML = response;
          if (cartItems.innerHTML === "<p>No hay artículos en tu carrito</p>") {
            const footer = document.getElementById("cart-sidebar-footer");
            footer.classList.toggle("hide");
          }
          const productCounts = {};
          cartItems.querySelectorAll('.productname').forEach(item => {
            const productName = item.textContent;
            if (productName in productCounts) {
              productCounts[productName]++;
              const countElement = item.nextElementSibling;
              countElement.textContent = 'x' + productCounts[productName];
            } else {
              productCounts[productName] = 1;
            }
          });

          console.log(response);

          cartItems.querySelectorAll('.eliminar-btn').forEach(button => {
            button.addEventListener('click', function () {
              const listItem = this.closest('li');
              listItem.remove();
              updateTotalPrice();
              saveCartToSession();
              event.stopPropagation();
            });
          });
        }


      }
      updateTotalPrice();
    },
    error: function (xhr, status, error) {
      console.error('Error al obtener el carrito de la sesión de PHP:', error);
    }
  });
}


function emptyCart() {
  productCounts.clear();

  const cartItems = document.getElementById('cart-items');
  cartItems.innerHTML = "";
  const emptyMessage = document.getElementById('empty-message');
  if (emptyMessage) {
    emptyMessage.style.display = 'block';
  }


  const footer = document.getElementById("cart-sidebar-footer");
  footer.classList.toggle("hide");

  updateTotalPrice();
  saveCartToSession();
  alert("Se ha vaciado el carrito!");
}

function toggleCartSidebar() {
  const cartSidebar = document.getElementById('cart-sidebar');
  if (overlay.style.display === "block") {
    overlay.style.display = "none";
  } else {
    overlay.style.display = "block";
  }
  cartSidebar.classList.toggle('show');

}

function openCartSidebar(event) {
  const cartSidebar = document.getElementById('cart-sidebar');
  overlay.style.display = "block";
  if (!cartSidebar.classList.contains("show")) {
    cartSidebar.classList.toggle("show");
  }
}


function closeCartSidebar(event) {
  overlay.style.display = "none";
  const cartSidebar = document.getElementById('cart-sidebar');
  if (!event.target.closest('.cart-sidebar')) {
    cartSidebar.classList.remove('show');
  }
}

window.addEventListener("click", function (event) {
  const cartSidebar = document.getElementById('cart-sidebar');

  if (cartSidebar.classList.contains('show') && !event.target.closest('.cart-menu')) {
    closeCartSidebar(event);
  }
});

document.addEventListener('DOMContentLoaded', function () {
  loadCartFromSession();
});