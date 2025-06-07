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

$(document).ready(function () {
  loadUserProfile();

  $('#pills-profile-tab').on('shown.bs.tab', function () {
    if (!$.fn.DataTable.isDataTable('#favouritesTable')) {
      $('#favouritesTable').DataTable();
    }
  });
});
