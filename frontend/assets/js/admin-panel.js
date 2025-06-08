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

function capitalize(str) {
  return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
}

$(document).ready(function () {
  $("#pills-profile-tab").on("shown.bs.tab", function () {
    loadUsers();
  });

  if ($("#pills-profile").hasClass("active")) {
    loadUsers();
  }
});
