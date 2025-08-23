function loadUserProfile() {
  const token = localStorage.getItem("token");
  const user = decodeJWT(token);

  if (!token || !user) {
    alert("User not authenticated.");
    return;
  }

  $.ajax({
    url: `/web-2025-project/backend/user/${user.id}`,
    method: "GET",
    headers: {
      Authentication: token,
    },
    success: function (userData) {
      if (!userData || userData.length === 0) {
        alert("User data not found.");
        return;
      }

      const u = userData[0];

      $(".welcome-title").text(`Welcome, ${u.first_name} ${u.last_name}`);

      const profileTab = $("#pills-profile");
      profileTab.find("img").attr("src", "assets/img/profileM.jpg");
      profileTab.find("h5").eq(0).text(`${u.first_name} ${u.last_name}`);
      profileTab.find("h5").eq(1).text(u.email);
      profileTab.find("h5").eq(2).text(`Role: ${u.role}`);

      loadPurchaseHistory(user.id, token);
      loadFavourites(user.id, token); 
    },
    error: function () {
      alert("Failed to load user profile.");
    },
  });
}

function loadPurchaseHistory(userId, token) {
  $.ajax({
    url: `/web-2025-project/backend/purchase_history/${userId}`,
    method: "GET",
    headers: {
      Authentication: token,
    },
    success: function (purchaseData) {
      const container = $("#purchaseHistoryCards");
      const totalSpentElem = $(".total-spent");
      container.empty();

      if (!purchaseData || purchaseData.length === 0) {
        container.html('<p>No purchase history found.</p>');
        totalSpentElem.text("Total spent: 0 BAM");
        return;
      }

      let totalSpent = 0;
      purchaseData.forEach(purchase => {
        totalSpent += purchase.full_total_price;

        let itemsHtml = '<ul class="list-group">';
        purchase.items.forEach(item => {
          itemsHtml += `
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <span>${item.name} (x${item.quantity})</span>
              <span>${item.total_price} BAM</span>
            </li>
          `;
        });
        itemsHtml += '</ul>';

        const cardHtml = `
          <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
              <strong>Purchase Date:</strong> <span>${purchase.created_at}</span>
            </div>
            <div class="card-body">
              ${itemsHtml}
              <div class="mt-3 fw-bold text-end">Total: ${purchase.full_total_price} BAM</div>
            </div>
          </div>
        `;

        container.append(cardHtml);
      });

      totalSpentElem.text(`Total spent: ${totalSpent} BAM`);
    },
    error: function () {
      alert("Failed to load purchase history.");
    },
  });
}

function loadFavourites(userId, token) {
  $.ajax({
    url: `/web-2025-project/backend/favourites/${userId}`,
    method: "GET",
    headers: {
      Authentication: token,
    },
    success: function (favourites) {
      const table = $('#favouritesTable');

      if ($.fn.DataTable.isDataTable(table)) {
        table.DataTable().clear().destroy();
      }

      const tbody = table.find("tbody");
      tbody.empty();

      if (favourites && favourites.length > 0) {
        favourites.forEach(item => {
          const priceDisplay = item.sale_price && item.sale_price > 0 ? item.sale_price : item.price;
          const row = `
            <tr data-id="${item.id}">
              <td><img src="${item.image}" alt="${item.name}" width="100" height="100" class="object-fit-cover"></td>
              <td>${item.name}</td>
              <td>${priceDisplay} BAM</td>
              <td><button class="btn btn-danger btn-sm remove-favourite-btn" data-id="${item.id}">Remove</button></td>
            </tr>
          `;
          tbody.append(row);
        });
      }
      table.DataTable();

      $(".remove-favourite-btn").off("click").on("click", function () {
        const favId = $(this).data("id");
        removeFavourite(userId, favId, token);
      });
    },
    error: function () {
      alert("Failed to load favourites.");
    },
  });
}


function removeFavourite(userId, favId, token) {
  $.ajax({
    url: `/web-2025-project/backend/favourites/${userId}/${favId}`,
    method: "DELETE",
    headers: {
      Authentication: token,
    },
    success: function () {
      loadFavourites(userId, token);
    },
    error: function () {
      alert("Failed to remove favourite.");
    }
  });
}

$(document).ready(function () {
  loadUserProfile();

  $('#pills-profile-tab').on('shown.bs.tab', function () {
    if (!$.fn.DataTable.isDataTable('#favouritesTable')) {
      $('#favouritesTable').DataTable();
    }
  });
});

function addToFavourites(productId, quantity = 1) {
  const jwt = localStorage.getItem("token");
  const user = decodeJWT(jwt);

  if (!jwt || !user) {
    alert("User not authenticated.");
    return;
  }

  $.ajax({
    url: "/web-2025-project/backend/favourites",
    method: "POST",
    contentType: "application/json",
    headers: {
      Authentication: jwt,
    },
    data: JSON.stringify({
      user_id: user.id,
      product_id: productId
    }),
    success: function () {
      loadFavourites(user.id, jwt);
      alert("Product added to favourites.");
    },
    error: function () {
      alert("Failed to add product to favourites.");
    },
  });
}
