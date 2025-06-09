$(document).ready(function () {
  var app = $.spapp({ pageNotFound: "error_404" }); // initialize

  // define routes
  app.route({
    view: "category",
    load: "category.html",
    onReady: function () {
      const category = localStorage.getItem("selectedCategory");
      if (category) {
        loadCategoryProducts(category);
        localStorage.removeItem("selectedCategory");
      }
    }
  });

  app.route({
    view: "cart",
    load: "cart.html",
    onReady: function () {
      if (typeof loadCart === "function") {
        loadCart();
      }
    }
  });

  app.route({ view: "about-us", load: "about-us.html" });
  app.route({ view: "login", load: "login.html" });
  app.route({ view: "register", load: "register.html" });
  app.route({ view: "dashboard", load: "dashboard.html" });

  app.route({
    view: "product-details",
    load: "product-details.html",
    onCreate: function () {},
    onReady: function () {
      if (typeof loadProductDetails === "function") {
        loadProductDetails();
      }
    },
  });

  app.route({
    view: "search-results",
    load: "search-results.html",
    onReady: function () {
      const keyword = localStorage.getItem("searchKeyword");
      if (keyword) {
        loadSearchResults(keyword);
        localStorage.removeItem("searchKeyword");
      }
    },
  });

  app.route({ view: "profile", load: "profile.html" });
  app.route({ view: "all-products", load: "all-products.html" });

  // run app
  app.run();
});
