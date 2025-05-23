$(document).ready(function () {
  Pagination.init({
    endpoint: "/web-2025-project/backend/products", 
    containerSelector: ".all-products-cards",
    renderCallback: function (products) {
      products.forEach(function (product) {
        const card = `
          <div class="col">
            <div class="card h-100">
              <a href="#product-details">
                <img src="${product.image}" class="card-img-top" alt="${product.name}" />
              </a>
              <div class="card-body">
                <h5 class="card-title">${product.name}</h5>
                <p class="card-text">
                  <p>Color: ${product.color}</p>
                  <p>Size: ${product.size}</p>
                  <p>Material: ${product.material}</p>
                  <p class="text-dark">${product.price} BAM</p>
                </p>
                <div class="d-flex flex-column justify-content-between gap-3">
                  <a href="#" class="btn btn-primary">Add to cart</a>
                  <a href="#" class="btn btn-warning">Add to favourites</a>
                </div>
              </div>
            </div>
          </div>
        `;
        $(".all-products-cards").append(card);
      });
    }
  });
});
