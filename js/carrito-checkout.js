function checkout() {
    const cartItems = document.getElementById('cart-items');
    const productList = [];
  
    // Recorre cada elemento de producto en el carrito
    cartItems.querySelectorAll('li.product-item').forEach(item => {
      const productName = item.dataset.product;
      const priceElement = item.querySelector('.precio');
      const productPrice = parseFloat(priceElement.textContent);
      const countElement = item.querySelector('.product-count');
      const productCount = parseInt(countElement.textContent.slice(1));
  
      // Crea un objeto con la información del producto
      const product = {
        name: productName,
        price: productPrice,
        count: productCount
      };
  
      // Agrega el producto a la lista de productos
      productList.push(product);
    });
  
    // Crea la URL dinámica con los detalles de los productos
    const checkoutUrl = createCheckoutUrl(productList);
  


    // Redirige al usuario a la página de checkout
    window.location.href = checkoutUrl;
  }
  
  function createCheckoutUrl(products) {
    // Crea una cadena de consulta con los detalles de los productos
    const queryString = products.map((product, index) => {
      const paramIndex = index + 1;
      return `name${paramIndex}=${encodeURIComponent(product.name)}&price${paramIndex}=${encodeURIComponent(product.price)}&count${paramIndex}=${encodeURIComponent(product.count)}`;
    }).join('&');
  
    // Crea la URL de la página de checkout con la cadena de consulta
    const checkoutUrl = 'carrito-checkout' + '?' + queryString;
  
    return checkoutUrl;
  }