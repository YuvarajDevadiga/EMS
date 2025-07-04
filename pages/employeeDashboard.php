<?php
session_start();

if (!isset($_SESSION['role'])) {
  header("Location: sign-in.html");
  exit();
}
if (!($_SESSION['role'] == 'employee')) {
  header("Location: sign-in.html");
  exit();
}

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
  <title>Task Management System | Employee Dashbaord</title>
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
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
    rel="stylesheet" />
  <link
    rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Icons+Outlined" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <style>
    .nav-tabs .nav-link {
      color: #344767;
      font-weight: 500;
    }

    .nav-tabs .nav-link.active {
      color: #fff;
      background: #344767;
      border-color: #344767;
    }

    .task-count {
      font-size: 12px;
      padding: 2px 6px;
      border-radius: 10px;
      margin-left: 5px;
    }

    .table> :not(caption)>*>* {
      padding: 1rem 0.5rem;
    }
  </style>
  <style>
    .cal-img {
      position: relative;
      display: inline-block;
    }

    .cal-img img {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      border-radius: 8px;
    }

    .cal-img:hover img {
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

    .cal-img:hover .popup {
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

<body class="g-sidenav-show bg-gray-100">

  <main
    class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <!-- Navbar -->
    <nav
      class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl"
      id="navbarBlur"
      data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <a
            class="navbar-brand px-4 py-3 m-0"

            target="_blank">
            <img
              src="https://e7.pngegg.com/pngimages/553/134/png-clipart-employee-engagement-human-resource-management-organization-teamwork-miscellaneous-company.png"
              class="navbar-brand-img rounded-pill"
              width="30"
              height="30"
              alt="main_logo" />
            <span class="ms-1 text-lg text-dark">ETMS</span>
          </a>
        </nav>
        <div
          class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4 d-flex justify-content-end "
          id="navbar">

          <ul
            class="navbar-nav d-flex align-items-center justify-content-end">

            <li class="mt-1 me-4">
              <i class="text-capitalize"><?php echo $_SESSION['name'] ?></i>
            </li>
            <li class="nav-item ">
              <button id="logout-btn" class="nav-link text-white border-0 bg-danger d-flex align-items-center px-2 py-1 rounded">
                <span class="nav-link-text ms-1 text-sm">Log Out</span>
              </button>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-2">
      <div class="row d-flex justify-content-center">
        <div class="col-11">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Allocated Projects</h6>
              </div>

            </div>
            <!-- Pagination will be dynamically inserted here -->
            <div class="row d-flex align-items-center position-relative">
              <div class="task-pagination-container px-4 pt-4 border-bottom-0"></div>
              <div class="cal-img position-absolute w-25 top-10 pe-4 " style="right:0%;">
                <a href="./calendar.php"><img class="" style="width:90px; height:90px; object-fit:cover;object-position:center;" src="https://png.pngtree.com/png-vector/20221013/ourmid/pngtree-calendar-icon-logo-2023-date-time-png-image_6310337.png" /> </a>
              </div>
            </div>
            <div class="card-body px-4 pb-2">
              <!-- Tabs -->
              <ul class="nav nav-tabs mb-4" id="taskTabs" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" data-status="all">
                    All Tasks <span class="task-count bg-secondary text-white">0</span>
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" data-status="2">
                    Started <span class="task-count bg-info text-white">0</span>
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" data-status="3">
                    On Hold <span class="task-count bg-warning text-white">0</span>
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" data-status="4">
                    Completed <span class="task-count bg-success text-white">0</span>
                  </button>
                </li>
              </ul>

              <!-- Task Table -->
              <!-- <div class="table-responsive">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Category</th>
                      <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Task & Description</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Due Date</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                    </tr>
                  </thead>
                  <tbody id="taskTableBody"></tbody>
                </table>
              </div> -->


              <div class="table-responsive">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Category</th>
                      <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Task & Description</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Due Date</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                    </tr>
                  </thead>
                  <tbody id="taskTableBody"></tbody>
                </table>

              </div>

              <!-- Add this CSS to your existing styles -->
              <style>
                .task-pagination-container {
                  border-bottom: 1px solid #dee2e6;
                }

                .pagination {
                  gap: 2px;
                }

                .pagination .page-link {
                  color: #344767;
                  padding: 0.5rem 0.75rem;
                  min-width: 36px;
                  text-align: center;
                  border-radius: 4px !important;
                }

                .pagination .page-item.active .page-link {
                  background-color: #344767;
                  border-color: #344767;
                  color: white;
                }

                .pagination .page-item.disabled .page-link {
                  color: #6c757d;
                  pointer-events: none;
                  background-color: #f8f9fa;
                }

                .pagination .page-link:hover:not(.disabled) {
                  background-color: #e9ecef;
                  border-color: #dee2e6;
                  color: #344767;
                }

                .pagination .page-item.active .page-link:hover {
                  background-color: #344767;
                  color: white;
                }
              </style>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Status Change Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-capitalize" id="exampleModalLabel">Change Status</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="taskId" />
            <span>Task</span> - <label for="taskStatus" class="form-label modal-heading">Select Task Status</label>
            <select id="taskStatus" class="form-select p-2">
              <option class="p-2" value="2">Started</option>
              <option class="p-2" value="3">On Hold</option>
              <option class="p-2" value="4">Completed</option>
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button id="saveStatus" type="button" class="btn btn-success">Save changes</button>
          </div>
        </div>
      </div>
    </div>
  </main>


  <!--   Core JS Files   -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script src="../js/script.js"></script>
  <script src="../js/changeStatus.js"></script>
  <script src="../js/session.js"></script>
  <script>
    var win = navigator.platform.indexOf("Win") > -1;
    if (win && document.querySelector("#sidenav-scrollbar")) {
      var options = {
        damping: "0.5",
      };
      Scrollbar.init(document.querySelector("#sidenav-scrollbar"), options);
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>