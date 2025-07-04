




$(document).ready(function () {
  const statusColors = {
    1: "bg-secondary",
    2: "bg-info",
    3: "bg-warning",
    4: "bg-success",
  };

  let allTasks = []
  let currentStatus = 'all';
  let currentPage = 1;


  // Fetch session details
  $.ajax({
    url: "../core/session.php",
    method: "GET",
    dataType: "json",
    success: function (userData) {
      if (userData.status === "error") {
        console.log("User not logged in.");
        return;
      }

      console.log("Logged-in User:", userData);

      // Now fetch tasks assigned to the user
      fetchTask();
    },
    error: function (xhr, status, error) {
      console.error("Error fetching session data:", error);
    },
  });

  window.fetchTask = function (page = 1) {
    console.log("hi");
    $.ajax({
      url: `../core/getLoggedInUserTask.php?page=${page}`,
      method: "GET",
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          allTasks = response.tasks;
          updateTaskCounts();
          displayFilteredTasks(currentStatus);
          renderPagination(response.pagination);
        } else {
          console.log("No tasks found.");
        }
      },
      error: function (xhr, status, error) {
        console.error("Error fetching tasks:", error);
      },
    });
  }

  function renderPagination(pagination) {
    const { current_page, total_pages } = pagination;
    // Calculate page range
    let startPage = Math.max(1, current_page - 4);
    let endPage = Math.min(startPage + 9, total_pages);

    // Adjust startPage if we're near the end
    if (endPage - startPage < 9) {
      startPage = Math.max(1, endPage - 9);
    }

    let paginationHtml = '<nav aria-label="Task pagination"><ul class="pagination justify-content-center m-0">';

    // First page and back 10 pages buttons
    paginationHtml += `
        <li class="page-item ${current_page === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" data-page="1" title="First page">⋘</a>
        </li>
        <li class="page-item ${current_page <= 10 ? 'disabled' : ''}">
            <a class="page-link" href="#" data-page="${Math.max(1, current_page - 10)}" title="Back 10 pages">≪</a>
        </li>
        <li class="page-item ${current_page === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" data-page="${current_page - 1}" title="Previous page">＜</a>
        </li>
    `;

    // Page numbers
    for (let i = startPage; i <= endPage; i++) {
      paginationHtml += `
            <li class="page-item ${i === current_page ? 'active' : ''}">
                <a class="page-link" href="#" data-page="${i}">${i}</a>
            </li>
        `;
    }

    // Next page, forward 10 pages, and last page buttons
    paginationHtml += `
        <li class="page-item ${current_page === total_pages ? 'disabled' : ''}">
            <a class="page-link" href="#" data-page="${current_page + 1}" title="Next page">＞</a>
        </li>
        <li class="page-item ${current_page > total_pages - 10 ? 'disabled' : ''}">
            <a class="page-link" href="#" data-page="${Math.min(total_pages, current_page + 10)}" title="Forward 10 pages">≫</a>
        </li>
        <li class="page-item ${current_page === total_pages ? 'disabled' : ''}">
            <a class="page-link" href="#" data-page="${total_pages}" title="Last page">⋙</a>
        </li>
    `;

    paginationHtml += '</ul></nav>';

    // Remove any existing pagination
    $('.task-pagination').remove();

    // Add pagination to the container below heading
    $('.task-pagination-container').html(paginationHtml);
  }

  // Handle pagination clicks
  $(document).on('click', '.pagination .page-link', function (e) {
    e.preventDefault();
    const page = $(this).data('page');
    if (page >= 1) {
      currentPage = page;
      window.fetchTask(page);
    }
  });

  function updateTaskCounts() {
    const counts = {
      all: allTasks.length,
      2: allTasks.filter(t => t.status == 2).length,
      3: allTasks.filter(t => t.status == 3).length,
      4: allTasks.filter(t => t.status == 4).length
    };

    Object.entries(counts).forEach(([status, count]) => {
      $(`[data-status="${status}"] .task-count`).text(count);
    });
  }

  function displayFilteredTasks(status) {
    const filteredTasks = status === 'all'
      ? allTasks
      : allTasks.filter(task => task.status == status);

    const taskTableBody = $("#taskTableBody");
    taskTableBody.empty();

    if (filteredTasks.length === 0) {
      taskTableBody.append('<tr><td colspan="5" class="text-center py-4">No tasks found</td></tr>');
      return;
    }

    filteredTasks.forEach(task => {
      taskTableBody.append(`
        <tr>
            <td class="align-middle text-start">
                <span class="text-secondary text-xs font-weight-bold">
                    ${task.category_name}
                </span>
            </td>
            <td class="align-middle text-start">
                <div class="d-flex px-2 py-1 flex-column">
                    <h6 class="mb-0 text-sm text-capitalize">${task.title}</h6>
                    <p class="text-xs text-muted mb-0 text-capitalize">${task.description}</p>
                </div>
            </td>
            <td class="align-middle text-center text-sm">
                <span class="badge badge-sm ${statusColors[task.status]}">${task.status_name}</span>
            </td>
            <td class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">
                    ${task.due_date?.split("-").reverse().join("-")}
                </span>
            </td>
            <td class="align-middle text-center">
                <button id="status-btn" type="button" class="btn btn-info status-btn"
                    data-bs-toggle="modal" data-bs-target="#exampleModal"
                    data-task-id="${task.id}" data-task-title="${task.title}" data-task-status="${task.status}">
                    Change Status
                </button>
            </td>
        </tr>
      `);
    });
  }

  $("#taskTabs .nav-link").click(function (e) {
    e.preventDefault();
    $("#taskTabs .nav-link").removeClass("active");
    $(this).addClass("active");
    currentStatus = $(this).data("status");
    displayFilteredTasks(currentStatus);
  });

  $(document).on("click", ".status-btn", function () {
    const taskId = $(this).data("task-id");
    const taskTitle = $(this).data("task-title");
    const status = $(this).data("task-status");

    $("#taskId").val(taskId);
    $("#taskStatus").val(status);
    $(".modal-heading").text(taskTitle);
  });
  // console.log(currentPage);
  // Initial fetch
  window.fetchTask();

});