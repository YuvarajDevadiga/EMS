





// $(document).ready(function () {
//   // Handle opening the modal and setting task ID
//   var id;
//   $(document).on("click", "#status-btn", function () {
//     let taskId = $(this).data("task-id");
//     let taskTitle = $(this).data("task-title");
//     let status = $(this).data("task-status");
//     console.log("Task ID:", taskId);
//     id = taskId;
//     $("#taskStatus").val(status);
//     // Store task ID in the modal
//     $("#taskId").attr("data-task-id", taskId);
//     $(".modal-heading").text(taskTitle);
//   });

//   // Handle status update
//   $("#saveStatus").click(function () {
//     var taskId = id;
//     var status = Number($("#taskStatus").val());
//     console.log(taskId, status);

//     $.ajax({
//       url: "../core/updateTaskStatus.php",
//       method: "POST",
//       data: { task_id: taskId, status: status },
//       success: function (response) {
//         // First hide the modal properly
//         const modal = bootstrap.Modal.getInstance(document.getElementById('exampleModal'));
//         modal.hide();

//         // Remove backdrop and cleanup
//         $('.modal-backdrop').remove();
//         $('body').removeClass('modal-open');
//         $('body').css('padding-right', '');


//         window.fetchTask();

//       },
//       error: function (xhr, status, error) {
//         console.error("Error updating status:", error);
//         showToast('Error updating status!', 'error', 'error');
//       },
//     });
//   });
// });




$(document).ready(function () {
  // Store the task ID and current page globally
  let currentTaskId;

  // Remove any existing click handlers to prevent duplicate calls
  $(document).off("click", "#status-btn").on("click", "#status-btn", function () {
    const taskId = $(this).data("task-id");
    const taskTitle = $(this).data("task-title");
    const status = $(this).data("task-status");

    currentTaskId = taskId;

    $("#taskStatus").val(status);
    $("#taskId").attr("data-task-id", taskId);
    $(".modal-heading").text(taskTitle);
  });

  // Remove any existing click handlers on save button
  $("#saveStatus").off("click").on("click", function () {
    const status = Number($("#taskStatus").val());

    // Get current page from the active pagination link
    const currentPage = $('.pagination .page-item.active .page-link').data('page') || 1;

    $.ajax({
      url: "../core/updateTaskStatus.php",
      method: "POST",
      data: {
        task_id: currentTaskId,
        status: status
      },
      success: function (response) {
        // Close modal properly
        const modal = bootstrap.Modal.getInstance(document.getElementById('exampleModal'));
        modal.hide();

        // Clean up modal artifacts
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');
        $('body').css('padding-right', '');

        // Fetch tasks for the current page
        window.fetchTask(currentPage);
      },
      error: function (xhr, status, error) {
        console.error("Error updating status:", error);
        // Optionally show error message to user
        // showToast('Error updating status!', 'error', 'error');
      }
    });
  });
});