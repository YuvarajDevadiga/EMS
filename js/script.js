// $(document).ready(function () {
//   $("#signupForm").submit(function (event) {
//     event.preventDefault();

//     let name = $("#name").val().trim();
//     let email = $("#email").val().trim();
//     let password = $("#password").val().trim();

//     // Validate fields
//     if (!name || !email || !password) {
//       //   $("#responseMessage").html(
//       //     "<span style='color:red;'>All fields are required.</span>"
//       //   );
//       alert("All fields are required.");
//       return;
//     }

//     var formData = {
//       name: name,
//       email: email,
//       password: password,
//     };
//     console.log("Start of Ajax");
//     $.ajax({
//       type: "POST",
//       url: "../core/signup.php",
//       data: formData,
//       dataType: "json",
//       success: function (response) {
//         console.log("success response");
//         // alert("Successfully Registered");
//         if (response.success) {
//           // alert(response.message);
//           Toastify({
//             text: response.message,
//             duration: 2000, // Auto close in 3 seconds
//             gravity: "top", // Position: "top" or "bottom"
//             position: "right", // Position: "left", "center" or "right"
//             backgroundColor: "green",
//             stopOnFocus: true,
//             close: true,
//             style: {
//               borderRadius: "8px", // Rounded edges
//               padding: "10px 15px", // Better spacing
//             },
//           }).showToast();
//           $("#signupForm")[0].reset();
//           setTimeout(() => window.location.href = "../pages/sign-in.html", 3000);
//         } else {
//           Toastify({
//             text: response.message,
//             duration: 2000, // Auto close in 3 seconds
//             gravity: "top", // Position: "top" or "bottom"
//             position: "right", // Position: "left", "center" or "right"
//             backgroundColor: "red",
//             stopOnFocus: true,
//             close: true,
//             style: {
//               borderRadius: "8px", // Rounded edges
//               padding: "10px 15px", // Better spacing
//             },
//           }).showToast();
//         }
//       },
//       error: function () {
//         console.log("error response");
//         Toastify({
//           text: "Something went wrong!",
//           duration: 2000, // Auto close in 3 seconds
//           gravity: "top", // Position: "top" or "bottom"
//           position: "right", // Position: "left", "center" or "right"
//           backgroundColor: "green",
//           stopOnFocus: true,
//           close: true,
//           style: {
//             borderRadius: "8px", // Rounded edges
//             padding: "10px 15px", // Better spacing
//           },
//         }).showToast();
//       },
//     });
//   });
// });

$(document).ready(function () {
  // Add custom method for password strength
  $.validator.addMethod("strongPassword", function (value, element) {
    return this.optional(element) ||
      /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(value);
  }, "Password must contain at least 8 characters, including uppercase, lowercase, number and special character");

  $("#signupForm").validate({
    rules: {
      name: {
        required: true,
        minlength: 2
      },
      email: {
        required: true,
        email: true
      },
      password: {
        required: true,
        strongPassword: true
      }
    },
    messages: {
      name: {
        required: "Please enter your name",
        minlength: "Name must be at least 2 characters long"
      },
      email: {
        required: "Please enter your email",
        email: "Please enter a valid email address"
      },
      password: {
        required: "Please enter a password"
      }
    },
    errorElement: "div",
    errorClass: "error-message",
    errorPlacement: function (error, element) {
      error.insertAfter(element.closest('.input-group'));
    },
    highlight: function (element) {
      $(element).closest('.input-group').addClass("is-invalid");
    },
    unhighlight: function (element) {
      $(element).closest('.input-group').removeClass("is-invalid");
    },
    submitHandler: function (form, event) {
      event.preventDefault();

      let formData = {
        name: $("#name").val().trim(),
        email: $("#email").val().trim(),
        password: $("#password").val().trim()
      };

      $.ajax({
        type: "POST",
        url: "../core/signup.php",
        data: formData,
        dataType: "json",
        success: function (response) {
          if (response.success) {
            Toastify({
              text: response.message,
              duration: 2000,
              gravity: "top",
              position: "right",
              backgroundColor: "green",
              stopOnFocus: true,
              close: true,
              style: {
                borderRadius: "8px",
                padding: "10px 15px",
              },
            }).showToast();

            $("#signupForm")[0].reset();
            setTimeout(() => window.location.href = "../pages/sign-in.html", 2500);
          } else {
            Toastify({
              text: response.message,
              duration: 2000,
              gravity: "top",
              position: "right",
              backgroundColor: "red",
              stopOnFocus: true,
              close: true,
              style: {
                borderRadius: "8px",
                padding: "10px 15px",
              },
            }).showToast();
          }
        },
        error: function () {
          Toastify({
            text: "Something went wrong!",
            duration: 2000,
            gravity: "top",
            position: "right",
            backgroundColor: "red",
            stopOnFocus: true,
            close: true,
            style: {
              borderRadius: "8px",
              padding: "10px 15px",
            },
          }).showToast();
        }
      });
    }
  });
});

// $(document).ready(function () {
//   $("#login-form").submit(function (event) {
//     event.preventDefault(); // Prevent form from submitting normally

//     let email = $("#email").val().trim();
//     let password = $("#password").val().trim();

//     if (!email || !password) {
//       $("#responseMessage").html(
//         "<span style='color:red;'>Please fill in both fields.</span>"
//       );
//       return;
//     }

//     // Send login request to the server
//     $.ajax({
//       url: "../core/signin.php", // Backend login route
//       type: "POST",
//       data: { email: email, password: password }, // Form data
//       dataType: "json", // Expect JSON response
//       success: function (response) {
//         console.log(response);
//         if (response.status === "success") {
//           if (response.role === "manager") {
//             $("#responseMessage").html(
//               "<span style='color:green;'>" + response.message + "</span>"
//             );
//             window.location.href = "../pages/dashboard.php"; // Redirect after login
//           } else {
//             $("#responseMessage").html(
//               "<span style='color:green;'>" + response.message + "</span>"
//             );

//             window.location.href = "../pages/employeeDashboard.php"; // Redirect after login
//           }
//         } else {
//           Toastify({
//             text: response.message,
//             duration: 2000, // Auto close in 3 seconds
//             gravity: "top", // Position: "top" or "bottom"
//             position: "right", // Position: "left", "center" or "right"
//             backgroundColor: "#E52020",
//             stopOnFocus: true,
//             close: true,
//             style: {
//               borderRadius: "8px", // Rounded edges
//               padding: "10px 15px", // Better spacing
//             },
//           }).showToast();
//         }
//       },
//       error: function () {
//         Toastify({
//           text: "Something went Wrong",
//           duration: 2000, // Auto close in 3 seconds
//           gravity: "top", // Position: "top" or "bottom"
//           position: "right", // Position: "left", "center" or "right"
//           backgroundColor: "#E52020",
//           stopOnFocus: true,
//           close: true,
//           style: {
//             borderRadius: "8px", // Rounded edges
//             padding: "10px 15px", // Better spacing
//           },
//         }).showToast();
//       },
//     });
//   });
// });

// $(document).ready(function () {
//   $("#login-form").validate({
//     rules: {
//       email: {
//         required: true,
//         email: true
//       },
//       password: {
//         required: true
//       }
//     },
//     messages: {
//       email: {
//         required: "Please enter your email",
//         email: "Please enter a valid email address"
//       },
//       password: {
//         required: "Please enter your password"
//       }
//     },
//     errorElement: "div",
//     errorClass: "error-message",
//     errorPlacement: function (error, element) {
//       error.insertAfter(element.closest('.input-group'));
//     },
//     highlight: function (element) {
//       $(element).closest('.input-group').addClass("is-invalid");
//       $(element).addClass("error-input");
//     },
//     unhighlight: function (element) {
//       $(element).closest('.input-group').removeClass("is-invalid");
//       $(element).removeClass("error-input");
//     },
//     submitHandler: function (form, event) {
//       event.preventDefault();

//       let formData = {
//         email: $("#email").val().trim(),
//         password: $("#password").val().trim()
//       };

//       $.ajax({
//         url: "../core/signin.php",
//         type: "POST",
//         data: formData,
//         dataType: "json",
//         success: function (response) {
//           console.log(response);
//           if (response.status === "success") {
//             Toastify({
//               text: response.message,
//               duration: 2000,
//               gravity: "top",
//               position: "right",
//               backgroundColor: "green",
//               stopOnFocus: true,
//               close: true,
//               style: {
//                 borderRadius: "8px",
//                 padding: "10px 15px",
//               },
//             }).showToast();

//             if (response.role === "manager") {
//               setTimeout(() => window.location.href = "../pages/dashboard.php", 3000);
//             } else {
//               setTimeout(() => window.location.href = "../pages/employeeDashboard.php", 3000);
//             }
//           } else {
//             Toastify({
//               text: response.message,
//               duration: 2000,
//               gravity: "top",
//               position: "right",
//               backgroundColor: "#E52020",
//               stopOnFocus: true,
//               close: true,
//               style: {
//                 borderRadius: "8px",
//                 padding: "10px 15px",
//               },
//             }).showToast();
//           }
//         },
//         error: function () {
//           Toastify({
//             text: "Something went Wrong",
//             duration: 2000,
//             gravity: "top",
//             position: "right",
//             backgroundColor: "#E52020",
//             stopOnFocus: true,
//             close: true,
//             style: {
//               borderRadius: "8px",
//               padding: "10px 15px",
//             },
//           }).showToast();
//         }
//       });
//     }
//   });
// });


$(document).ready(function () {
  // Add name attributes to form inputs
  $("#email").attr("name", "email");
  $("#password").attr("name", "password");

  // Initialize form validation
  $("#login-form").validate({
    rules: {
      email: {
        required: true,
        email: true
      },
      password: {
        required: true,
        minlength: 5
      }
    },
    messages: {
      email: {
        required: "Please enter your email",
        email: "Please enter a valid email address"
      },
      password: {
        required: "Please enter your password",
        minlength: "Password must be at least 5 characters long"
      }
    },
    errorElement: "div",
    errorClass: "error-message",
    errorPlacement: function (error, element) {
      error.insertAfter(element.closest('.input-group'));
    },
    highlight: function (element) {
      $(element).closest('.input-group').addClass("is-invalid");
      $(element).addClass("error-input");
    },
    unhighlight: function (element) {
      $(element).closest('.input-group').removeClass("is-invalid");
      $(element).removeClass("error-input");
    },
    // Prevent form from submitting normally
    submitHandler: function (form, event) {
      event.preventDefault();

      let formData = {
        email: $("#email").val().trim(),
        password: $("#password").val().trim()
      };

      $.ajax({
        url: "../core/signin.php",
        type: "POST",
        data: formData,
        dataType: "json",
        success: function (response) {
          console.log(response);
          if (response.status === "success") {
            Toastify({
              text: response.message,
              duration: 2000,
              gravity: "top",
              position: "right",
              backgroundColor: "green",
              stopOnFocus: true,
              close: true,
              style: {
                borderRadius: "8px",
                padding: "10px 15px",
              },
            }).showToast();

            if (response.role === "manager") {
              setTimeout(() => window.location.href = "../pages/dashboard.php", 2500);
            } else {
              setTimeout(() => window.location.href = "../pages/employeeDashboard.php", 2500);
            }
          } else {
            Toastify({
              text: response.message,
              duration: 2000,
              gravity: "top",
              position: "right",
              backgroundColor: "#E52020",
              stopOnFocus: true,
              close: true,
              style: {
                borderRadius: "8px",
                padding: "10px 15px",
              },
            }).showToast();
          }
        },
        error: function () {
          Toastify({
            text: "Something went Wrong",
            duration: 2000,
            gravity: "top",
            position: "right",
            backgroundColor: "#E52020",
            stopOnFocus: true,
            close: true,
            style: {
              borderRadius: "8px",
              padding: "10px 15px",
            },
          }).showToast();
        }
      });
    }
  });
});

$(document).ready(function () {
  $("#logout-btn").click(function (e) {
    // Show confirmation popup
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, Log out!"
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "../core/logout.php", // Backend logout script
          type: "POST",
          success: function (response) {
            // Redirect to login page after logout
            Swal.fire({
              title: "Logged Out!",
              text: "You have been logged out successfully..",
              icon: "success",
              showConfirmButton: false, // Hides the "OK" button
              timer: 2000 // Auto closes after 2 seconds
            });
            Toastify({
              text: "You have been logged out successfully.",
              duration: 2000, // Auto close in 3 seconds
              gravity: "top", // Position: "top" or "bottom"
              position: "right", // Position: "left", "center" or "right"
              backgroundColor: "green",
              stopOnFocus: true,
              close: true,
              style: {
                borderRadius: "8px", // Rounded edges
                padding: "10px 15px", // Better spacing
              },
            }).showToast();
            setTimeout(() => window.location.href = "../pages/sign-in.html", 2500)
          },
          error: function () {
            // alert("Error logging out. Please try again.");
            Toastify({
              text: "Error logging out. Please try again.",
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
          },
        });
        Swal.fire({
          title: "Logged Out",
          text: "Successfully Logged Out.",
          icon: "success"
        });
      }
    });

    // if (confirm("Are you sure you want to log out?")) {

    // }
  });
});
