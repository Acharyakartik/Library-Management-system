<?php
session_start();
error_reporting(0);
include('includes/config.php');
// include('includes/base.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {

    if (isset($_POST['issue'])) {
        $studentid = strtoupper($_POST['studentid']);
        $bookid = $_POST['bookid'];
        $aremark = $_POST['aremark'];
        $isissued = 1;
        $aqty = $_POST['aqty'];

        if ($aqty > 0) {
            $sql = "INSERT INTO tblissuedbookdetails(StudentID,BookId,remark) 
                    VALUES(:studentid,:bookid,:aremark)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':studentid', $studentid, PDO::PARAM_STR);
            $query->bindParam(':bookid', $bookid, PDO::PARAM_STR);
            $query->bindParam(':aremark', $aremark, PDO::PARAM_STR);
            $query->execute();
            $lastInsertId = $dbh->lastInsertId();

            if ($lastInsertId) {
                $_SESSION['msg'] = "Book issued successfully";
                header('location:manage-issued-books.php');
            } else {
                $_SESSION['error'] = "Something went wrong. Please try again";
                header('location:manage-issued-books.php');
            }
        } else {
            $_SESSION['error'] = "Book Not available";
            header('location:manage-issued-books.php');
        }
    }
}
?>

<!-- Custom JS -->
<script>
    function getstudent() {
        $("#loaderIcon").show();
        jQuery.ajax({
            url: "get_student.php",
            data: 'studentid=' + $("#studentid").val(),
            type: "POST",
            success: function (data) {
                $("#get_student_name").html(data);
                $("#loaderIcon").hide();
            },
            error: function () { }
        });
    }

    function getbook() {
        $("#loaderIcon").show();
        jQuery.ajax({
            url: "get_book.php",
            data: 'bookid=' + $("#bookid").val(),
            type: "POST",
            success: function (data) {
                $("#get_book_name").html(data);
                $("#loaderIcon").hide();
            },
            error: function () { }
        });
    }
</script>

<style>
    .others { color: red; }
</style>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <?php include("includes/header.php"); ?>
  <?php include("includes/style.php"); ?>

  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include("includes/sidebar.php"); ?>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    
    <!-- Page Header -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Issue a New Book</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main Content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">Book Issue Info</h3>
          </div>

          <!-- Form Start -->
          <form role="form" method="post">
            <div class="card-body">
              <div class="row">

                <!-- Student ID -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="studentid">Student ID <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" 
                           name="studentid" id="studentid"
                           onBlur="getstudent()" autocomplete="off" required>
                    <div class="mt-2 text-primary font-weight-bold" id="get_student_name"></div>
                  </div>
                </div>

                <!-- Book ID -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="bookid">ISBN Number or Book Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" 
                           name="bookid" id="bookid"
                           onBlur="getbook()" required>
                    <div class="mt-2" id="get_book_name"></div>
                  </div>
                </div>

                <!-- Remark -->
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="aremark">Remark <span class="text-danger">*</span></label>
                    <textarea class="form-control" 
                              name="aremark" id="aremark" 
                              rows="3" required></textarea>
                  </div>
                </div>

              </div>
            </div>

            <!-- Submit -->
            <div class="card-footer text-center">
              <button type="submit" name="issue" id="submit" class="btn btn-info px-4">
                Issue Book
              </button>
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
