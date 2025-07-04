<?php


session_start();


if (!isset($_SESSION['role'])) {
  header("Location: sign-in.html");
  exit();
}
if (!($_SESSION['role'] == 'manager')) {
  header("Location: sign-in.html");
  exit();
}
// echo $_SESSION['role'];

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link
    rel="apple-touch-icon"
    sizes="76x76"
    href="../assets/img/apple-icon.png" />
  <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
  <title>Task Management System</title>
  <!--     Fonts and icons     -->
  <link
    rel="stylesheet"
    type="text/css"
    href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script
    src="https://kit.fontawesome.com/42d5adcbca.js"
    crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link
    rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!-- CSS Files -->
  <link
    id="pagestyle"
    href="../assets/css/material-dashboard.css?v=3.2.0"
    rel="stylesheet" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css"
    integrity="sha512-dPXYcDub/aeb08c63jRq/k6GaKccl256JQy/AnOq7CAnEZ9FzSL9wSbcZkMp4R26vBsMLFYH4kQ67/bbV8XaCQ=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer" />
  <style>
    .table-container {
      width: 100%;
      overflow-x: auto;
    }

    .custom-table {
      width: 100%;
      table-layout: auto;
      /* Ensures content fits dynamically */
      border-collapse: collapse;
    }

    .custom-table th,
    .custom-table td {
      padding: 12px;
      text-align: left;
      white-space: normal;
      /* Prevents text from overflowing */
    }

    .task-col {
      width: 40%;
      /* Task description takes more space */
    }

    .actions-dropdown {
      width: 10%;
      text-align: center;
    }

    .pagination-container {
      margin-top: 20px;
      padding: 10px;
    }

    .pagination-container button {
      min-width: 40px;
      height: 40px;
      border-radius: 8px;
      margin: 0 2px;
      transition: all 0.3s ease;
    }

    .pagination-container button:hover:not(.disabled) {
      transform: translateY(-2px);
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .pagination-container button.disabled {
      cursor: not-allowed;
      opacity: 0.6;
    }
  </style>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

  <!-- SweetAlert2 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

  <style>
    .col-1 {
      position: relative;
      display: inline-block;
    }

    .col-1 img {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      border-radius: 8px;
    }

    .col-1:hover img {
      transform: scale(1.05);
      /* Slightly enlarge */
      box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.3);
      /* Drop shadow effect */
    }

    .popup {
      position: absolute;
      bottom: 110%;
      left: 50%;
      transform: translateX(-50%);
      background-color: #333;
      color: white;
      padding: 8px 12px;
      border-radius: 5px;
      font-size: 14px;
      white-space: nowrap;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s ease, visibility 0.3s ease;
      box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
    }

    .col-1:hover .popup {
      opacity: 1;
      visibility: visible;
    }

    /* Add a small triangle pointer */
    .popup::after {
      content: "";
      position: absolute;
      top: 100%;
      left: 50%;
      transform: translateX(-50%);
      border-width: 5px;
      border-style: solid;
      border-color: #333 transparent transparent transparent;
    }
  </style>

</head>

<body class=" bg-gray-100 ">

  <main
    class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <nav
      class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl overflow-y-hidden "
      id="navbarBlur"
      data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <div class="d-flex justify-content-between align-items-center gap-2"
            class="navbar-brand px-4 py-3 m-0">
            <img
              src="https://e7.pngegg.com/pngimages/553/134/png-clipart-employee-engagement-human-resource-management-organization-teamwork-miscellaneous-company.png"
              class="navbar-brand-img rounded-pill"
              width="30"
              height="30"
              alt="main_logo" />
            <span class="ms-1 text-lg text-dark fw-bold">ETMS</span>
          </div>
        </nav>
        <div
          class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4 d-flex justify-content-end"
          id="navbar">

          <ul
            class="navbar-nav d-flex align-items-center justify-content-end ">

            <li class="mt-1 me-2">
              <a
                class="github-button text-capitalize text-lg"
                href="https://github.com/creativetimofficial/material-dashboard"
                data-icon="octicon-star"
                data-size="large"
                data-show-count="false"
                aria-label="Star creativetimofficial/material-dashboard on GitHub"><?php echo $_SESSION['name'] ?></a>
            </li>


            <button id="logout-btn" class="nav-link text-white border-0 bg-danger d-flex align-items-center px-2 py-1 rounded">
              <span class="nav-link-text ms-1 text-sm">Log Out</span>
            </button>
          </ul>
        </div>
      </div>
    </nav>




    <div class="container-fluid py-3">

      <div class="row d-flex align-items-center">
        <div class="col-9 text-end">
          <h3 class="mb-0 p-2 h3 font-weight-bolder bg-gradient-primary text-white py-4 px-4  rounded-lg d-inline-block d-flex justify-content-center"
            style="background: linear-gradient(45deg, #4F46E5, #7C3AED); box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            Admin Dashboard
          </h3>
        </div>
        <div class="col-1">
          <a href="./calendar.php"><img class="" style="width:100px; height:100px; object-fit:cover;object-position:center;" src="https://png.pngtree.com/png-vector/20221013/ourmid/pngtree-calendar-icon-logo-2023-date-time-png-image_6310337.png" /> </a>
        </div>
        <div class="col-2">
          <a href="./createTask.php" class="text-decoration-none">
            <div class="card shadow-lg border-0 hover-effect"
              style="transition: transform 0.2s ease; background: linear-gradient(to right, #ffffff, #f8fafc);">
              <div class="card-body p-3 d-flex align-items-center">
                <div>
                  <h5 class="mb-1 text-dark fw-bold" style="color: #1E293B;">Create Task</h5>
                  <p class="text-sm text-muted mb-0" style="color: #64748B;">Add a new task</p>
                </div>
                <div class="ms-3 shadow d-flex justify-content-center align-items-center"
                  style="width: 50px; height: 50px; border-radius: 12px; background: linear-gradient(45deg, #3B82F6, #1D4ED8);">
                  <i class="bi bi-plus-lg text-white fs-3"></i>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
    <div id="paginationContainer" class="pagination-container d-flex justify-content-center mt-4"></div>
    <style>
      .hover-effect:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1) !important;
      }

      .rounded-lg {
        border-radius: 0.5rem;
      }

      .text-sm {
        font-size: 0.875rem;
      }
    </style>

    <div class="row mb-4 p-2 ">
      <div class="col-lg-12 col-md-6 mb-md-0 mb-4">
        <div class="card">
          <div class="card-header pb-0">
            <div class="row">

              <div class="col-lg-6 col-5 my-auto text-end">
                <div class="dropdown float-lg-end pe-4">
                  <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-ellipsis-v text-secondary"></i>
                  </a>
                  <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">
                    <li><a class="dropdown-item border-radius-md" href="javascript:;">Action</a></li>
                    <li><a class="dropdown-item border-radius-md" href="javascript:;">Another action</a></li>
                    <li><a class="dropdown-item border-radius-md" href="javascript:;">Something else here</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body px-0 pb-2">

            <div class="table-responsive">
              <div class="table-container">
                <table class="custom-table">

                  <thead>

                    <tr class="border-bottom">
                      <th class="text-center">Employee</th>
                      <th class="task-col">Task & Description</th>
                      <th>Category</th>
                      <th class="text-center">Status</th>
                      <th>Due Date</th>
                      <th class="actions-dropdown">Actions</th>
                    </tr>
                  </thead>
                  <tbody id="taskTableBody">
                    <!-- <tr>
                        <td>John Doe</td>
                        <td class="task-col">
                          <strong>Develop New Feature</strong><br>
                          <span style="color: gray;">Implement the new dashboard component with API integration.</span>
                        </td>
                        <td>Development</td>
                        <td>

                          <span>New</span>
                        </td>
                        <td>Feb 25, 2025</td>
                        <td class="actions-dropdown">
                          <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                            Actions
                          </button>
                          <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Add</a></li>
                            <li><a class="dropdown-item text-danger" href="#">Delete</a></li>
                          </ul>
                        </td>
                      </tr> -->

                  </tbody>
                </table>
              </div>


            </div>
          </div>
        </div>
      </div>

    </div>

  </main>

  <!--   Core JS Files   -->
  <!-- SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../js/fetchTask.js"></script>
  <script src="../js/script.js"></script>
  <script>
    var win = navigator.platform.indexOf("Win") > -1;
    if (win && document.querySelector("#sidenav-scrollbar")) {
      var options = {
        damping: "0.5",
      };
      Scrollbar.init(document.querySelector("#sidenav-scrollbar"), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/material-dashboard.min.js?v=3.2.0"></script>
</body>

</html>