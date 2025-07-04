<?php
session_start();

if (!isset($_SESSION['role'])) {
  header("Location: sign-in.html");
  exit();
}
// if (!($_SESSION['role'] == 'manager')) {
//   header("Location: sign-in.html");
//   exit();
// }
// echo $_SESSION['role'];

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Keep your existing head content -->
  <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.3/main.min.css' rel='stylesheet' />
  <link href="../assets/css/custom-calendar.css" rel="stylesheet" />
  <title>Task Management System | Calendar View</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">




</head>

<body class="g-sidenav-show bg-gray-100" id="calbody" data-role=<?php echo $_SESSION['role'] ?>>
  <nav
    class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl overflow-y-hidden  "
    id="navbarBlur"
    data-scroll="true">
    <div class="container-fluid py-1 px-3">
      <nav aria-label="breadcrumb">
        <div class="d-flex justify-content-between align-items-center gap-2"
          class="navbar-brand px-4 py-3 m-0">
          <a href="<?php if ($_SESSION['role'] == 'manager') echo "./dashboard.php";
                    else echo "./employeeDashboard.php" ?>"
            class="navbar-brand px-4 py-3 m-0">
            <img
              src="https://e7.pngegg.com/pngimages/553/134/png-clipart-employee-engagement-human-resource-management-organization-teamwork-miscellaneous-company.png"
              class="navbar-brand-img rounded-pill"
              width="30"
              height="30"
              alt="main_logo" />
            <span class="ms-1 text-lg text-dark">ETMS</span>
          </a>
        </div>
      </nav>
      <div
        class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4 d-flex justify-content-end"
        id="navbar">

        <ul
          class="navbar-nav d-flex align-items-center justify-content-end ">


          <li class="mt-1 me-2">
            <a style="text-decoration: none; color:black;"
              class="github-button text-capitalize text-lg"
              href="https://github.com/creativetimofficial/material-dashboard"
              data-icon="octicon-star"
              data-size="large"
              data-show-count="false"
              aria-label="Star creativetimofficial/material-dashboard on GitHub"><?php echo $_SESSION['name'] ?></a>
          </li>

          <!-- <button id="logout-btn" class="nav-link text-white border-0 bg-danger d-flex align-items-center px-2 py-1 rounded">
            <span class="nav-link-text ms-1 text-sm">Log Out</span>
          </button> -->
        </ul>
      </div>
    </div>
  </nav>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <!-- Keep your existing navbar -->


    <div class="container-fluid py-2">
      <div class="row d-flex justify-content-center">
        <div class="col-11">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2" style="background-color: #1E2B37;">
              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                <h2 class="text-white text-capitalize ps-3 "><?php
                                                              if ($_SESSION['role'] == "manager") echo "Task Calendar";
                                                              else echo "My Calendar";
                                                              ?>

                </h2>
              </div>
            </div>
            <div class="card-body px-4 pb-2">
              <!-- Filters Section -->
              <div class="row mb-4">
                <div class="col-md-3 ">
                  <label class="form-label">Category Filter</label>
                  <select id="categoryFilter" class="form-select">
                    <option value="">All Categories</option>
                  </select>
                </div>

                <div class="col-md-3" <?php echo ($_SESSION['role'] == 'manager') ? '' : 'style="display:none;"'; ?>>
                  <label class="form-label">User Filter</label>
                  <select id="userFilter" class="form-select">
                    <option value="">All Users</option>

                  </select>
                </div>

              </div>

              <!-- Calendar Container -->
              <div class="text-black" id="calendar"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Task Details Modal -->
    <!-- <div class="modal fade" id="taskDetailsModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tasks for <span id="selectedDate"></span></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <?php echo ($_SESSION['role'] == 'manager') ? '<th>Assigned To</th>' : null; ?>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody id="dayTasksList"></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div> -->

    <!-- Task Details Modal -->
    <div class="modal fade" id="taskDetailsModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Category</th>
                    <?php echo ($_SESSION['role'] == 'manager') ? '<th>Assigned To</th>' : ''; ?>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody id="dayTasksList"></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.3/main.min.js'></script>
  <!-- jQuery (Latest version) -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>

  <!-- Your existing scripts -->
  <script src="../js/script.js"></script>

  <script src="../js/calendar.js"></script>
</body>

</html>