$(document).ready(function () {
  // Get Task ID from URL
  const urlParams = new URLSearchParams(window.location.search);
  const taskId = urlParams.get("id");

  if (taskId) {
    $.ajax({
      url: "../core/getParticularTask.php", // Create a PHP file to fetch task details
      type: "GET",
      data: { id: taskId },
      success: function (response) {
        console.log(response);
        let task = JSON.parse(response);

        $("#task_name").val(task.title);
        $("#task_description").val(task.description);
        $("#assigned_user").val(task.assigned_to);
        $("#due_date").val(task.due_date);
        $("#priority").val(task.priority);
        $("#category").val(task.category_id);
        $("#status").val(task.status);
      },
    });
  }

  // Submit Edited Task
  $("#editTaskForm").submit(function (e) {
    e.preventDefault();
    let formData = {
      title: $("#task_name").val(),
      description: $("#task_description").val(),
      assigned_to: parseInt($("#assigned_user").val()),
      category_id: parseInt($("#category").val()),
      due_date: $("#due_date").val(),
      id: taskId,
    };
    console.log(
      "Sending data:",
      typeof formData.assigned_to,
      typeof formData.category_id
    );
    $.ajax({
      url: "../core/editTask.php",
      type: "POST",
      data: JSON.stringify(formData), // Convert data to JSON
      contentType: "application/json", // Set correct content type
      dataType: "json",
      success: function (response) {
        if (response.message) {
          Toastify({
            text: response.message,
            duration: 2000, // Auto close in 3 seconds
            gravity: "top", // Position: "top" or "bottom"
            position: "right", // Position: "left", "center" or "right"
            backgroundColor: "#257EEA",
            stopOnFocus: true,
            close: true,
            style: {
              borderRadius: "8px", // Rounded edges
              padding: "10px 15px", // Better spacing
            },
          }).showToast();
        } else if (response.error) {
          // alert("Error: " + response.error);
          Toastify({
            text: response.error,
            duration: 2000, // Auto close in 3 seconds
            gravity: "top", // Position: "top" or "bottom"
            position: "right", // Position: "left", "center" or "right"
            backgroundColor: "red",
            stopOnFocus: true,
            close: true,
            style: {
              borderRadius: "8px", // Rounded edges
              padding: "10px 15px", // Better spacing
            },
          }).showToast();
        }

        // $("#responseMessage").html(
        //   `<div class='alert alert-success'>${response}</div>`
        // );
        setTimeout(() => {
          window.location.href = "dashboard.php";
        }, 3000);
      },
      error: function () {
        $("#responseMessage").html(
          "<div class='alert alert-danger'>Error updating task.</div>"
        );

      },
    });
  });
});
