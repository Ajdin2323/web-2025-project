function loadCategoryProducts(category) {
  $(".category-title").text(`Category: ${category}`);
  const rowContainer = $(".products-by-category-cards");
  rowContainer.empty();

  Pagination.init({
    endpoint: `/web-2025-project/backend/products-by-category/${encodeURIComponent(
      category.toLowerCase()
    )}`,
    containerSelector: ".products-by-category-cards",
    renderCallback: function (products) {
      if (products.length === 0) {
        rowContainer.append(
          `<div class="col"><p>No products found in this category.</p></div>`
        );
        return;
      }

      products.forEach(function (product) {
        const categoryCard = `
          <div class="col">
            <div class="card h-100" data-id="${product.product_id}">
              <a href="#product-details">
                <img src="${product.image}" class="card-img-top" alt="${product.product_name}" />
              </a>
              <div class="card-body">
                <h5 class="card-title">${product.product_name}</h5>
                <p>Color: ${product.color}</p>
                <p>Size: ${product.size}</p>
                <p>Material: ${product.material}</p>
                <p class="text-dark">${product.price} BAM</p>
                <div class="d-flex flex-column justify-content-between gap-3">
                  <a href="#" class="btn btn-primary add-to-cart-btn">Add to cart</a>
                  <a href="#" class="btn btn-warning add-to-fav-btn">Add to favourites</a>
                </div>
              </div>
            </div>
          </div>
        `;
        rowContainer.append(categoryCard);
      });

      $(".card a").on("click", function () {
        const productId = $(this).closest(".card").data("id");
        localStorage.setItem("selectedProductId", productId);
      });

      $(".add-to-cart-btn").on("click", function (e) {
        e.preventDefault();
        const productId = $(this).closest(".card").data("id");
        addToCart(productId);
      });

      $(".add-to-fav-btn").on("click", function (e) {
        e.preventDefault();
        const productId = $(this).closest(".card").data("id");
        addToFavourites(productId);
      });
    },
  });
}

$(document).on("click", ".category-link", function () {
  const category = $(this).data("category");
  localStorage.setItem("selectedCategory", category);
  loadCategoryProducts(category);
});
