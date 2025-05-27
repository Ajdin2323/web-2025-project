function updateAuthUI() {
  const token = localStorage.getItem("token");
  const role = decodeJWT(token)?.role;

  if (token) {
    $(".logout-btn").show();
    $(".login-link").hide();
    $(".register-link").hide();
    $(".profile-link").show();
    if (role === "ADMIN") {
      $(".dashboard-link").show();
    } else {
      $(".dashboard-link").hide();
    }
  } else {
    $(".logout-btn").hide();
    $(".login-link").show();
    $(".register-link").show();
    $(".profile-link").hide();
    $(".dashboard-link").hide();
  }
}

$(document).ready(function () {
  updateAuthUI();

  $(".logout-btn").off("click").on("click", function (e) {
    e.preventDefault();
    localStorage.removeItem("token");
    alert("You have been logged out.");
    updateAuthUI();
    window.location.href = "#login";
  });
});

