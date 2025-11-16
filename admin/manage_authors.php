<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
    exit();
} else {

    // Delete author
    if (isset($_GET['del'])) {
        $id = intval($_GET['del']);
        $sql = "DELETE FROM tblauthors WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        $_SESSION['delmsg'] = "Author deleted successfully";
        header('location:manage_authors.php');
        exit();
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Manage Authors</title>
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
        <!-- Sidebar -->
        <?php include("includes/sidebar.php"); ?>

        <!-- Content Wrapper -->
        <div class="content-wrapper">

            <!-- Page Header -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Manage Authors</h1>
                        </div>
                        <div class="col-sm-6">
                            <a href="add_author.php" class="btn btn-primary float-right">Add New Author</a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <?php if (!empty($_SESSION['msg'])): ?>
                        <div class="alert alert-success"><?php echo htmlentities($_SESSION['msg']); unset($_SESSION['msg']); ?></div>
                    <?php endif; ?>
                    <?php if (!empty($_SESSION['error'])): ?>
                        <div class="alert alert-danger"><?php echo htmlentities($_SESSION['error']); unset($_SESSION['error']); ?></div>
                    <?php endif; ?>
                    <?php if (!empty($_SESSION['delmsg'])): ?>
                        <div class="alert alert-success"><?php echo htmlentities($_SESSION['delmsg']); unset($_SESSION['delmsg']); ?></div>
                    <?php endif; ?>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Authors Listing</h3>
                        </div>
                        <div class="card-body">
                            <table id="authorsTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Author Name</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sql = "SELECT * FROM tblauthors ORDER BY id DESC";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                $cnt = 1;
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $result) { ?>
                                        <tr>
                                            <td><?php echo htmlentities($cnt); ?></td>
                                            <td><?php echo htmlentities($result->AuthorName); ?></td>
                                            <td>
                                                <!-- <a href="edit_author.php?id=<?php echo htmlentities($result->id); ?>" class="btn btn-primary btn-sm mb-1">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a> -->
                                                <a href="manage_authors.php?del=<?php echo htmlentities($result->id); ?>" onclick="return confirm('Are you sure you want to delete this author?');" class="btn btn-danger btn-sm mb-1">
                                                    <i class="fas fa-trash"></i> Delete
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
                                    <th>Author Name</th>
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
            $("#authorsTable").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
        });
    </script>
    </body>
    </html>
<?php } ?>
