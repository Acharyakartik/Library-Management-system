<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['alogin'])==0){   
    header('location:index.php');
} else { 

    // Delete book
    if(isset($_GET['del'])) {
        $id=$_GET['del'];
        $sql = "DELETE FROM tblbooks WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        $_SESSION['delmsg']="Book deleted successfully";
        header('location:manage-books.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Books</title>
  <!-- AdminLTE & Bootstrap CSS -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
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
            <h1>Manage Books</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Books Listing</h3>
            <a href="add_book.php">
              <button class="btn btn-primary float-right">Add New Book</button>
            </a>
          </div>
          <!-- /.card-header -->

          <div class="card-body">
            <table id="booksTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Book Name</th>
                  <th>Category</th>
                  <th>Author</th>
                  <th>ISBN</th>
                  <th>Price</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $sql = "SELECT tblbooks.BookName, tblcategory.CategoryName, tblauthors.AuthorName, tblbooks.ISBNNumber, tblbooks.BookPrice, tblbooks.id as bookid, tblbooks.bookImage 
                        FROM tblbooks 
                        JOIN tblcategory ON tblcategory.id=tblbooks.CatId 
                        JOIN tblauthors ON tblauthors.id=tblbooks.AuthorId";
                $query = $dbh->prepare($sql);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                $cnt = 1;
                if($query->rowCount() > 0){
                    foreach($results as $result){ ?>
                      <tr>
                        <td><?php echo htmlentities($cnt);?></td>
                        <td>
                          <img src="bookimg/<?php echo htmlentities($result->bookImage);?>" width="100" class="mb-2"><br>
                          <b><?php echo htmlentities($result->BookName);?></b>
                        </td>
                        <td><?php echo htmlentities($result->CategoryName);?></td>
                        <td><?php echo htmlentities($result->AuthorName);?></td>
                        <td><?php echo htmlentities($result->ISBNNumber);?></td>
                        <td><?php echo htmlentities($result->BookPrice);?></td>
                        <td>
                          <a href="edit-book.php?bookid=<?php echo htmlentities($result->bookid);?>" class="btn btn-primary btn-sm mb-1">
                            <i class="fas fa-edit"></i> Edit
                          </a>
                          <a href="manage-books.php?del=<?php echo htmlentities($result->bookid);?>" onclick="return confirm('Are you sure you want to delete?');" class="btn btn-danger btn-sm mb-1">
                            <i class="fas fa-trash"></i> Delete
                          </a>
                        </td>
                      </tr>
                <?php $cnt++; }} ?>
              </tbody>
              <tfoot>
                <tr>
                  <th>#</th>
                  <th>Book Name</th>
                  <th>Category</th>
                  <th>Author</th>
                  <th>ISBN</th>
                  <th>Price</th>
                  <th>Action</th>
                </tr>
              </tfoot>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
      </div>
    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->

  <?php include("includes/footer.php"); ?>

</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>

<script>
$(function () {
    $("#booksTable").DataTable({
        "responsive": true,
        "autoWidth": false,
        "order": [[0, "asc"]]
    });
});
</script>

</body>
</html>
<?php } ?>
