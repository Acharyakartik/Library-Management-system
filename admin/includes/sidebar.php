<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="dashboard.php" class="brand-link">
    <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
      style="opacity: .8">
    <span class="brand-text font-weight-light">Library Admin</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">Admin</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <!-- Dashboard -->
        <li class="nav-item">
          <a href="dashboard.php" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <!-- Books -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
            <p>
              Books
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="add_book.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Book</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="manage_books.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>View Books</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="categories.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Categories</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Authors -->
        <!-- Authors -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-user-edit"></i>
            <p>
              Authors
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="add_author.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Author</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="manage_authors.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>View Authors</p>
              </a>
            </li>
          </ul>
        </li>


        <!-- Issue / Return -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-exchange-alt"></i>
            <p>
              Issue / Return
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="issue_book.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Issue Book</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="issued_books.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Issued Books</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="return_book.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Returned Books</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Users -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Users
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="students.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Students</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Reports -->
        <li class="nav-item">
          <a href="reports.php" class="nav-link">
            <i class="nav-icon fas fa-file-alt"></i>
            <p>Reports</p>
          </a>
        </li>

        <!-- Settings -->
        <li class="nav-item">
          <a href="settings.php" class="nav-link">
            <i class="nav-icon fas fa-cogs"></i>
            <p>Settings</p>
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>