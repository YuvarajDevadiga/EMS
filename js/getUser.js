$(document).ready(function () {
  function loadUsers() {
    $.ajax({
      url: "../core/fetch_users.php",
      type: "GET",
      dataType: "json",
      success: function (response) {
        let userDropdown = $("#assigned_user");
        userDropdown.empty();
        userDropdown.append('<option value="">Select User</option>');
        $.each(response, function (index, user) {
          userDropdown.append(
            '<option value="' + user.id + '">' + user.name + "</option>"
          );
        });
      },
      error: function () {
        $("#assigned_user").html(
          '<option value="">Failed to load users</option>'
        );
      },
    });
  }

  // Load users on page load
  loadUsers();

  $("#taskForm").submit(function (event) {
    event.preventDefault(); // Prevent default form submission

    let formData = {
      title: $("#task_name").val(),
      description: $("#task_description").val(),
      assigned_to: $("#assigned_user").val(),
      category_id: $("#category").val(),
      due_date: $("#due_date").val(),
    };

    console.log("Sending data:", formData); // Debugging log

    $.ajax({
      url: "../core/addTask.php", // Ensure this path is correct
      type: "POST", // Change to POST
      data: JSON.stringify(formData), // Convert data to JSON
      contentType: "application/json", // Set correct content type
      dataType: "json", // Expect JSON response
      success: function (response) {
        console.log("Server response:", response);
        if (response.status === "success") {
          // alert(response.message); // Show success message
          $("#taskForm")[0].reset(); // Reset the form
          // window.location.href = "../pages/dashboard.php";
          Toastify({
            text: response.message,
            duration: 2000,
            close: true,
            gravity: "top", // `top` or `bottom`
            position: "right", // `left`, `center` or `right`
            stopOnFocus: true,
            backgroundColor: "#5CB360",
            style: {
              borderRadius: "8px", // Rounded edges
              padding: "10px 15px", // Better spacing
            },
            onClick: function () { }, // Callback after click
          }).showToast();
          setTimeout(() => window.location.href = "../pages/dashboard.php", 2500);
        } else {
          // alert("Error: " + response.message); // Show error message
          Toastify({
            text: response.message,
            duration: 2000,
            close: true,
            gravity: "top", // `top` or `bottom`
            position: "right", // `left`, `center` or `right`
            stopOnFocus: true,
            backgroundColor: "red",
            style: {
              borderRadius: "8px", // Rounded edges
              padding: "10px 15px", // Better spacing
            },
            onClick: function () { }, // Callback after click
          }).showToast();
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", xhr.responseText);
      },
    });
  });
});
