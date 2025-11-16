<?php
session_start();
error_reporting(0);
include('includes/config.php'); // Your PDO connection

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
    exit();
}

if (isset($_POST['create'])) {
    $authorname = $_POST['authorname'];

    $sql = "INSERT INTO tblauthors(AuthorName) VALUES(:authorname)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':authorname', $authorname, PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();

    if ($lastInsertId) {
        $_SESSION['msg'] = "Author added successfully";
        header('location:manage_authors.php');
        exit();
    } else {
        $_SESSION['error'] = "Something went wrong. Please try again";
        header('location:add_author.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Author</title>
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <?php include("includes/header.php"); ?>

        <!-- Sidebar -->
        <?php include("includes/sidebar.php"); ?>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid mb-3">
                    <h1>Add New Author</h1>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <?php
                    if (!empty($_SESSION['msg'])) {
                        echo '<div class="alert alert-success">' . htmlentities($_SESSION['msg']) . '</div>';
                        unset($_SESSION['msg']); // better than setting empty
                    }

                    if (!empty($_SESSION['error'])) {
                        echo '<div class="alert alert-danger">' . htmlentities($_SESSION['error']) . '</div>';
                        unset($_SESSION['error']);
                    }
                    ?>


                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Author Info</h3>
                        </div>
                        <div class="card-body">
                            <form method="post" role="form">
                                <div class="form-group">
                                    <label for="authorname">Author Name <span class="text-danger">*</span></label>
                                    <input type="text" name="authorname" id="authorname" class="form-control" required>
                                </div>

                                <div class="text-center">
                                    <button type="submit" name="create" class="btn btn-info">Add Author</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </section>
        </div>

        <?php include("includes/footer.php"); ?>

    </div>

    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>
</body>

</html>