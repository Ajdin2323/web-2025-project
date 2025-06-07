function loadCart() {
  const jwt = localStorage.getItem("token");
  const user = decodeJWT(jwt);

  if (!jwt || !user) {
    alert("User not authenticated.");
    return;
  }

  $.ajax({
    url: `/web-2025-project/backend/cart/${user.id}`,
    method: "GET",
    headers: {
      Authentication: jwt,
    },
    success: function (cartItems) {
      const container = $(".cart-container .row");
      const totalContainer = $("#cart-total");
      container.empty();

      let fullTotal = 0;

      if (cartItems.length === 0) {
        container.append(`<div class="col"><p>Your cart is empty.</p></div>`);
        totalContainer.text("0.00 KM");
        return;
      }

      cartItems.forEach((item) => {
        const itemTotal = item.price * item.quantity;
        fullTotal += itemTotal;

        const card = `
          <div class="col">
            <div class="card h-100" data-id="${item.id}">
              <a href="#product-details">
                <img src="${item.image}" class="card-img-top" alt="${item.name}" />
              </a>
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <h5 class="card-title mb-0">${item.name}</h5>
                  <span class="badge bg-secondary">x${item.quantity}</span>
                </div>
                <p class="mb-1 text-muted">Price: ${item.price.toFixed(2)} KM</p>
                <p class="mb-3 fw-bold text-dark">Total: ${itemTotal.toFixed(2)} KM</p>
                <a href="#" class="btn btn-danger remove-cart-btn" data-product-id="${item.id}">Remove from cart</a>
              </div>
            </div>
          </div>
        `;
        container.append(card);
      });

      totalContainer.text(`${fullTotal.toFixed(2)} KM`);

      $(".card a").on("click", function () {
        const productId = $(this).closest(".card").data("id");
        localStorage.setItem("selectedProductId", productId);
      });

      $(".remove-cart-btn").on("click", function (e) {
        e.preventDefault();
        const productId = $(this).data("product-id");

        $.ajax({
          url: `/web-2025-project/backend/cart/${user.id}/${productId}`,
          method: "DELETE",
          headers: {
            Authentication: jwt,
          },
          success: function () {
            loadCart(); 
          },
          error: function () {
            alert("Failed to remove item from cart.");
          },
        });
      });
    },
    error: function () {
      alert("Failed to load cart.");
    },
  });
}

function addToCart(productId, quantity = 1) {
  const jwt = localStorage.getItem("token");
  const user = decodeJWT(jwt);

  if (!jwt || !user) {
    alert("User not authenticated.");
    return;
  }

  $.ajax({
    url: "/web-2025-project/backend/cart",
    method: "POST",
    contentType: "application/json",
    headers: {
      Authentication: jwt,
    },
    data: JSON.stringify({
      user_id: user.id,
      product_id: productId,
      quantity: quantity
    }),
    success: function () {
      alert("Product added to cart.");
    },
    error: function () {
      alert("Failed to add product to cart.");
    }
  });
}
