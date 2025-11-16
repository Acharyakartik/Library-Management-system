<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['alogin'])==0){   
    header('location:index.php');
} else { 

    if(isset($_POST['create'])) {
        $category = $_POST['category'];
        $status = $_POST['status'];

        $sql = "INSERT INTO tblcategory(CategoryName,Status) VALUES(:category,:status)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':category',$category,PDO::PARAM_STR);
        $query->bindParam(':status',$status,PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();

        if($lastInsertId){
            $_SESSION['msg']="Category created successfully";
            header('location:manage-categories.php');
        } else {
            $_SESSION['error']="Something went wrong. Please try again";
            header('location:manage-categories.php');
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Category</title>
  <!-- AdminLTE & Bootstrap CSS -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <?php include("includes/header.php"); ?>
  <!-- /.navbar -->

  <!-- Main Sidebar -->
  <?php include("includes/sidebar.php"); ?>
  <!-- /.sidebar -->

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    
    <!-- Page Header -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Category</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main Content -->
    <section class="content">
      <div class="container-fluid">

        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">Category Info</h3>
          </div>

          <!-- Form -->
          <form role="form" method="post">
            <div class="card-body">

              <!-- Category Name -->
              <div class="form-group">
                <label for="category">Category Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="category" id="category" required autocomplete="off">
              </div>

              <!-- Status -->
              <div class="form-group">
                <label>Status</label><br>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="status" id="statusActive" value="1" checked>
                  <label class="form-check-label" for="statusActive">Active</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="status" id="statusInactive" value="0">
                  <label class="form-check-label" for="statusInactive">Inactive</label>
                </div>
              </div>

            </div>

            <!-- Submit -->
            <div class="card-footer text-center">
              <button type="submit" name="create" class="btn btn-info px-4">Create</button>
            </div>
          </form>
        </div>

      </div>
    </section>
  </div>
  <!-- /.content-wrapper -->

  <?php include("includes/footer.php"); ?>

</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>
<?php } ?>
