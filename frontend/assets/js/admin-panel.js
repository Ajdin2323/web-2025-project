function loadUsers() {
  const jwt = localStorage.getItem("token");
  const user = decodeJWT(jwt);

  if (!jwt || !user) {
    alert("User not authenticated.");
    return;
  }

  $.ajax({
    url: `/web-2025-project/backend/users/100/1`,
    method: "GET",
    headers: {
      Authentication: jwt,
    },
    success: function (response) {
      const users = response.users;
      const table = $("#usersTable");

      if ($.fn.DataTable.isDataTable("#usersTable")) {
        table.DataTable().clear().destroy();
      }

      const tableBody = table.find("tbody");
      tableBody.empty();

      users.forEach((user) => {
        const row = `
          <tr>
            <td>
              <img
                src="assets/img/profileM.jpg"
                alt="User"
                width="50"
                height="50"
                class="rounded-circle"
              />
            </td>
            <td>${user.first_name} ${user.last_name}</td>
            <td>${user.email}</td>
            <td>${capitalize(user.role)}</td>
          </tr>
        `;
        tableBody.append(row);
      });

      table.DataTable();
    },
    error: function () {
      alert("Failed to load users.");
    },
  });
}

function loadProducts() {
  const jwt = localStorage.getItem("token");
  const user = decodeJWT(jwt);

  if (!jwt || !user) {
    alert("User not authenticated.");
    return;
  }

  $.ajax({
    url: `/web-2025-project/backend/products/100/1`,
    method: "GET",
    headers: {
      Authentication: jwt,
    },
    success: function (response) {
      const products = response.products;
      const table = $("#productsTable");

      if ($.fn.DataTable.isDataTable("#productsTable")) {
        table.DataTable().clear().destroy();
      }

      const tableBody = table.find("tbody");
      tableBody.empty();

      products.forEach((product) => {
        const row = `
          <tr>
            <td>
              <img
                src="${product.image}"
                alt="${product.name}"
                width="100"
                height="100"
                class="object-fit-cover"
              />
            </td>
            <td>${product.name}</td>
            <td>${product.price} BAM</td>
          </tr>
        `;
        tableBody.append(row);
      });

      table.DataTable();
    },
    error: function () {
      alert("Failed to load products.");
    },
  });
}

function capitalize(str) {
  return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
}

$(document).ready(function () {
  $("#pills-profile-tab").on("shown.bs.tab", function () {
    loadUsers();
  });

  $("#pills-home-tab").on("shown.bs.tab", function () {
    loadProducts();
  });

  if ($("#pills-profile").hasClass("active")) {
    loadUsers();
  }
  if ($("#pills-home").hasClass("active")) {
    loadProducts();
  }
});
