<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | User Data</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css"> 
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <?php include "navbar.php"; ?>
  <?php include "sidebar.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>User Data</h1>
          </div>
          <div class="col-sm-6">
            
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Akun Master</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="userTable" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Email</th>
                      <th>Username</th>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Created At</th>
                      <th>Updated At</th>
                      <th>Verified</th>
                      <th>Role</th>
                      <th>Children</th>
                      <th>Devices</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $json = file_get_contents('http://165.22.101.164:8000/api/masters');
                    $data = json_decode($json, true);
                    foreach ($data['data'] as $user) {
                      echo '<tr>';
                      echo '<td>' . $user['id'] . '</td>';
                      echo '<td>' . $user['email'] . '</td>';
                      echo '<td>' . $user['username'] . '</td>';
                      echo '<td>' . $user['firstname'] . '</td>';
                      echo '<td>' . $user['lastname'] . '</td>';
                      echo '<td>' . $user['created_at'] . '</td>';
                      echo '<td>' . $user['updated_at'] . '</td>';
                      echo '<td>' . $user['verified'] . '</td>';
                      echo '<td>' . $user['role'] . '</td>';
                      echo '<td><button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#childrenModal' . $user['id'] . '">View Children</button></td>';
                      echo '<td><button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#devicesModal' . $user['id'] . '">View Devices</button></td>';
                      echo '</tr>';

                      // Modal for Children
                      echo '<div class="modal fade" id="childrenModal' . $user['id'] . '" tabindex="-1" role="dialog" aria-labelledby="childrenModalLabel' . $user['id'] . '" aria-hidden="true">';
                      echo '<div class="modal-dialog" role="document">';
                      echo '<div class="modal-content">';
                      echo '<div class="modal-header">';
                      echo '<h5 class="modal-title" id="childrenModalLabel' . $user['id'] . '">Children of ' . $user['username'] . '</h5>';
                      echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                      echo '<span aria-hidden="true">&times;</span>';
                      echo '</button>';
                      echo '</div>';
                      echo '<div class="modal-body">';
                      foreach ($user['children'] as $child) {
                        echo 'ID: ' . $child['id'] . ', Email: ' . $child['email'] . ', Username: ' . $child['username'] . '<br>';
                      }
                      echo '</div>';
                      echo '<div class="modal-footer">';
                      echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';

                      // Modal for Devices
                      echo '<div class="modal fade" id="devicesModal' . $user['id'] . '" tabindex="-1" role="dialog" aria-labelledby="devicesModalLabel' . $user['id'] . '" aria-hidden="true">';
                      echo '<div class="modal-dialog" role="document">';
                      echo '<div class="modal-content">';
                      echo '<div class="modal-header">';
                      echo '<h5 class="modal-title" id="devicesModalLabel' . $user['id'] . '">Devices of ' . $user['username'] . '</h5>';
                      echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                      echo '<span aria-hidden="true">&times;</span>';
                      echo '</button>';
                      echo '</div>';
                      echo '<div class="modal-body">';
                      foreach ($user['devices'] as $device) {
                        echo 'ID: ' . $device['id'] . ', Serial: ' . $device['serial_number'] . ', Nama Perangkat: ' . $device['nama_perangkat'] . ', Status: ' . $device['status_perangkat'] . '<br>';
                      }
                      echo '</div>';
                      echo '<div class="modal-footer">';
                      echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include "footer.php"; ?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script>
  $(function () {
    $("#userTable").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#userTable_wrapper .col-md-6:eq(0)');
  });
</script>
</body>
</html>