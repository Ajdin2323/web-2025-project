function loadSearchResults(keyword) {
  $(".search-keyword-heading").text(`Search results for "${keyword}"`);
  const container = $(".search-results-cards");
  container.empty();

  Pagination.init({
    endpoint: `/web-2025-project/backend/search/${encodeURIComponent(keyword)}`,
    containerSelector: ".search-results-cards",
    renderCallback: function (products) {
      if (products.length === 0) {
        container.append(`<div class="col"><p>No products found.</p></div>`);
        return;
      }

      products.forEach(function (product) {
        const card = `
          <div class="col">
            <div class="card h-100" data-id="${product.id}">
              <a href="#product-details">
                <img src="${product.image}" class="card-img-top" alt="${product.name}" />
              </a>
              <div class="card-body">
                <h5 class="card-title">${product.name}</h5>
                <p class="card-text">
                  Color: ${product.color}<br />
                  Size: ${product.size}<br />
                  Material: ${product.material}<br />
                  Price: ${product.price} BAM
                </p>
                <div class="d-flex flex-column justify-content-between gap-3">
                  <a href="#" class="btn btn-primary add-to-cart-btn">Add to cart</a>
                  <a href="#" class="btn btn-warning add-to-fav-btn">Add to favourites</a>
                </div>
              </div>
            </div>
          </div>
        `;
        container.append(card);
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

$(document).ready(function () {
  const $searchInput = $("#search-input");

  $("#search-form").on("submit", function (e) {
    e.preventDefault();
    const keyword = $searchInput.val().trim();
    if (keyword !== "") {
      localStorage.setItem("searchKeyword", keyword);
      location.href = `#search-results`;
      loadSearchResults(keyword);
    }
  });

  function handleHashChange() {
    if (location.hash !== "#search-results") {
      $searchInput.val("");
    }
  }

  handleHashChange();

  $(window).on("hashchange", handleHashChange);
});
