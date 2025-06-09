function mergeCartItems(cartItems) {
  const merged = {};

  cartItems.forEach(item => {
    if (merged[item.id]) {
      merged[item.id].quantity += item.quantity;
    } else {
      merged[item.id] = { ...item };
    }
  });

  return Object.values(merged);
}

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
      cartItems = mergeCartItems(cartItems);

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
      quantity: quantity,
    }),
    success: function () {
      alert("Product added to cart.");
    },
    error: function () {
      alert("Failed to add product to cart.");
    },
  });
}

$("#checkout-btn").on("click", function () {
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
      cartItems = mergeCartItems(cartItems);

      const listContainer = $("#checkout-items");
      const grandTotalContainer = $("#checkout-grand-total");
      listContainer.empty();

      let grandTotal = 0;

      cartItems.forEach((item) => {
        const itemTotal = item.price * item.quantity;
        grandTotal += itemTotal;

        const itemRow = `
          <div class="mb-3 border-bottom pb-2">
            <h6 class="mb-1">${item.name}</h6>
            <div class="small text-muted">Price: ${item.price.toFixed(2)} KM</div>
            <div class="small text-muted">Quantity: ${item.quantity}</div>
            <div class="fw-bold text-dark">Total: ${itemTotal.toFixed(2)} KM</div>
          </div>
        `;
        listContainer.append(itemRow);
      });

      grandTotalContainer.text(`${grandTotal.toFixed(2)} KM`);
    },
    error: function () {
      alert("Failed to load checkout summary.");
    },
  });
});

function showReceipt(paymentId, userId) {
  const jwt = localStorage.getItem("token");

  $.ajax({
    url: `/web-2025-project/backend/bill/${paymentId}/${userId}`,
    method: "GET",
    headers: {
      Authentication: jwt,
    },
    success: function (bill) {
      const offcanvasBody = $("#checkoutSidebar .offcanvas-body");
      offcanvasBody.empty();

      let itemsHtml = bill.items.map(item => `
        <div class="mb-3 border-bottom pb-2">
          <h6 class="mb-1">${item.name}</h6>
          <div class="small text-muted">Unit Price: ${item.unit_price.toFixed(2)} KM</div>
          <div class="small text-muted">Quantity: ${item.quantity}</div>
          <div class="fw-bold text-dark">Total: ${item.total_price.toFixed(2)} KM</div>
        </div>
      `).join("");

      const receiptHtml = `
        <h5 class="mb-3">Receipt</h5>
        <div class="mb-3"><strong>Date:</strong> ${bill.created_at}</div>
        <div>${itemsHtml}</div>
        <div class="border-top pt-3 fw-bold">Total Paid: ${bill.full_total_price.toFixed(2)} KM</div>
        <button id="close-receipt-btn" class="btn btn-primary mt-4 w-100">Close</button>
      `;

      offcanvasBody.append(receiptHtml);

      $("#close-receipt-btn").on("click", function () {
        const offcanvasElement = document.getElementById("checkoutSidebar");
        const bsOffcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement);
        if (bsOffcanvas) {
          bsOffcanvas.hide();
        }
        loadCart();
        resetCheckoutSidebar();
      });
    },
    error: function () {
      alert("Failed to load receipt.");
    },
  });
}

function resetCheckoutSidebar() {
  const offcanvasBody = $("#checkoutSidebar .offcanvas-body");
  offcanvasBody.empty();

  offcanvasBody.append(`
    <div id="checkout-items" class="mb-3"></div>
    <div class="mt-auto border-top pt-3">
      <h5>Total: <span id="checkout-grand-total">0.00 KM</span></h5>
      <a href="#" class="btn btn-success w-100 mt-3" id="confirm-payment-btn">Confirm Purchase</a>
    </div>
  `);

  $("#confirm-payment-btn").off("click").on("click", function (e) {
    e.preventDefault();
    confirmPayment();
  });
}

function confirmPayment() {
  const jwt = localStorage.getItem("token");
  const user = decodeJWT(jwt);

  if (!jwt || !user) {
    alert("User not authenticated.");
    return;
  }

  $.ajax({
    url: `/web-2025-project/backend/checkout/${user.id}`,
    method: "POST",
    headers: {
      Authentication: jwt,
    },
    success: function (response) {
      localStorage.setItem("lastPaymentId", response.payment_id);

      alert(`Payment successful! Payment ID: ${response.payment_id}`);

      showReceipt(response.payment_id, user.id);

      loadCart();
      loadPurchaseHistory(user.id, jwt);

      $("#checkout-items").empty();
      $("#checkout-grand-total").text("0.00 KM");
    },
    error: function () {
      alert("Failed to process payment.");
    },
  });
}

$("#confirm-payment-btn").off("click").on("click", function (e) {
  e.preventDefault();
  confirmPayment();
});
