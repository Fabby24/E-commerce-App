// app.js

// Fetch products from the server on page load
document.addEventListener('DOMContentLoaded', () => {
    fetch('api.php?action=getProducts')
      .then(response => response.json())
      .then(products => {
        const container = document.getElementById('products-container');
        container.innerHTML = ''; // Clear previous content
        
        products.forEach(product => {
          container.innerHTML += `
            <div class="product" data-id="${product.id}" data-info='${JSON.stringify(product)}'>
              <img src="${product.image_url}" alt="${product.name}">
              <div>
                <h3>${product.name}</h3>
                <p>${product.description}</p>
                <p>$${parseFloat(product.price).toFixed(2)}</p>
                <button class="add-to-cart">Add to Cart</button>
              </div>
            </div>
          `;
        });
  
        // Add event listeners to "Add to Cart" buttons
        document.querySelectorAll('.add-to-cart').forEach(button => {
          button.addEventListener('click', addToCart);
        });
      });

    loadCart();
});

// Shopping cart logic
function addToCart(event) {
    const productElement = event.target.closest('.product');
    const productId = productElement.dataset.id;
  
    fetch('api.php?action=addToCart', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${productId}`
    }).then(response => response.json())
      .then(() => loadCart());
}

function loadCart() {
    fetch('api.php?action=getCart')
      .then(response => response.json())
      .then(cartItems => {
        const cartList = document.getElementById('cart-items');
        const cartTotal = document.getElementById('cart-total');
  
        cartList.innerHTML = '';
        let total = 0;
  
        cartItems.forEach(item => {
          const itemTotal = item.price * item.quantity;
          total += itemTotal;
  
          cartList.innerHTML += `
            <li>
              ${item.name} - $${parseFloat(item.price).toFixed(2)} x ${item.quantity}
              <button class="remove-item" data-id="${item.id}">Remove</button>
            </li>
          `;
        });
  
        cartTotal.textContent = total.toFixed(2);
  
        document.getElementById('checkout-btn').disabled = cartItems.length === 0;
  
        document.querySelectorAll('.remove-item').forEach(button => {
          button.addEventListener('click', removeFromCart);
        });
      });
}

function removeFromCart(event) {
    const productId = event.target.dataset.id;
    fetch('api.php?action=removeFromCart', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${productId}`
    }).then(response => response.json())
      .then(() => loadCart());
}

// Checkout function
document.getElementById('checkout-btn').addEventListener('click', () => {
    fetch('api.php?action=checkout')
      .then(response => response.json())
      .then(data => {
        alert(data.message);
        loadCart();
      });
});
