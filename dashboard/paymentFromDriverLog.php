<?php
    ini_set('display_errors','off');
    include('include/connection.php');
    date_default_timezone_set("Asia/Calcutta");

    $menu = 'active';
	$menuShow = 'show';
	$menuBoolean = 'true';
	$ambulanceDriverBoolean = 'true';
	$ambulanceDriver = 'active';

    $delivery_partner_id = $_REQUEST['id'];

    if(!$delivery_partner_id) header("Location: paymentFromDriverLog.php");

    $sql = "SELECT * FROM delivery_partner WHERE delivery_partner_id = $delivery_partner_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $amount_to_client = $row['amount_to_client'];
    $delivery_partner_name = $row['delivery_partner_name'];

    if(isset($_POST['add'])){
        $amount = $_POST['amount'];
        $date = $_POST['date'];

        $new_amount = $amount_to_client-$amount;

        if($amount > 0 && $amount <= $amount_to_client){
            $sql = "INSERT INTO payment_log (delivery_partner_id,amount,date,type) VALUES ('$delivery_partner_id','$amount','$date',1)";
            if($conn->query($sql) === TRUE){
                $sql = "UPDATE delivery_partner SET amount_to_client='$new_amount' WHERE delivery_partner_id = $delivery_partner_id";
                if($conn->query($sql) === TRUE){
                    header("Location: paymentFromDriverLog.php?id=$delivery_partner_id&msg=Updated");
                }
            }
        } else{
            header("Location: paymentFromDriverLog.php?id=$delivery_partner_id&msg=Amount must be less than $amount_to_client");
        }
    }

    $start = $end = '';
    if($_REQUEST['fd'] != ''){
        $start = $_REQUEST['fd'];
        $end = $_REQUEST['ld'];
    } else{
        $end = date('Y-m-d');
        $start = date('Y-m-d', strtotime($end.' - 6days'));
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Payment From <?php echo $delivery_partner_name ?> - Log | Salvo Ambulance</title>
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
    <style>
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
                    <div class="col-sm-12 mb-3">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <h4>Enter Receivied Amount</h4>
                                    </div>
                                    <div class="col-sm-2">
                                        <h4 style="text-align: right">Remaining: ₹ <?php echo number_format($amount_to_client, 2) ?></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <form method="post">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input type="number" name="amount" class="form-control" placeholder="Enter Receivied Amount" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="date" name="date" class="form-control" value="<?php echo date('Y-m-d') ?>" required>
                                        </div>
                                        <div class="col-sm-12">
                                            <input type="submit" name="add" value="Add" class="btn btn-primary mt-3 float-right">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
                                        <button class="btn btn-primary float-right" onclick="filterReport1('paymentFromDriverLog.php',<?php echo $delivery_partner_id ?>)">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 mt-4">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <h4>Log - Payment From <?php echo $delivery_partner_name ?></h4>
                                    </div>
                                    <!-- <div class="col-sm-2">
                                        <h4 style="text-align: right">Remaining: ₹ <?php echo number_format($amount_to_client, 2) ?></h4>
                                    </div> -->
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <div class="table-responsive">
                                    <table class="table mb-4" id="Table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">S.No</th>
                                                <th class="text-center">Date</th>
                                                <th class="text-center">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $count = 1;
                                                $sql = "SELECT * FROM payment_log WHERE delivery_partner_id = $delivery_partner_id AND type = 1 AND date BETWEEN '$start' AND '$end' ORDER BY id DESC";
                                                $result = $conn->query($sql);
                                                while($row = $result->fetch_assoc()){
                                            ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $count++ ?></td>
                                                        <td class="text-center"><?php echo date('d-m-Y', strtotime($row['date'])) ?></td>
                                                        <td class="text-center">₹ <?php echo number_format($row['amount'], 2) ?></td>
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
    <script src="plugins/table/datatable/datatables.js"></script>
    <script src="plugins/table/datatable/button-ext/dataTables.buttons.min.js"></script>
    <script src="plugins/table/datatable/button-ext/jszip.min.js"></script>    
    <script src="plugins/table/datatable/button-ext/buttons.html5.min.js"></script>
    <script src="plugins/table/datatable/button-ext/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="assets/js/custom.js"></script>
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
        function filterReport1(url, userId){
            let fd = document.getElementById('fd')
            let ld = document.getElementById('ld')

            if(fd.value == ''){
                fd.style.border = '1px solid red'
                return false
            } else{
                fd.style.border = '1px solid #bfc9d4'
                if(ld.value == ''){
                    ld.style.border = '1px solid red'
                    return false
                } else{
                    ld.style.border = '1px solid #bfc9d4'
                    location.replace(url+'?id='+userId+'&fd='+fd.value+'&ld='+ld.value)
                }
            }
        }
	</script>
</body>
</html>