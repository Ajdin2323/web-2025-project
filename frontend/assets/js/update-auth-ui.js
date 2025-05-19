function updateAuthUI() {
  const token = localStorage.getItem("token");

  if (token) {
    $(".logout-btn").show();
    $(".login-link").hide();
    $(".register-link").hide();
    $(".profile-link").show();
  } else {
    $(".logout-btn").hide();
    $(".login-link").show();
    $(".register-link").show();
    $(".profile-link").hide();
  }
}

$(document).ready(function () {
  updateAuthUI();

  $(".logout-btn").on("click", function (e) {
    e.preventDefault();
    localStorage.removeItem("token");
    alert("You have been logged out.");
    updateAuthUI();
    window.location.href = "#login";
  });
});
