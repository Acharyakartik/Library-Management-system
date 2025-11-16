<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {

    if (isset($_POST['add'])) {
        $bookname   = $_POST['bookname'];
        $category   = $_POST['category'];
        $author     = $_POST['author'];
        $isbn       = $_POST['isbn'];
        $price      = $_POST['price'];
        $quantity   = $_POST['quantity'];

        // Handle Image Upload
        $imgfile = $_FILES["bookimage"]["name"];
        $extension = substr($imgfile, strlen($imgfile) - 4, strlen($imgfile));
        $allowed_extensions = array(".jpg", "jpeg", ".png", ".gif");

        if (!in_array($extension, $allowed_extensions)) {
            $_SESSION['error'] = "Invalid format. Only jpg / jpeg / png / gif allowed";
            header('location:add_book.php');
        } else {
            // Rename image to unique name
            $imgnewfile = md5($imgfile . time()) . $extension;
            move_uploaded_file($_FILES["bookimage"]["tmp_name"], "bookimg/" . $imgnewfile);

            // Insert into DB
            $sql = "INSERT INTO tblbooks(BookName, CatId, AuthorId, ISBNNumber, BookPrice, bookImage, bookQty) 
                    VALUES(:bookname, :catid, :authorid, :isbn, :price, :bookimage, :qty)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':bookname', $bookname, PDO::PARAM_STR);
            $query->bindParam(':catid', $category, PDO::PARAM_INT);
            $query->bindParam(':authorid', $author, PDO::PARAM_INT);
            $query->bindParam(':isbn', $isbn, PDO::PARAM_STR);
            $query->bindParam(':price', $price);
            $query->bindParam(':bookimage', $imgnewfile, PDO::PARAM_STR);
            $query->bindParam(':qty', $quantity, PDO::PARAM_INT);
            $query->execute();

            $_SESSION['msg'] = "Book added successfully";
            header('location:manage_books.php');
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Add New Book</title>
        <!-- AdminLTE & Bootstrap CSS -->
        <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
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
                            <h1>Add New Book</h1>
                        </div>
                        <div class="col-sm-6">
                            <a href="manage_books.php" class="btn btn-secondary float-right">Back to Books</a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <?php if (!empty($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?php echo htmlentities($_SESSION['error']); unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Book Information</h3>
                        </div>
                        <form method="post" enctype="multipart/form-data">
                            <div class="card-body">

                                <div class="form-group">
                                    <label>Book Title</label>
                                    <input type="text" name="bookname" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Category</label>
                                    <select name="category" class="form-control" required>
                                        <option value="">Select Category</option>
                                        <?php
                                        $sql = "SELECT * FROM tblcategory WHERE Status=1";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        foreach ($results as $result) {
                                            echo "<option value='" . $result->id . "'>" . $result->CategoryName . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Author</label>
                                    <select name="author" class="form-control" required>
                                        <option value="">Select Author</option>
                                        <?php
                                        $sql = "SELECT * FROM tblauthors";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        foreach ($results as $result) {
                                            echo "<option value='" . $result->id . "'>" . $result->AuthorName . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>ISBN Number</label>
                                    <input type="text" name="isbn" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Book Price</label>
                                    <input type="text" name="price" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input type="number" name="quantity" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Book Image</label>
                                    <input type="file" name="bookimage" class="form-control" required>
                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="submit" name="add" class="btn btn-primary">Add Book</button>
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
