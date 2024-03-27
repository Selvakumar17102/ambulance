<?php
    include('../include/connection.php');

    if($control == 0){
        $sql = "SELECT * FROM orders WHERE order_status='3' AND order_type='0' AND service_type='1' ORDER BY order_id DESC";
    } else{
        $sql = "SELECT * FROM orders WHERE order_status='3' AND order_type='0' AND login_id='$login_id' AND service_type='1' ORDER BY order_id DESC";
    }
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        $i = 1;
        while($row = $result->fetch_assoc()){
            $user_id = $row['user_id'];
            $delivery_partner_id = $row['delivery_partner_id'];

            $sql1 = "SELECT * FROM delivery_partner WHERE delivery_partner_id='$delivery_partner_id'";
            $result1 = $conn->query($sql1);
            $row1 = $result1->fetch_assoc();

            $delivery_partner_name = $row1['delivery_partner_name'];

            $sql1 = "SELECT * FROM user WHERE user_id='$user_id'";
            $result1 = $conn->query($sql1);
            $row1 = $result1->fetch_assoc();

            if($row['pickup_otp']==''){
                $pickup_otp = 'N/A';
            }else{
                $pickup_otp = $row['pickup_otp'];
            }

            
            $booking_date = date('d-m-Y', strtotime($row['booking_date']));
            $booking_time = date('h:i A', strtotime($row['booking_time']));

            $delivery_date = date('d-m-Y', strtotime($row['delivery_date']));
            $time_slot=$row['slot'];


            $bookings = $booking_date.'<br>'.$booking_time;
            $deliverys = $delivery_date.'<br>'.$time_slot;
?>
            <tr>
                <td class="text-center"><?php echo $i++ ?></td>
                <td class="text-center"><a href="view-order.php?id=<?php echo $row['order_id'] ?>"><?php echo $row['order_string'] ?></a></td>
                <td class="text-center"><?php echo $bookings ?></td>
                <td class="text-center"><?php echo $row1['user_name'] ?></td>
                <td class="text-center"><?php echo $row['pickup_address'] ?></td>
                <td class="text-center"><?php echo $row['drop_address'] ?></td>
                <td class="text-center"><?php echo $row['payment_type'] ?></td>
                <td class="text-center"><?php echo ucfirst($delivery_partner_name) ?></td>
                <td class="text-center">₹ <?php echo $row['total_amount'] ?></td>
            </tr>
<?php
        }
    }
?>