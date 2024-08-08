<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Dashboard 2</title>

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
  <!-- Custom CSS for room layout -->
  <style>
    .room-container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }
    .room {
      border: 2px solid #ccc;
      border-radius: 10px;
      width: 200px;
      height: 200px;
      position: relative;
      background: #f4f6f9;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .room h5 {
      position: absolute;
      top: 10px;
      left: 10px;
      margin: 0;
      font-size: 1em;
      background: rgba(255, 255, 255, 0.8);
      padding: 5px;
      border-radius: 5px;
      color: #000; /* Set the text color to black */
    }
    .door {
      position: absolute;
      bottom: 10px;
      left: 50%;
      transform: translateX(-50%);
      font-size: 2em;
      color: #4caf50; /* Default color for 'open' status */
    }
    .door.closed {
      color: #f44336; /* Color for 'closed' status */
    }
  </style>
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <?php include "navbar.php"; ?>
  <?php include "sidebar.php";?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Device</h1>
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
                <h3 class="card-title">Data Perangkat</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="room-container" id="deviceRooms">
                  <!-- Prototype ruangan dan status perangkat akan ditambahkan di sini -->
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- Log Perangkat Card -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Log Perangkat</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="logTable" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nama Perangkat</th>
                      <th>Waktu</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody id="logTableBody">
                    <!-- Log data will be inserted here dynamically -->
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

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
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

<!-- PAGE PLUGINS -->
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

<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard2.js"></script>

<script>
  $(function () {
    // Auto refresh every 2 seconds for device status
    setInterval(function() {
      $.ajax({
        url: 'http://165.22.101.164:8000/api/relay/all-devices',
        method: 'GET',
        success: function(data) {
          var container = $('#deviceRooms');
          container.empty(); // Clear existing content

          data.devices.forEach(function(device) {
            var icon = device.status_perangkat === 'open' ? 'fa-door-open' : 'fa-door-closed';
            var doorClass = device.status_perangkat === 'open' ? '' : 'closed';
            var room = '<div class="room">' +
                          '<h5>' + device.nama_perangkat + '</h5>' +
                          '<div class="door ' + doorClass + '"><i class="fas ' + icon + '"></i></div>' +
                        '</div>';
            container.append(room);
          });
        }
      });
    }, 2000); // 2000 milliseconds = 2 seconds

    // Auto refresh every 2 seconds for device log
    setInterval(function() {
      $.ajax({
        url: 'http://165.22.101.164:8000/api/relay/a;;-devices',
        method: 'GET',
        success: function(data) {
          var tbody = $('#logTableBody');
          tbody.empty(); // Clear existing rows

          data.logs.forEach(function(log) {
            var row = '<tr>' +
                      '<td>' + serial_number + '</td>' +
                      '<td>' + nama_perangkat + '</td>' +
                      '<td>' + log.waktu + '</td>' +
                      '<td>' + status_perangkat + '</td>' +
                      '</tr>';
            tbody.append(row);
          });
        }
      });
    }, 2000); // 2000 milliseconds = 2 seconds
  });
</script>
</body>
</html>
