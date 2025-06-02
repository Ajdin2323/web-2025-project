function loadProductDetails() {
  const productId = localStorage.getItem("selectedProductId");
  if (!productId) {
    $(".product-details-container").html("<p>No product selected.</p>");
    return;
  }

  $(".product-details-container").html("<p>Loading...</p>");

  $.ajax({
    url: `/web-2025-project/backend/product/${productId}`,
    method: "GET",
    success: function (response) {
      if (!response || !response.length) {
        $(".product-details-container").html("<p>Product not found.</p>");
        return;
      }

      const product = response[0];
      const html = `
        <h1 class="mb-4">${product.name}</h1>
        <div class="row">
          <div class="col-md-4 mb-4">
            <img
              src="${product.image}"
              alt="${product.name}"
              class="img-fluid rounded mb-3 product-image"
              id="mainImage"
            style="max-height: 500px; object-fit: cover;"
            />
          </div>
          <div class="col-md-3">
            <div class="mb-4">
              <h5>Color: ${product.color}</h5>
              <h5>Size: ${product.size}</h5>
              <h5>Material: ${product.material}</h5>
            </div>
            <div class="mb-4">
              <label for="quantity" class="form-label">Quantity:</label>
              <input
                type="number"
                class="form-control"
                id="quantity"
                value="1"
                min="1"
                style="width: 80px"
              />
            </div>
            <div class="mb-3">
              <span class="h4 text-secondary">${product.price}</span>
              <span class="h4 text-secondary">BAM</span>
            </div>
            <div class="d-flex flex-column">
              <button class="btn btn-primary mb-3">Add to cart</button>
              <button class="btn btn-warning mb-3">Add to favourites</button>
            </div>
          </div>
          <div class="col-md-1"></div>
        </div>
      `;

      $(".product-details-container").html(html);
    },
    error: function () {
      $(".product-details-container").html("<p>Error loading product.</p>");
    },
  });
}
