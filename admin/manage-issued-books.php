<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Manage Issued Books</title>
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

        <!-- Sidebar -->
        <?php include("includes/sidebar.php"); ?>
        <!-- /.sidebar -->

        <!-- Content Wrapper -->
        <div class="content-wrapper">

            <!-- Page Header -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Manage Issued Books</h1>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <?php if (!empty($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?php echo htmlentities($_SESSION['error']);
                            unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($_SESSION['msg'])): ?>
                        <div class="alert alert-success">
                            <?php echo htmlentities($_SESSION['msg']);
                            unset($_SESSION['msg']); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($_SESSION['delmsg'])): ?>
                        <div class="alert alert-success">
                            <?php echo htmlentities($_SESSION['delmsg']);
                            unset($_SESSION['delmsg']); ?>
                        </div>
                    <?php endif; ?>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Issued Books List</h3>
                        </div>
                        <div class="card-body">
                            <table id="issuedBooksTable" class="table table-bordered table-striped">
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
                                        JOIN tblstudents ON tblstudents.StudentId = tblissuedbookdetails.StudentId 
                                        JOIN tblbooks ON tblbooks.id = tblissuedbookdetails.BookId 
                                        ORDER BY tblissuedbookdetails.id DESC";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                $cnt = 1;
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $result) { ?>
                                        <tr>
                                            <td><?php echo htmlentities($cnt); ?></td>
                                            <td><?php echo htmlentities($result->FullName); ?></td>
                                            <td><?php echo htmlentities($result->BookName); ?></td>
                                            <td><?php echo htmlentities($result->ISBNNumber); ?></td>
                                            <td><?php echo htmlentities($result->IssuesDate); ?></td>
                                            <td>
                                                <?php echo $result->ReturnDate == "" ? "Not Returned Yet" : htmlentities($result->ReturnDate); ?>
                                            </td>
                                            <td>
                                                <a href="update-issue-bookdeails.php?rid=<?php echo htmlentities($result->rid); ?>"
                                                   class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                            </td>
                                        </tr>
                                        <?php $cnt++;
                                    }
                                } ?>
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
            $("#issuedBooksTable").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
        });
    </script>
    </body>
    </html>
<?php } ?>
