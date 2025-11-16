<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['alogin'])==0){   
    header('location:index.php');
} else { 

// Handle book return
if(isset($_GET['rid'])){
    $rid = intval($_GET['rid']);
    $returndate = date('Y-m-d');
    $sql = "UPDATE tblissuedbookdetails SET ReturnDate=:returndate WHERE id=:rid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':returndate', $returndate, PDO::PARAM_STR);
    $query->bindParam(':rid', $rid, PDO::PARAM_STR);
    if($query->execute()){
        $_SESSION['msg'] = "Book returned successfully";
        header('location:return_book.php');
        exit;
    } else {
        $_SESSION['error'] = "Something went wrong. Please try again";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Return Books</title>
  <!-- AdminLTE & Bootstrap CSS -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <?php include('includes/header.php'); ?>

  <!-- Sidebar -->
  <?php include('includes/sidebar.php'); ?>

  <!-- Content Wrapper -->
  <div class="content-wrapper">

    <!-- Page Header -->
    <section class="content-header">
      <div class="container-fluid">
        <h1>Return Books</h1>
      </div>
    </section>

    <!-- Main Content -->
    <section class="content">
      <div class="container-fluid">

        <!-- Alerts -->
        <?php if($_SESSION['error']!=""){ ?>
        <div class="alert alert-danger alert-dismissible fade show">
          <strong>Error:</strong> <?php echo htmlentities($_SESSION['error']); $_SESSION['error']=""; ?>
          <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <?php if($_SESSION['msg']!=""){ ?>
        <div class="alert alert-success alert-dismissible fade show">
          <strong>Success:</strong> <?php echo htmlentities($_SESSION['msg']); $_SESSION['msg']=""; ?>
          <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>

        <!-- Return Books Table Card -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Issued Books</h3>
          </div>
          <div class="card-body">
            <table id="returnBooksTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Student Name</th>
                  <th>Book Name</th>
                  <th>ISBN</th>
                  <th>Issued Date</th>
                  <th>Return Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $sql = "SELECT tblstudents.FullName, tblbooks.BookName, tblbooks.ISBNNumber,
                        tblissuedbookdetails.IssuesDate, tblissuedbookdetails.ReturnDate,
                        tblissuedbookdetails.id as rid 
                        FROM tblissuedbookdetails 
                        JOIN tblstudents ON tblstudents.StudentId=tblissuedbookdetails.StudentId 
                        JOIN tblbooks ON tblbooks.id=tblissuedbookdetails.BookId 
                        ORDER BY tblissuedbookdetails.id DESC";
                $query = $dbh->prepare($sql);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                $cnt = 1;
                if($query->rowCount() > 0){
                  foreach($results as $result){ ?>
                  <tr>
                    <td><?php echo htmlentities($cnt); ?></td>
                    <td><?php echo htmlentities($result->FullName); ?></td>
                    <td><?php echo htmlentities($result->BookName); ?></td>
                    <td><?php echo htmlentities($result->ISBNNumber); ?></td>
                    <td><?php echo htmlentities($result->IssuesDate); ?></td>
                    <td><?php echo ($result->ReturnDate=="") ? "Not Returned Yet" : htmlentities($result->ReturnDate); ?></td>
                    <td>
                      <?php if($result->ReturnDate==""){ ?>
                      <a href="return_book.php?rid=<?php echo htmlentities($result->rid); ?>" 
                         class="btn btn-success btn-sm" 
                         onclick="return confirm('Are you sure you want to mark this book as returned?');">
                        <i class="fas fa-undo"></i> Return
                      </a>
                      <?php } else { echo "<span class='text-success'>Returned</span>"; } ?>
                    </td>
                  </tr>
                <?php $cnt++; }} ?>
              </tbody>
              <tfoot>
                <tr>
                  <th>#</th>
                  <th>Student Name</th>
                  <th>Book Name</th>
                  <th>ISBN</th>
                  <th>Issued Date</th>
                  <th>Return Date</th>
                  <th>Action</th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>

      </div>
    </section>

  </div>

  <!-- Footer -->
  <?php include('includes/footer.php'); ?>

</div>

<!-- REQUIRED SCRIPTS -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>

<script>
$(document).ready(function() {
  $("#returnBooksTable").DataTable({
    "responsive": true,
    "autoWidth": false,
  });
});
</script>

</body>
</html>
<?php } ?>
