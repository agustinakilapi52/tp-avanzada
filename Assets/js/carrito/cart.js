// js/cart.js

$(document).ready(function() {
  // Manejar clic en botón "Agregar al Carrito"
  $('.add-to-cart').click(function() {
    var productId = $(this).data('id');
    
    // Obtener el carrito actual del localStorage
    var cart = JSON.parse(localStorage.getItem('cart')) || [];

    // Verificar si el producto ya está en el carrito
    var product = cart.find(item => item.id == productId);

    if (product) {
      // Si el producto ya está en el carrito, incrementar la cantidad
      product.quantity += 1;
    } else {
      // Si no está en el carrito, agregarlo
      cart.push({ id: productId, quantity: 1 });
    }

    // Guardar el carrito actualizado en localStorage
    localStorage.setItem('cart', JSON.stringify(cart));

    alert('Producto agregado al carrito');
  });

  // Enviar carrito al servidor cuando se cargue la página del carrito
  if (window.location.pathname.includes('carrito.php')) {
    var cart = JSON.parse(localStorage.getItem('cart')) || [];
    $.ajax({
      type: 'POST',
      url: 'carrito.php',
      data: { cart: JSON.stringify(cart) },
      success: function(response) {
        $('body').html(response);
      }
    });
  }
});
