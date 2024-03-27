<?php

    session_start();
    ini_set('display_errors','off');
    include('include/connection.php');
    date_default_timezone_set("Asia/Calcutta");

    $order_id = $_REQUEST['id'];

    $sql = "UPDATE orders SET print_status='Already Printed' WHERE order_id='$order_id'";
    $conn->query($sql);

    $sql = "SELECT * FROM orders WHERE order_id='$order_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $user_id = $row['user_id'];
    $near_zone = $row['login_id'];
    $address_id = $row['address_id'];

    $sql4 = "SELECT branch_name,gst FROM branch WHERE login_id='$near_zone'";
    $result4 = $conn->query($sql4);
    $row4 = $result4->fetch_assoc();

    $sql1 = "SELECT user_phone_number,user_name,user_alternate_phone_number FROM user WHERE user_id='$user_id'";
    $result1 = $conn->query($sql1);
    $row1 = $result1->fetch_assoc();

    $sql5 = "SELECT * FROM user_address WHERE user_address_id='$address_id'";
    $result5 = $conn->query($sql5);
    $row5 = $result5->fetch_assoc();

    if($row['order_status'] == 5)
    { 
        $delivery_time = date('h:i A', strtotime($row['delivery_slot'])); 
    }else{ 
       $delivery_time = $row['delivery_slot']; 
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KOT Print | Salvo Ambulance</title>

    <!-- <meta http-equiv="refresh" content="30"> -->
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.png"/>
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
        .main-container{
            max-width: 300px;
            height: auto;
        }
        .title{
            color: black;
            font-size: 10px;
            font-weight:  800;
        }
        .value{
            color: black;
            font-size: 10px;
            font-weight:  800;
        }
        .header{
            border: 1px solid black;padding: 5px;color:black;font-weight: 800;
            text-align: center;
            color: white;
        }
        .table > tbody:before {
            content: none;
        }
    </style>

</head>
<body onload="printDiv()">
    <div class="main-container" style="height: auto !important">
        <div class="body" id="PRINT-DIV">
            <div class="header">
                <div class="row">
                    <div class="col-sm-12">
                        <img src="assets/img/mainLogo.png" alt="icon" style="height: 40px;width: 100px">
                    </div>
                </div>
            </div>
            <div class="content">
                <table style="border: 1px solid black;padding: 5px;color:black;font-weight: 800">
                    <tbody style="border: 1px solid black;padding: 5px;color:black;font-weight: 800">
                        <tr style="border: 1px solid black;padding: 5px;color:black;font-weight: 800">
                            <td style="border: 1px solid black;padding: 5px;color:black;font-weight: 800">Order ID</td>
                            <td style="border: 1px solid black;padding: 5px;color:black;font-weight: 800"><?php echo $row['order_string'];?></td>
                        </tr>
                        <?php
                            if($row['fast_delivery'] == 0){
                                ?>
                                    <tr>
                                        <td style="border: 1px solid black;padding: 5px;color:black;font-weight: 800">Timeslot</td>
                                        <td style="border: 1px solid black;padding: 5px;color:black;font-weight: 800"><?php echo $row['slot'];?></td>
                                    </tr>
                                <?php
                            }
                        ?>
                        <tr style="border: 1px solid black;padding: 5px;color:black;font-weight: 800">
                            <td style="border: 1px solid black;padding: 5px;color:black;font-weight: 800">Booking Data/Time</td>
                            <td style="border: 1px solid black;padding: 5px;color:black;font-weight: 800"><?php echo date('d-m-Y', strtotime($row['booking_date'])).' / '.date('h:i A', strtotime($row['booking_time']));?></td>
                        </tr>
                        <!-- <tr style="border: 1px solid black;padding: 5px;color:black;font-weight: 800">
                            <td style="border: 1px solid black;padding: 5px;color:black;font-weight: 800">Delivery Data/Time</td>
                            <td style="border: 1px solid black;padding: 5px;color:black;font-weight: 800"><?php echo date('d-m-Y', strtotime($row['delivery_date'])).' / '.$delivery_time;?></td>
                        </tr> -->
                        <tr style="border: 1px solid black;padding: 5px;color:black;font-weight: 800">
                            <td style="border: 1px solid black;padding: 5px;color:black;font-weight: 800">Name</td>
                            <td style="border: 1px solid black;padding: 5px;color:black;font-weight: 800"><?php echo $row1['user_name'];?></td>
                        </tr>
                        <tr style="border: 1px solid black;padding: 5px;color:black;font-weight: 800">
                            <td style="border: 1px solid black;padding: 5px;color:black;font-weight: 800">Phone</td>
                            <td style="border: 1px solid black;padding: 5px;color:black;font-weight: 800"><?php echo $row1['user_phone_number'];?></td>
                        </tr>
                        <tr style="border: 1px solid black;padding: 5px;color:black;font-weight: 800">
                            <td style="border: 1px solid black;padding: 5px;color:black;font-weight: 800">Alt Phone</td>
                            <td style="border: 1px solid black;padding: 5px;color:black;font-weight: 800"><?php echo $row1['user_alternate_phone_number'];?></td>
                        </tr>
                        <tr style="border: 1px solid black;padding: 5px;color:black;font-weight: 800">
                            <td style="border: 1px solid black;padding: 5px;color:black;font-weight: 800">Branch</td>
                            <td style="border: 1px solid black;padding: 5px;color:black;font-weight: 800"><?php echo $row4['branch_name'];?></td>
                        </tr>
                        <tr style="border: 1px solid black;padding: 5px;color:black;font-weight: 800">
                            <td style="border: 1px solid black;padding: 5px;color:black;font-weight: 800">Address</td>
                            <td style="border: 1px solid black;padding: 5px;color:black;font-weight: 800"><?php echo $row['user_address'];?></td>
                        </tr>
                        <tr style="border: 1px solid black;padding: 5px;color:black;font-weight: 800">
                            <td style="border: 1px solid black;padding: 5px;color:black;font-weight: 800">GST No</td>
                            <td style="border: 1px solid black;padding: 5px;color:black;font-weight: 800"><?php echo $row4['gst'];?></td>
                        </tr>
                        <tr style="border: 1px solid black;padding: 5px;color:black;font-weight: 800">
                            <td style="border: 1px solid black;padding: 5px;color:black;font-weight: 800">Payment Method</td>
                            <td style="border: 1px solid black;padding: 5px;color:black;font-weight: 800"><?php echo $row['payment_type'];?></td>
                        </tr>
                        <tr style="border: 1px solid black;padding: 5px;color:black;font-weight: 800">
                            <td style="border: 1px solid black;padding: 5px;color:black;font-weight: 800">Amount</td>
                            <td style="border: 1px solid black;padding: 5px;color:black;font-weight: 800"><?php echo "₹ ".$row['total_amount'];?></td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered table-striped mb-0" style="border: 1px solid black;padding: 5px;color:black;font-weight: 800">
                    <thead>
                        <tr style="border: 1px solid black;padding: 5px;color:black;font-weight: 800">
                            <th>S.No</th>
                            <th>Product</th>
                            <th>Qty</th>
                        </tr style="border: 1px solid black;padding: 5px;color:black;font-weight: 800">
                    </thead>
                    <tbody style="border: 1px solid black;padding: 5px;color:black;font-weight: 800">
                        <?php
                        $sql2 = "SELECT * FROM order_detail WHERE order_id='$order_id'";
                        $result2 = $conn->query($sql2);
                        $count = 1;
                        while($row2 = $result2->fetch_assoc()){
                            $prodcut_name = $row2['product_name'];
                    ?>
                    <tr>
                            <td class="value" style="border: 1px solid black;padding: 5px;color:black;font-weight: 800"><?php echo $count++; ?></td>
                            <td class="value" style="border: 1px solid black;padding: 5px;color:black;font-weight: 800"><?php echo $row2['product_name'] ?></td>
                            <td class="value" style="border: 1px solid black;padding: 5px;color:black;font-weight: 800"><?php echo $row2['quantity'] ?></td>
                        </tr>
                            
                    <?php
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

<script>
 window.print();
</script>
<!-- 
<script>
    function printDiv() {
        var divContents = document.getElementById("PRINT-DIV").innerHTML;
        var a = window.open('', '', 'width=310');
        a.document.write('<html>');
        a.document.write('<style>.main-container{ max-width: 300px; border: 1px solid black;padding: 5px;color:black;font-weight: 800; }.title{ color: black; font-size: 10px; font-weight:  800; } .value{ color: black; font-size: 10px; font-weight:  800; } .body{ } .header{ border: 1px solid black;padding: 5px;color:black;font-weight: 800; text-align: center; color: white; } .content{ padding: 10px; }</style>');
        a.document.write('<body > <h1>Div contents are <br>');
        a.document.write(divContents);
        a.document.write('</body></html>');
        a.document.close();
        a.print();
    }
</script> -->