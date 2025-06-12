const cartMenu = document.getElementById("cart-menu");
const cartSidebar = document.getElementById("cart-sidebar");
const productCounts = new Map();

document.querySelectorAll('*').forEach(el => el.style.outline = '1px solid red');

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


    console.log(li);


    footer.classList.remove("hide");


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
  console.log('Recalculando total...');
  let totalPrice = 0;
  let totalCount = 0;
  // Calcular el precio total sumando los precios de todos los productos en el carrito
  const cartItems = document.getElementById('cart-items');
  if (cartItems) {

    cartItems.querySelectorAll('li').forEach(item => {
      const priceElement = item.querySelector('.precio');
      const countElement = item.querySelector('.product-count');
      const price = parseFloat(priceElement.textContent);
      const count = parseInt(countElement.textContent.slice(1));
      totalCount += count;
      totalPrice += price * count;
    });
    const productCountElement = document.getElementById('productCount');
    if (productCountElement) {
      productCountElement.textContent = totalCount;
    }
    // Mostrar el precio total en el elemento correspondiente
    const cartTotal = document.getElementById('cart-total');
    if (cartTotal) {
      cartTotal.textContent = 'TOTAL ' + totalPrice.toFixed(2) + '€';
    }
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
      const emptyMessage = document.getElementById('empty-message');
      const footer = document.getElementById("cart-sidebar-footer");
      if (response.trim() === '') {
        if (emptyMessage) emptyMessage.style.display = 'block';
        if (footer) footer.classList.add("hide");
        cartItems.innerHTML = '';
      } else {
        
        cartItems.innerHTML = response;

        const hasProducts = cartItems.querySelectorAll('li').length > 0;

        if(hasProducts){
          if(emptyMessage) emptyMessage.style.display = 'none';
          if(footer) footer.classList.remove("hide");
        }else{
          if(emptyMessage) emptyMessage.style.display = 'block';
          if (footer) footer.classList.add("hide");
        }

        productCounts.clear(); 

        cartItems.querySelectorAll('li').forEach(item => {
          const productName = item.dataset.product;
          const countElement = item.querySelector('.product-count');
          if (countElement) {
            const count = parseInt(countElement.textContent.slice(1)); 
            productCounts.set(productName, count); // Actualiza el Map
          }
        });

  



        console.log('Contenido del carrito cargado:', cartItems.innerHTML);

        updateTotalPrice();
      }
    },
    error: function (xhr, status, error) {
      console.error('Error al obtener el carrito de la sesión de PHP:', error);
    }
  });
}

function deleteProduct(item) {
  const listItem = item.closest('li');
  const productName = listItem.dataset.product;
  const countElement = listItem.querySelector('.product-count');
  let count = productCounts.get(productName);

  if (count > 1) {
    count--;
    productCounts.set(productName, count);
    countElement.textContent = 'x' + count;
  } else {
    productCounts.delete(productName);
    listItem.remove();
    const cartItems = document.getElementById('cart-items');
    if (cartItems.children.length === 0) {
      const emptyMessage = document.getElementById('empty-message');
      if (emptyMessage) emptyMessage.style.display = 'block';

      const footer = document.getElementById('cart-sidebar-footer');
      if (footer) footer.classList.add('hide');
    }
  }

  updateTotalPrice();
  saveCartToSession();
  event.stopPropagation();
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
  footer.classList.add("hide");

  updateTotalPrice();
  saveCartToSession();
  alert("Se ha vaciado el carrito!");
}

function toggleCartSidebar() {
  const cartSidebar = document.getElementById('cart-sidebar');
  if (overlay.style.display === "block") {
    overlay.style.display = "none";
    document.body.style.overflow = ""
  } else {
    overlay.style.display = "block";
    document.body.style.overflow ="hidden"
  }
  cartSidebar.classList.toggle('show');

}

function openCartSidebar(event) {
  const cartSidebar = document.getElementById('cart-sidebar');
  overlay.style.display = "block";
  document.body.style.overflow = "hidden"
  if (!cartSidebar.classList.contains("show")) {
    cartSidebar.classList.toggle("show");
  }
}


function closeCartSidebar(event) {
  overlay.style.display = "none";
  document.body.style.overflow = ""
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
  const cartItems = document.getElementById('cart-items');
  cartItems.addEventListener('click', function (event) {
    if (event.target.classList.contains('eliminar-btn')) {
      const listItem = event.target.closest('li');
      const productName = listItem.dataset.product;
      const countElement = listItem.querySelector('.product-count');
      let count = productCounts.get(productName);

      if (count > 1) {
        count--;
        productCounts.set(productName, count);
        countElement.textContent = 'x' + count;
      } else {
        productCounts.delete(productName);
        listItem.remove();
      }

      // Si ya no hay productos, muestra mensaje vacío y oculta el footer
      if (cartItems.children.length === 0) {
        const emptyMessage = document.getElementById('empty-message');
        if (emptyMessage) emptyMessage.style.display = 'block';

        const footer = document.getElementById("cart-sidebar-footer");
        if (footer) footer.classList.add('hide');
      }

      updateTotalPrice();
      saveCartToSession();

      event.stopPropagation();
    }
  });
});