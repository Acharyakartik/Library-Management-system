<?php
session_start();
include('includes/config.php');

if(strlen($_SESSION['alogin'])==0){   
    header('location:index.php');
    exit();
}

// Delete student
if(isset($_GET['del'])){
    $id = $_GET['del'];
    $sql = "DELETE FROM tblstudents WHERE id=:id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    header('location:manage_students.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin | Manage Students</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Font Awesome -->
    <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <?php include('includes/header.php'); ?>

    <!-- Sidebar -->
    <?php include('includes/sidebar.php'); ?>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1 class="mt-3 mb-3">Manage Students</h1>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                <?php if(!empty($_SESSION['msg'])): ?>
                    <div class="alert alert-success"><?php echo htmlentities($_SESSION['msg']); unset($_SESSION['msg']); ?></div>
                <?php endif; ?>
                <?php if(!empty($_SESSION['error'])): ?>
                    <div class="alert alert-danger"><?php echo htmlentities($_SESSION['error']); unset($_SESSION['error']); ?></div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Students List</h3>
                    </div>
                    <div class="card-body">
                        <table id="studentsTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Student ID</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Mobile Number</th>
                                    <th>Status</th>
                                    <th>Registration Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sql = "SELECT * FROM tblstudents ORDER BY id DESC";
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            $cnt = 1;

                            if($query->rowCount() > 0){
                                foreach($results as $result){
                            ?>
                                <tr>
                                    <td><?php echo htmlentities($cnt); ?></td>
                                    <td><?php echo htmlentities($result->StudentId); ?></td>
                                    <td><?php echo htmlentities($result->FullName); ?></td>
                                    <td><?php echo htmlentities($result->EmailId); ?></td>
                                    <td><?php echo htmlentities($result->MobileNumber); ?></td>
                                    <td>
                                        <?php echo ($result->Status==1) ? '<span class="text-success">Active</span>' : '<span class="text-danger">Inactive</span>'; ?>
                                    </td>
                                    <td><?php echo htmlentities($result->RegDate); ?></td>
                                </tr>
                            <?php $cnt++; } } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Student ID</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Mobile Number</th>
                                    <th>Status</th>
                                    <th>Registration Date</th>
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

<!-- Scripts -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>

<script>
$(function () {
    $("#studentsTable").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
});
</script>
</body>
</html>
