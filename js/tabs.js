console.log(window.fetchTask())
$(document).ready(function () {
    const statusColors = {
        1: "bg-secondary",
        2: "bg-info",
        3: "bg-warning",
        4: "bg-success"
    };


    let allTasks = []

    let currentStatus = 'all';






    // Fetch and display tasks
    function fetchTasks() {
        $.ajax({
            url: "../core/getLoggedInUserTask.php",
            method: "GET",
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    allTasks = response.tasks;
                    updateTaskCounts();
                    displayFilteredTasks(currentStatus);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching tasks:", error);
            }
        });

        updateTaskCounts();
        displayFilteredTasks(currentStatus);
    }

    // Update task counts in tabs
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

    // Display filtered tasks
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

    // Tab click handler
    $("#taskTabs .nav-link").click(function (e) {
        e.preventDefault();
        $("#taskTabs .nav-link").removeClass("active");
        $(this).addClass("active");
        currentStatus = $(this).data("status");
        displayFilteredTasks(currentStatus);
    });

    // Status change modal handlers
    $(document).on("click", ".status-btn", function () {
        const taskId = $(this).data("task-id");
        const taskTitle = $(this).data("task-title");
        const status = $(this).data("task-status");

        $("#taskId").val(taskId);
        $("#taskStatus").val(status);
        $(".modal-heading").text(taskTitle);
    });

    // Save status handler
    $("#saveStatus").click(function () {
        const taskId = $("#taskId").val();
        const status = $("#taskStatus").val();

        $.ajax({
            url: "../core/updateTaskStatus.php",
            method: "POST",
            data: { task_id: taskId, status: status },
            success: function (response) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('exampleModal'));
                modal.hide();

                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                $('body').css('padding-right', '');

                fetchTasks();
            },
            error: function (xhr, status, error) {
                console.error("Error updating status:", error);
            }
        });
    });

    // Initial fetch
    fetchTasks();
});
