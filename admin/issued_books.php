<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
}
else{
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Issued Books & Availability</title>
    <!-- AdminLTE & Bootstrap CSS -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
    <style>
        .book-card {
            min-height: 350px;
            margin-bottom: 20px;
        }
        .book-image {
            width: 100px;
            height: auto;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <?php include("includes/header.php"); ?>
    <!-- Sidebar -->
    <?php include("includes/sidebar.php"); ?>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Page Header -->
        <section class="content-header">
            <div class="container-fluid mb-3">
                <h1>Issued Books & Availability</h1>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">

                    <?php
                    $sql = "SELECT tblbooks.BookName,
                                   tblcategory.CategoryName,
                                   tblauthors.AuthorName,
                                   tblbooks.ISBNNumber,
                                   tblbooks.BookPrice,
                                   tblbooks.id as bookid,
                                   tblbooks.bookImage,
                                   tblbooks.isIssued,
                                   tblbooks.bookQty,
                                   COUNT(tblissuedbookdetails.id) AS issuedBooks,
                                   COUNT(tblissuedbookdetails.RetrunStatus) AS returnedbook
                            FROM tblbooks
                            LEFT JOIN tblissuedbookdetails ON tblissuedbookdetails.BookId = tblbooks.id
                            LEFT JOIN tblauthors ON tblauthors.id = tblbooks.AuthorId
                            LEFT JOIN tblcategory ON tblcategory.id=tblbooks.CatId
                            GROUP BY tblbooks.id";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                    if ($query->rowCount() > 0) {
                        foreach ($results as $result) {
                            $availableQty = ($result->issuedBooks == 0)
                                ? $result->bookQty
                                : $result->bookQty - ($result->issuedBooks - $result->returnedbook);
                            ?>

                            <div class="col-md-4">
                                <div class="card book-card">
                                    <div class="card-body text-center">
                                        <!-- Book Image -->
                                        <?php if (!empty($result->bookImage)) { ?>
                                            <img src="bookimg/<?php echo htmlentities($result->bookImage); ?>"
                                                 class="book-image img-thumbnail" alt="Book Image">
                                        <?php } else { ?>
                                            <span class="text-muted">No Image</span>
                                        <?php } ?>

                                        <!-- Book Info Table -->
                                        <table class="table table-sm mt-2">
                                            <tr>
                                                <th>Book Name</th>
                                                <td><?php echo htmlentities($result->BookName); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Author</th>
                                                <td><?php echo htmlentities($result->AuthorName); ?></td>
                                            </tr>
                                            <tr>
                                                <th>ISBN</th>
                                                <td><?php echo htmlentities($result->ISBNNumber); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Total Quantity</th>
                                                <td><?php echo htmlentities($result->bookQty); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Available</th>
                                                <td><span class="badge badge-success"><?php echo htmlentities($availableQty); ?></span></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        <?php }
                    } else { ?>
                        <div class="col-12">
                            <div class="alert alert-info text-center">No books found.</div>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </section>
    </div>

    <?php include("includes/footer.php"); ?>
</div>

<!-- REQUIRED SCRIPTS -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
<?php } ?>