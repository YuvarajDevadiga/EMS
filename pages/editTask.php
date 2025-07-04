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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">


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
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

    <nav
      class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl "
      id="navbarBlur"
      data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <a class="d-flex justify-content-between align-items-center gap-2" href="./dashboard.php"
            class="navbar-brand px-4 py-3 m-0">
            <img
              src="https://e7.pngegg.com/pngimages/553/134/png-clipart-employee-engagement-human-resource-management-organization-teamwork-miscellaneous-company.png"
              class="navbar-brand-img rounded-pill"
              width="30"
              height="30"
              alt="main_logo" />
            <span class="ms-1 text-lg text-dark fw-bold  ">ETMS</span>
          </a>
        </nav>
        <div
          class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4 d-flex justify-content-end"
          id="navbar">
          <!-- <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group input-group-outline">
              <label class="form-label">Type here...</label>
              <input type="text" class="form-control" />
            </div>
          </div> -->
          <ul
            class="navbar-nav d-flex align-items-center justify-content-end">

            <li class="mt-1">
              <a
                class="github-button text-lowercase text-capitalize"
                href="https://github.com/creativetimofficial/material-dashboard"
                data-icon="octicon-star"
                data-size="small"
                data-show-count="false"
                aria-label="Star creativetimofficial/material-dashboard on GitHub"><?php echo strtolower($_SESSION['name']) ?></a>
            </li>


          </ul>
        </div>
      </div>
    </nav>

    <!-- <div class="container mt-5">
      <h2 class="mb-4">Edit Task</h2>
      <form id="editTaskForm">
        <input type="hidden" id="task_id" name="task_id" />

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
            <option value="0">Loading...</option>
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

        <button type="submit" class="btn btn-primary">Update Task</button>
      </form>

      <div id="responseMessage" class="mt-3"></div>
    </div> -->

    <!-- <div class="container-fluid py-4 px-4">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-info shadow-info border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Edit Task</h6>
              </div>
            </div>
            <div class="card-body px-4 pb-2">
              <form id="editTaskForm">
                <input type="hidden" id="task_id" name="task_id" />

                <div class="input-group input-group-static mb-4 text-capitalize">
                  <label>Task Name</label>
                  <input
                    type="text"
                    class="form-control "
                    id="task_name"
                    name="task_name"
                    required />
                </div>

                <div class="input-group input-group-static mb-4 text-capitalize">
                  <label>Description</label>
                  <textarea
                    class="form-control "
                    id="task_description"
                    name="task_description"
                    rows="3"
                    required></textarea>
                </div>

                <div class="input-group input-group-static mb-4">
                  <label>Assign To</label>
                  <select
                    class="form-control text-capitalize"
                    id="assigned_user"
                    name="assigned_user"
                    required>
                    <option value="0">Loading...</option>
                  </select>
                </div>

                <div class="input-group input-group-static mb-4">
                  <label>Due Date</label>
                  <input
                    type="date"
                    class="form-control"
                    id="due_date"
                    name="due_date"
                    required />
                </div>

                <div class="input-group input-group-static mb-4">
                  <label>Category</label>
                  <select class="form-control" id="category" name="category" required>
                    <option value="1">Development</option>
                    <option value="2">Testing & QA</option>
                    <option value="3">Project Management</option>
                    <option value="4">Maintenance & Support</option>
                    <option value="5">Administrative & Miscellaneous</option>
                  </select>
                </div>

                <button type="submit" class="btn bg-gradient-info">Update Task</button>
              </form>

              <div id="responseMessage" class="mt-3"></div>
            </div>
          </div>
        </div>
      </div>
    </div> -->

    <div class="container-fluid py-4 px-4">
      <div class="row justify-content-center">
        <div class="col-11">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-info shadow-info border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Edit Task</h6>
              </div>
            </div>
            <div class="card-body px-4 pb-2">
              <form id="editTaskForm">
                <input type="hidden" id="task_id" name="task_id" />
                <div class="input-group input-group-static mb-4 text-capitalize">
                  <label>Task Name</label>
                  <input type="text" class="form-control" id="task_name" name="task_name" required />
                </div>
                <div class="input-group input-group-static mb-4 text-capitalize">
                  <label>Description</label>
                  <textarea class="form-control" id="task_description" name="task_description" rows="3" required></textarea>
                </div>

                <!-- Three fields in one row -->
                <div class="row mb-4">
                  <div class="col-md-4">
                    <div class="input-group input-group-static">
                      <label>Category</label>
                      <select class="form-control py-2 " id="category" name="category" required>
                        <option value="1">Development</option>
                        <option value="2">Testing & QA</option>
                        <option value="3">Project Management</option>
                        <option value="4">Maintenance & Support</option>
                        <option value="5">Administrative & Miscellaneous</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="input-group input-group-static">
                      <label>Assign To</label>
                      <select class="form-control py-2" id="assigned_user" name="assigned_user" required>
                        <option value="0">Loading...</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="input-group input-group-static">
                      <label>Due Date</label>
                      <input type="date" class="form-control py-2 cursor-pointer" id="due_date" name="due_date" required style="cursor: pointer; background-color: transparent;" />
                    </div>
                  </div>
                </div>

                <button type="submit" class="btn bg-gradient-info">Update Task</button>
              </form>
              <div id="responseMessage" class="mt-3"></div>
            </div>
          </div>
        </div>
      </div>
    </div>



  </main>

  <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script src="../js/editTask.js"></script>
  <script src="../js/getUser.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>


<!-- <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
              <h2 class="mb-0 fs-4">Edit Task</h2>
            </div>
            <div class="card-body p-4">
              <form id="editTaskForm">
                <input type="hidden" id="task_id" name="task_id" />

                <div class="mb-3">
                  <label for="task_name" class="form-label fw-semibold">Task Name</label>
                  <input
                    type="text"
                    class="form-control shadow-sm"
                    id="task_name"
                    name="task_name"
                    required />
                </div>

                <div class="mb-3">
                  <label for="task_description" class="form-label fw-semibold">Description</label>
                  <textarea
                    class="form-control shadow-sm"
                    id="task_description"
                    name="task_description"
                    rows="3"
                    required></textarea>
                </div>

                <div class="mb-3">
                  <label for="assigned_user" class="form-label fw-semibold">Assign To</label>
                  <select
                    class="form-select shadow-sm"
                    id="assigned_user"
                    name="assigned_user"
                    required>
                    <option value="0">Loading...</option>
                  </select>
                </div>

                <div class="mb-3">
                  <label for="due_date" class="form-label fw-semibold">Due Date</label>
                  <input
                    type="date"
                    class="form-control shadow-sm"
                    id="due_date"
                    name="due_date"
                    required />
                </div>

                <div class="mb-3">
                  <label for="category" class="form-label fw-semibold">Category</label>
                  <select class="form-select shadow-sm" id="category" name="category" required>
                    <option value="1">Development</option>
                    <option value="2">Testing & QA</option>
                    <option value="3">Project Management</option>
                    <option value="4">Maintenance & Support</option>
                    <option value="5">Administrative & Miscellaneous</option>
                  </select>
                </div>

                <div class="d-grid">
                  <button type="submit" class="btn btn-primary btn-lg shadow-sm">Update Task</button>
                </div>
              </form>

              <div id="responseMessage" class="mt-3"></div>
            </div>
          </div>
        </div>
      </div>
    </div> -->