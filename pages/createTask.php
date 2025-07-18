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

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link
    rel="apple-touch-icon"
    sizes="76x76"
    href="../assets/img/apple-icon.png" />
  <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
  <title>Task Management System|Add Task</title>
  <link
    rel="stylesheet"
    type="text/css"
    href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <script
    src="https://kit.fontawesome.com/42d5adcbca.js"
    crossorigin="anonymous"></script>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
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
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>

<body class="g-sidenav-show bg-gray-100">
  <!-- <aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2 bg-white my-2"
    id="sidenav-main">
    <div class="sidenav-header">
      <i
        class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
        aria-hidden="true"
        id="iconSidenav"></i>
      <a href="./dashboard.php"
        class="navbar-brand px-4 py-3 m-0"
        target="_blank">
        <img
          src="https://e7.pngegg.com/pngimages/553/134/png-clipart-employee-engagement-human-resource-management-organization-teamwork-miscellaneous-company.png"
          class="navbar-brand-img rounded-pill"
          width="26"
          height="26"
          alt="main_logo" />
        <span class="ms-1 text-sm text-dark">ETMS</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2" />
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <?php

        if ($_SESSION['role'] == 'manager') {
          echo '<li class="nav-item">
          <a
            class="nav-link active bg-gradient-dark text-white"
            href="../pages/dashboard.php">
            <i class="material-symbols-rounded opacity-5">dashboard</i>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>';
        } else {
          echo '<li class="nav-item">
          <a class="nav-link active bg-gradient-dark text-white" href="../pages/employeeDashboard.php">
            <i class="material-symbols-rounded opacity-5">table_view</i>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>';
        }
        ?>
        <li class="nav-item mt-3">
          <h6
            class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">
            Account pages
          </h6>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="../pages/profile.html">
            <i class="material-symbols-rounded opacity-5">person</i>
            <span class="nav-link-text ms-1">Profile</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="../pages/sign-in.html">
            <i class="material-symbols-rounded opacity-5">login</i>
            <span class="nav-link-text ms-1">Sign In</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="../pages/sign-up.html">
            <i class="material-symbols-rounded opacity-5">assignment</i>
            <span class="nav-link-text ms-1">Sign Up</span>
          </a>
        </li>
      </ul>
    </div>

  </aside> -->
  <main
    class="main-content position-relative max-height-vh-100 h-100 border-radius-lg  ">
    <nav
      class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl "
      id="navbarBlur"
      data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol
            class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm fw-bold text-start">
              <!-- <a class="opacity-5 text-dark" href="./dashboard.php">
              </a> -->
              <a href="./dashboard.php"
                class="navbar-brand px-4 py-3 m-0">
                <img
                  src="https://e7.pngegg.com/pngimages/553/134/png-clipart-employee-engagement-human-resource-management-organization-teamwork-miscellaneous-company.png"
                  class="navbar-brand-img rounded-pill"
                  width="30"
                  height="30"
                  alt="main_logo" />
                <span class="ms-1 text-lg text-dark">ETMS</span>
              </a>
            </li>

          </ol>
        </nav>
        <div
          class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4  d-flex justify-content-end"
          id="navbar">

          <ul
            class="navbar-nav d-flex align-items-center justify-content-end">
            <!-- <li class="nav-item d-flex align-items-center">
              <a
                class="btn btn-outline-primary btn-sm mb-0 me-3"
                target="_blank"
                href="https://www.creative-tim.com/builder?ref=navbar-material-dashboard">Online Builder</a>
            </li> -->
            <li class="mt-1">
              <a
                class="github-button text-capitalize"
                href="https://github.com/creativetimofficial/material-dashboard"
                data-icon="octicon-star"
                data-size="large"
                data-show-count="false"
                aria-label="Star creativetimofficial/material-dashboard on GitHub"><?php echo $_SESSION['name'] ?></a>
            </li>
            <!-- <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a
                href="javascript:;"
                class="nav-link text-body p-0"
                id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li> -->
            <!-- <li class="nav-item px-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0">
                <i class="material-symbols-rounded fixed-plugin-button-nav">settings</i>
              </a>
            </li> -->
            <!-- <li class="nav-item dropdown pe-3 d-flex align-items-center">
              <a
                href="javascript:;"
                class="nav-link text-body p-0"
                id="dropdownMenuButton"
                data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="material-symbols-rounded">notifications</i>
              </a>
              <ul
                class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4"
                aria-labelledby="dropdownMenuButton">
                <li class="mb-2">
                  <a
                    class="dropdown-item border-radius-md"
                    href="javascript:;">
                    <div class="d-flex py-1">
                      <div class="my-auto">
                        <img
                          src="../assets/img/team-2.jpg"
                          class="avatar avatar-sm me-3" />
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          <span class="font-weight-bold">New message</span>
                          from Laur
                        </h6>
                        <p class="text-xs text-secondary mb-0">
                          <i class="fa fa-clock me-1"></i>
                          13 minutes ago
                        </p>
                      </div>
                    </div>
                  </a>
                </li>
                <li class="mb-2">
                  <a
                    class="dropdown-item border-radius-md"
                    href="javascript:;">
                    <div class="d-flex py-1">
                      <div class="my-auto">
                        <img
                          src="../assets/img/small-logos/logo-spotify.svg"
                          class="avatar avatar-sm bg-gradient-dark me-3" />
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          <span class="font-weight-bold">New album</span> by
                          Travis Scott
                        </h6>
                        <p class="text-xs text-secondary mb-0">
                          <i class="fa fa-clock me-1"></i>
                          1 day
                        </p>
                      </div>
                    </div>
                  </a>
                </li>
                <li>
                  <a
                    class="dropdown-item border-radius-md"
                    href="javascript:;">
                    <div class="d-flex py-1">
                      <div
                        class="avatar avatar-sm bg-gradient-secondary me-3 my-auto">
                        <svg
                          width="12px"
                          height="12px"
                          viewBox="0 0 43 36"
                          version="1.1"
                          xmlns="http://www.w3.org/2000/svg"
                          xmlns:xlink="http://www.w3.org/1999/xlink">
                          <title>credit-card</title>
                          <g
                            stroke="none"
                            stroke-width="1"
                            fill="none"
                            fill-rule="evenodd">
                            <g
                              transform="translate(-2169.000000, -745.000000)"
                              fill="#FFFFFF"
                              fill-rule="nonzero">
                              <g
                                transform="translate(1716.000000, 291.000000)">
                                <g
                                  transform="translate(453.000000, 454.000000)">
                                  <path
                                    class="color-background"
                                    d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z"
                                    opacity="0.593633743"></path>
                                  <path
                                    class="color-background"
                                    d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z"></path>
                                </g>
                              </g>
                            </g>
                          </g>
                        </svg>
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          Payment successfully completed
                        </h6>
                        <p class="text-xs text-secondary mb-0">
                          <i class="fa fa-clock me-1"></i>
                          2 days
                        </p>
                      </div>
                    </div>
                  </a>
                </li>
              </ul>
            </li> -->
            <!-- <li class="nav-item d-flex align-items-center">
              <a
                href="../pages/sign-in.html"
                class="nav-link text-body font-weight-bold px-0">
                <i class="material-symbols-rounded">account_circle</i>
              </a>
            </li> -->
          </ul>
        </div>
      </div>
    </nav>
    <!-- <div class="container-fluid py-2">


      <div class="container mt-5">
        <h2 class="mb-4">Add New Task</h2>
        <form id="taskForm">
          <div class="mb-3">
            <label for="task_name" class="form-label">Task Name</label>
            <input
              type="text"
              class="form-control"
              id="task_name"
              name="task_name"
              required />
          </div>

          <div class="mb-3">
            <label for="task_description" class="form-label">Description</label>
            <textarea
              class="form-control"
              id="task_description"
              name="task_description"
              rows="3"
              required></textarea>
          </div>

          <div class="mb-3">
            <label for="assigned_user" class="form-label">Assign To</label>
            <select
              class="form-select"
              id="assigned_user"
              name="assigned_user"
              required>
              <option value="">Loading...</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="due_date" class="form-label">Due Date</label>
            <input
              type="date"
              class="form-control"
              id="due_date"
              name="due_date"
              required />
          </div>


          <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-select" id="category" name="category" required>
              <option value="1">Development</option>
              <option value="2">Testing & QA</option>
              <option value="3">Project Management</option>
              <option value="4">Maintenance & Support</option>
              <option value="5">Administrative & Miscellaneous</option>
            </select>
          </div>

          <button type="submit" class="btn btn-primary">Add Task</button>
        </form>

        <div id="responseMessage" class="mt-3"></div>
      </div>



    </div> -->

    <!-- <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3 mb-0">Add New Task</h6>
              </div>
            </div>
            <div class="card-body p-4">
              <form id="taskForm" class="mt-4">
                <div class="row">

                  <div class="col-md-12 mb-4">
                    <div class="input-group input-group-static">
                      <label class="ms-0 font-weight-bold text-dark">Task Name</label>
                      <input
                        type="text"
                        class="form-control ps-3"
                        placeholder="Enter task name"
                        style="border: 1px solid #d2d6da; border-radius: 0.375rem; padding: 0.75rem;"
                        required>
                    </div>
                  </div>


                  <div class="col-md-12 mb-4">
                    <div class="input-group input-group-static">
                      <label class="ms-0 font-weight-bold text-dark">Description</label>
                      <textarea
                        class="form-control ps-3"
                        rows="4"
                        placeholder="Enter task description"
                        style="border: 1px solid #d2d6da; border-radius: 0.375rem; padding: 0.75rem;"
                        required></textarea>
                    </div>
                  </div>

                  <div class="col-md-6 mb-4">
                    <div class="input-group input-group-static">
                      <label class="ms-0 font-weight-bold text-dark">Assign To</label>
                      <select
                        class="form-control ps-3"
                        style="border: 1px solid #d2d6da; border-radius: 0.375rem; padding: 0.75rem;"
                        required>
                        <option value="" disabled selected>Select team member</option>
                        <option value="1">User 1</option>
                        <option value="2">User 2</option>
                        <option value="3">User 3</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-6 mb-4">
                    <div class="input-group input-group-static">
                      <label class="ms-0 font-weight-bold text-dark">Due Date</label>
                      <input
                        type="date"
                        class="form-control ps-3"
                        style="border: 1px solid #d2d6da; border-radius: 0.375rem; padding: 0.75rem;"
                        required>
                    </div>
                  </div>


                  <div class="col-md-12 mb-4">
                    <div class="input-group input-group-static">
                      <label class="ms-0 font-weight-bold text-dark">Category</label>
                      <select
                        class="form-control ps-3"
                        style="border: 1px solid #d2d6da; border-radius: 0.375rem; padding: 0.75rem;"
                        required>
                        <option value="1">Development</option>
                        <option value="2">Testing & QA</option>
                        <option value="3">Project Management</option>
                        <option value="4">Maintenance & Support</option>
                        <option value="5">Administrative & Miscellaneous</option>
                      </select>
                    </div>
                  </div>
                </div>

           
                <div class="row mt-4">
                  <div class="col-12 text-center">
                    <button type="submit" class="btn bg-gradient-primary px-5 mb-0">
                      Add Task
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div> -->


    <div class="container-fluid py-4 px-4">
      <style>
        /* Professional Color Schemes - You can choose one */

        /* Option 1: Deep Blue Gradient */
        .bg-gradient-blue {
          background-image: linear-gradient(195deg, #49a3f1 0%, #1A73E8 100%);
        }

        .shadow-blue {
          box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(26, 115, 232, 0.4);
        }

        /* Option 2: Modern Green Gradient */
        .bg-gradient-green {
          background-image: linear-gradient(195deg, #66BB6A 0%, #43A047 100%);
        }

        .shadow-green {
          box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(76, 175, 80, 0.4);
        }

        /* Option 3: Professional Purple Gradient */
        .bg-gradient-purple {
          background-image: linear-gradient(195deg, #7c69ef 0%, #5e3bee 100%);
        }

        .shadow-purple {
          box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(94, 59, 238, 0.4);
        }

        /* Option 4: Elegant Dark Gradient */
        .bg-gradient-dark {
          background-image: linear-gradient(195deg, #42424a 0%, #191919 100%);
        }

        .shadow-dark {
          box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(25, 25, 25, 0.4);
        }
      </style>

      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">

              <div class="bg-gradient-blue shadow-blue border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3 mb-0">Add New Task</h6>
              </div>
            </div>
            <div class="card-body p-4">
              <form id="taskForm" class="mt-4">
                <div class="row">

                  <div class="col-md-12 mb-4">
                    <div class="input-group input-group-static">
                      <label class="ms-0 font-weight-bold text-dark">Task Name</label>
                      <input
                        id="task_name"
                        type="text"
                        class="form-control ps-3"
                        placeholder="Enter task name"
                        style="border: 1px solid #d2d6da; border-radius: 0.375rem; padding: 0.75rem;"
                        required>
                    </div>
                  </div>


                  <div class="col-md-12 mb-4">
                    <div class="input-group input-group-static">
                      <label class="ms-0 font-weight-bold text-dark">Description</label>
                      <textarea
                        id="task_description"
                        class="form-control ps-3"
                        rows="4"
                        placeholder="Enter task description"
                        style="border: 1px solid #d2d6da; border-radius: 0.375rem; padding: 0.75rem;"
                        required></textarea>
                    </div>
                  </div>


                  <div class="col-md-6 mb-4">
                    <div class="input-group input-group-static">
                      <label for="assigned_user" class="ms-0 font-weight-bold text-dark">Assign To</label>
                      <select id="assigned_user"
                        name="assigned_user"
                        class="form-select form-control ps-3 text-capitalize"
                        style="border: 1px solid #d2d6da; border-radius: 0.375rem; padding: 0.75rem;"
                        required>
                        <option value="">Loading...</option>

                      </select>
                    </div>
                  </div>




                  <div class="col-md-6 mb-4">
                    <div class="input-group input-group-static">
                      <label class="ms-0 font-weight-bold text-dark">Due Date</label>
                      <input
                        id="due_date"
                        type="date"
                        class="form-control ps-3"
                        style="border: 1px solid #d2d6da; border-radius: 0.375rem; padding: 0.75rem;"
                        required>
                    </div>
                  </div>


                  <div class="col-md-12 mb-4">
                    <div class="input-group input-group-static">
                      <label class="ms-0 font-weight-bold text-dark">Category</label>
                      <select
                        id="category"
                        class="form-control ps-3"
                        style="border: 1px solid #d2d6da; border-radius: 0.375rem; padding: 0.75rem;"
                        required>
                        <option value="1">Development</option>
                        <option value="2">Testing & QA</option>
                        <option value="3">Project Management</option>
                        <option value="4">Maintenance & Support</option>
                        <option value="5">Administrative & Miscellaneous</option>
                      </select>
                    </div>
                  </div>
                </div>


                <div class="row mt-4">
                  <div class="col-12 text-center">

                    <button type="submit" class="btn bg-gradient-blue px-5 mb-0 text-white">
                      Add Task
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>



  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>

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
  <!-- jQuery AJAX Script to Fetch Users -->

  <script src="../js/getUser.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>