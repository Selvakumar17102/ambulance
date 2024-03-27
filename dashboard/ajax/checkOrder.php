<?php
    include('../include/connection.php');

    if(!empty($_POST['login'])){
		$login_id = $_POST['login'];

        $sql = "SELECT * FROM login WHERE login_id='$login_id'";
		$result = $conn->query($sql);
		if($result->num_rows){
			$row = $result->fetch_assoc();

			$control = $row['control'];

            if(!$control){
                $sql = "SELECT * FROM orders WHERE order_status='1' AND notification='0' ORDER BY order_id DESC";
            } else{
                $sql = "SELECT * FROM orders WHERE order_status='1' AND branch_notification='0' ORDER BY order_id DESC";
            }
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                $i = 1;
                $total = $result->num_rows;
                while($row = $result->fetch_assoc()){
                    if($i == $total){
                        $order_id = $row['order_id'];
                        $service_type = $row['service_type'];

                        if(!$control){
                            $sql = "UPDATE orders SET notification='1' WHERE order_id='$order_id'";
                        } else{
                            $sql = "UPDATE orders SET branch_notification='1' WHERE order_id='$order_id'";
                        }
                        if($conn->query($sql) === TRUE){
?>
                            <div class="modal-header">
                                <h5 class="modal-title" id="addAdminTitle">
<?php
                                    if($total == 1){
                                        echo 'New Order';
                                    } else{
                                        echo 'New Orders - '.$total;
                                    }
?>
                                </h5>

                                <?php if($service_type == 1){ ?>
                                    <a href="newOrder.php" class="btn btn-primary">All New Orders</a>
                                <?php  } else{ ?>
                                    <a href="newOrder1.php" class="btn btn-primary">All New Orders</a>
                                <?php  } ?>
                                
                            </div>
                            <div class="modal-body">
                                <h5>New order <?php echo $row['order_string'] ?> has been arrived.</h5>
                                <div class="p-3">
<?php
                                    $sql = "SELECT * FROM order_detail WHERE order_id='$order_id'";
                                    $result = $conn->query($sql);
                                    while($row = $result->fetch_assoc()){
                                        $eggless = '';
                                        if($row['eggless'] == 1){
                                            $eggless = 'Eggless';
                                        }
?>
                                        <p><?php echo $row['product_name'].' | '.$eggless ?> - <?php echo $row['quantity'] ?></p>
<?php
                                    }
?>
                                </div>
                            </div>
                            <div class="modal-footer" style="display: block">
                                <?php if($service_type == 1){ ?>
                                    <a href="view-order.php?id=<?php echo $order_id ?>" class="btn btn-secondary">View</a>
                                <?php  } else{ ?>
                                    <a href="view-order1.php?id=<?php echo $order_id ?>" class="btn btn-secondary">View</a>
                                <?php  } ?>
                                
                                <?php if($service_type == 1){ ?>
                                    <a href="accept-order.php?id=<?php echo $order_id ?>" class="btn btn-success float-right">Accept</a>
                                <?php  } else{ ?>
                                    <a href="accept-order1.php?id=<?php echo $order_id ?>" class="btn btn-success float-right">Accept</a>
                                <?php  } ?>
                            </div>
<?php
                        }
                    }
                    $i++;
                }
            } else{
                echo 'false';
            }
        }
    } else{
        echo 'false';
    }
?>