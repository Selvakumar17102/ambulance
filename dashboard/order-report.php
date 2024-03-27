<?php
    ini_set('display_errors','off');
    include('include/connection.php');
    $report = 'active';
    $reportShow = 'show';
    $reportBoolean = 'true';
    $orderReport = 'active';

    $start = $end = '';
    if($_REQUEST['fd'] != ''){
        $start = $_REQUEST['fd'];
        $end = $_REQUEST['ld'];
    } else{
        $end = date('Y-m-d');
        $start = date('Y-m-d', strtotime($end.' - 6days'));
    }

    if($control == 0){
        $sql = "SELECT sum(total_amount) AS amount FROM orders WHERE booking_date BETWEEN '$start' AND '$end' AND order_status='7'";
    } else{
        $sql = "SELECT sum(total_amount) AS amount FROM orders WHERE booking_date BETWEEN '$start' AND '$end' AND order_status='7' AND login_id='$login_id'";
    }
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $total = $row['amount'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Trip Report | Salvo Ambulance</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"/>
    <link href="assets/css/loader.css" rel="stylesheet" type="text/css" />
    <script src="assets/js/loader.js"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="assets/css/components/custom-modal.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/elements/avatar.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/scrollspyNav.css" rel="stylesheet" type="text/css">
    <link href="assets/css/tables/table-basic.css" rel="stylesheet" type="text/css" />
    <link href="plugins/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="plugins/table/datatable/dt-global_style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/forms/switches.css">

    <style>
        .flex-display{
            display: flex;
            justify-content: space-between;
        }
        .dt-buttons{
            float: right;
        }
    </style>
</head>
<body class="sidebar-noneoverflow">

    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>

    <?php include('include/header.php') ?>

    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <?php include('include/sidebar.php') ?>

        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <?php include('include/notification.php') ?>
                <div class="row layout-top-spacing">
                    <div class="col-sm-12">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <h4>Filter</h4>
                            </div>
                            <div class="widget-content widget-content-area">
                                <div class="row">
                                    <div class="col-sm-6 mt-2">
                                        <label for="fd">Start Date</label>
                                        <input type="date" id="fd" value="<?php echo $start ?>" class="form-control">
                                    </div>
                                    <div class="col-sm-6 mt-2">
                                        <label for="ld">End Date</label>
                                        <input type="date" id="ld" value="<?php echo $end ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-sm-12">
                                        <button class="btn btn-primary float-right" onclick="filterReport('order-report.php')">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row layout-top-spacing">
                    <div class="col-sm-12">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="flex-display">
                                    <h4>Trip Report</h4>
                                    <h4>Total : ₹ <?php echo number_format($total,2) ?></h4>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <div class="table-responsive">
                                    <!-- <table class="table table-bordered table-striped table-striped mb-4 convert-data-table"> -->
                                    <table class="table mb-4" id="Table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">S.No</th>
                                                <th class="text-center">Trip ID</th>
                                                <th class="text-center">Date</th>
                                                <th class="text-center">Mode</th>
                                                <th class="text-center">Driver Earning(₹)</th>
                                                <th class="text-center">Agent Earning(₹)</th>
                                                <th class="text-center">Total Amount(₹)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $count = 1;
                                                if($control == 0){
                                                    $sql = "SELECT * FROM orders WHERE booking_date BETWEEN '$start' AND '$end' AND order_status='7'";
                                                } else{
                                                    $sql = "SELECT * FROM orders WHERE booking_date BETWEEN '$start' AND '$end' AND order_status='7' AND login_id='$login_id'";
                                                }
                                                $result = $conn->query($sql);
                                                while($row = $result->fetch_assoc()){
                                            ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $count++ ?></td>
                                                        <td class="text-center"><a style="color: #790c46;font-weight: 600" href="view-order1.php?id=<?php echo $row['order_id'] ?>"><?php echo $row['order_string'] ?></a></td>
                                                        <td class="text-center"><?php echo date('d-m-Y', strtotime($row['booking_date'])) ?></td>
                                                        <td class="text-center"><?php echo $row['payment_type'] ?></td>
                                                        <td class="text-center">₹ <?php echo number_format($row['total_amount'] - $row['amount_for_client'],2) ?></td>
                                                        <td class="text-center">₹ <?php echo number_format($row['amount_for_client'],2) ?></td>
                                                        <td class="text-center">₹ <?php echo number_format($row['total_amount'],2) ?></td>
                                                    </tr>
                                            <?php
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                include('include/footer.php')
            ?>
        </div>
    </div>

    <script src="assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="bootstrap/js/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/app.js"></script>
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="assets/js/custom.js"></script>
    <script src="plugins/table/datatable/datatables.js"></script>
    <script src="plugins/table/datatable/button-ext/dataTables.buttons.min.js"></script>
    <script src="plugins/table/datatable/button-ext/jszip.min.js"></script>    
    <script src="plugins/table/datatable/button-ext/buttons.html5.min.js"></script>
    <script src="plugins/table/datatable/button-ext/buttons.print.min.js"></script>
    <script src="assets/js/manual.js"></script>
    <script src="plugins/notification/snackbar/snackbar.min.js"></script>
    <script>
        $("#Table").DataTable({
            dom: 'lBfrtip',
            buttons: {
                buttons: [
                    { extend: 'copy', className: 'btn' },
                    { extend: 'csv', className: 'btn' },
                    { extend: 'excel', className: 'btn' },
                ]
            },
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
            "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [50, 100, 200, 300],
            "pageLength": 50 
        })
	</script>
</body>
</html>