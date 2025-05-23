const Pagination = (function () {
  let currentPage = 1;
  let perPage = 10;
  let endpoint = "";
  let renderCallback = null;
  let containerSelector = ".row.row-cols-1";

  function fetchData(page) {
    const url = `${endpoint}/${perPage}/${page}`;
    $.ajax({
      url: url,
      method: "GET",
      dataType: "json",
      success: function (response) {
        if (response.products) {
          const container = $(containerSelector);
          container.empty();
          renderCallback(response.products);
          renderPagination(response.has_more, page);
        }
      },
      error: function (xhr, status, error) {
        console.error("Pagination fetch error:", error);
      }
    });
  }

  function renderPagination(hasMore, currentPage) {
    const pagination = $(".pagination");
    pagination.empty();

    const prevDisabled = currentPage === 1 ? "disabled" : "";
    const nextDisabled = !hasMore ? "disabled" : "";

    pagination.append(`
      <li class="page-item ${prevDisabled}">
        <a class="page-link" href="#" data-page="${currentPage - 1}" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
    `);

    pagination.append(`
      <li class="page-item active">
        <span class="page-link">${currentPage}</span>
      </li>
    `);

    pagination.append(`
      <li class="page-item ${nextDisabled}">
        <a class="page-link" href="#" data-page="${currentPage + 1}" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
    `);

    $(".pagination a").on("click", function (e) {
      e.preventDefault();
      const newPage = parseInt($(this).data("page"));
      if (newPage && newPage !== currentPage) {
        currentPage = newPage;
        fetchData(currentPage);
      }
    });
  }

  function init(options) {
    currentPage = 1;
    endpoint = options.endpoint;
    renderCallback = options.renderCallback;
    containerSelector = options.containerSelector || ".row.row-cols-1";

    if (Number.isInteger(options.perPage)) {
      perPage = options.perPage;
    }

    fetchData(currentPage);
  }

  function setPerPage(n) {
    if (Number.isInteger(n) && n > 0) {
      perPage = n;
    }
  }

  return {
    init,
    setPerPage
  };
})();
