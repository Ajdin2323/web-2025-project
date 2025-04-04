$(document).ready(function () {
  var app = $.spapp({ pageNotFound: "error_404" }); // initialize

  // define routes
  app.route({
    view: "home",
  });
  app.route({ view: "category", load: "category.html" });
  app.route({ view: "cart", load: "cart.html" });
  app.route({ view: "about-us", load: "about-us.html" });
  app.route({ view: "login", load: "login.html" });
  app.route({ view: "register", load: "register.html" });
  app.route({ view: "dashboard", load: "dashboard.html" });
  app.route({ view: "product-details", load: "product-details.html" });
  app.route({ view: "search-results", load: "search-results.html" });
  app.route({ view: "profile", load: "profile.html" });
  app.route({ view: "all-products", load: "all-products.html" });
  // run app
  app.run();
});
