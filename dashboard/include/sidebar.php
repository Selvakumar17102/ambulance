<div class="sidebar-wrapper sidebar-theme">
    <nav id="sidebar">
        <div class="profile-info">
            <figure class="user-cover-image"></figure>
            <div class="user-info img-head">
                <img style="background-color: #e7c8c8" src="assets/img/ambulance.png" alt="avatar">
                <h6 class="" style="color: red;"><?php echo $name ?></h6>
            </div>
        </div>
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            <?php
                if($control == 0){
            ?>
                    <li class="menu <?php echo $dashboard ?>">
                        <?php
                            if($dashboardBoolean != 'true'){
                                $dashboardBoolean = 'false';
                            }
                        ?>
                        <a href="dashboard.php" aria-expanded="<?php echo $dashboardBoolean ?>" class="dropdown-toggle">
                            <div class="">
                                <img style="width: 30px;padding-right: 5px;" src="assets/img/icon/dashboard.png" alt="">
                                <span>Dashboard</span>
                            </div>
                        </a>
                    </li>
                   
                    <li class="menu <?php echo $blood ?>">
                        <?php
                            if($bloodBoolean != 'true'){
                                $bloodBoolean = 'false';
                            }
                        ?>
                        <a href="#blood" data-toggle="collapse" aria-expanded="<?php echo $bloodBoolean ?>" class="dropdown-toggle">
                            <div class="">
                                <img style="width: 30px;padding-right: 5px;" src="assets/img/icon/blood.png" alt="">
                                <span>Blood</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled <?php echo $bloodShow ?>" id="blood" data-parent="#accordionExample">
                            <li class="<?php echo $bloodapp ?>">
                                <a href="bloodAppcontrol.php"> Blood App Control </a>
                            </li>
                            <li class="<?php echo $bloodbanner ?>">
                                <a href="bloodbanner.php"> Blood Banner </a>
                            </li>
                            <li class="<?php echo $bloodlist ?>">
                                <a href="bloodlist.php"> Blood List </a>
                            </li>
                            <li class="<?php echo $bloodbank ?>">
                                <a href="bloodbank.php"> Blood Bank</a>
                            </li>
                            <li class="<?php echo $blooddonation ?>">
                                <a href="blooddonation.php">Blood Donation</a>
                            </li>
                            <li class="<?php echo $bloodrequest ?>">
                                <a href="bloodrequest.php">Blood Request</a>
                            </li>
                            <li class="<?php echo $requestReason ?>">
                                <a href="request-reason.php">Request Reason</a>
                            </li>
                            <hr>
                            <a href="#"><b>Report</b></a>
                            <li class="<?php echo $donoruserReport ?>">
                                <a href="donorreportlist.php"> Donor list Report</a>
                            </li>
                            <li class="<?php echo $requestuserReport ?>">
                                <a href="requestreportlist.php"> Request list Report</a>
                            </li>
                            <hr>
                        </ul>
                    </li>
                    <li class="menu <?php echo $menu ?>">
                        <?php
                            if($menuBoolean != 'true'){
                                $menuBoolean = 'false';
                            }
                        ?>
                        <a href="#dashboard" data-toggle="collapse" aria-expanded="<?php echo $menuBoolean ?>" class="dropdown-toggle">
                            <div class="">
                                <img style="width: 30px;padding-right: 5px;" src="assets/img/icon/deliveryPartner.png" alt="">
                                <span>Ambulance</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled <?php echo $menuShow ?>" id="dashboard" data-parent="#accordionExample">
                            <li class="<?php echo $controls ?>">
                                <a href="control.php"> App Controls </a>
                            </li>
                            <li class="<?php echo $paymentMode ?>">
                                <a href="payment.php"> Payment Modes </a>
                            </li>

                            <li class="<?php echo $branch ?>">
                                <a href="branch.php"> City </a>
                            </li>
                            <li class="<?php echo $banner ?>">
                                <a href="banners.php"> Banners </a>
                            </li>
                            <li class="<?php echo $category ?>">
                                <a href="category.php"> Category </a>
                            </li>
                            <li class="<?php echo $ambulanceDriver ?>">
                                <a href="ambulanceDriver.php"> Driver </a>
                            </li>
                            <li class="<?php echo $ambulanceDriverRequest ?>">
                                <a href="ambulanceDriverRequest.php"> Driver Request </a>
                            </li>
                            <hr>
                            <a href="#"><b>Report</b></a>
                            <li class="<?php echo $orderReport ?>">
                                <a href="order-report.php"> Trip Report</a>
                            </li>
                            <li class="<?php echo $ambulanceDriverReport ?>">
                                <a href="ambulanceDriverReport.php"> Ambulance Driver Report</a>
                            </li>
                            <li class="<?php echo $triptimeReport ?>">
                                <a href="triptiming.php"> Trip Timing Report</a>
                            </li>
                            <hr>
                        </ul>
                    </li>
                    <!-- <li class="menu <?php echo $order ?>">
                        <?php
                            if($orderBoolean != 'true'){
                                $orderBoolean = 'false';
                            }
                        ?>
                        <a href="#order" data-toggle="collapse" aria-expanded="<?php echo $orderBoolean ?>" class="dropdown-toggle">
                            <div class="">
                                <img style="width: 30px;padding-right: 5px;" src="assets/img/icon/order.png" alt="">
                                <span>Emergency Trips</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled <?php echo $orderShow ?>" id="order" data-parent="#accordionExample">
                            <li class="<?php echo $newOrder ?>">
                                <a href="newOrder.php"> Active Trips </a>
                            </li>
                            <li class="<?php echo $allOrder ?>">
                                <a href="allOrder.php"> All Trips </a>
                            </li>
                            <li class="<?php echo $deliveredOrder ?>">
                                <a href="deliveredOrder.php"> Delivered Trips </a>
                            </li>
                            <li class="<?php echo $cancelledOrder ?>">
                                <a href="cancelledOrder.php"> Cancelled Trips </a>
                            </li>
                            <li class="<?php echo $pendingOrder ?>">
                                <a href="pendingOrder.php"> Pending Trips </a>
                            </li>
                        </ul>
                    </li> -->

                    <li class="menu <?php echo $instantOrder ?>">
                        <?php
                            if($instantOrderBoolean != 'true'){
                                $instantOrderBoolean = 'false';
                            }
                        ?>
                        <a href="#order1" data-toggle="collapse" aria-expanded="<?php echo $instantOrderBoolean ?>" class="dropdown-toggle">
                            <div class="">
                                <img style="width: 30px;padding-right: 5px;" src="assets/img/icon/order.png" alt="">
                                <!-- <span>Non Emergency Trips</span> -->
                                <span>Trips</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled <?php echo $instantOrderShow ?>" id="order1" data-parent="#accordionExample">
                            <li class="<?php echo $newOrder1 ?>">
                                <a href="newOrder1.php"> Active Trip </a>
                            </li>
                            <li class="<?php echo $allOrder1 ?>">
                                <a href="allOrder1.php"> All Trip </a>
                            </li>
                            <li class="<?php echo $deliveredOrder1 ?>">
                                <a href="deliveredOrder1.php"> Completed Trips </a>
                            </li>
                            <li class="<?php echo $cancelledOrder1 ?>">
                                <a href="cancelledOrder1.php"> Cancelled Trips </a>
                            </li>
                            <!-- <li class="<?php echo $pendingOrder1 ?>">
                                <a href="pendingOrder1.php"> Pending Trips </a>
                            </li> -->
                        </ul>
                    </li>
                    
                    <li class="menu <?php echo $users ?>">
                        <?php
                            if($usersBoolean != 'true'){
                                $usersBoolean = 'false';
                            }
                        ?>
                        <a href="user.php" aria-expanded="<?php echo $usersBoolean ?>" class="dropdown-toggle">
                            <div class="">
                                <img style="width: 30px;padding-right: 5px;" src="assets/img/icon/user.png" alt="">
                                <span>Users</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu <?php echo $location ?>">
                        <?php
                            if($locationBoolean != 'true'){
                                $locationBoolean = 'false';
                            }
                        ?>
                        <a href="#location" data-toggle="collapse" aria-expanded="<?php echo $locationBoolean ?>" class="dropdown-toggle">
                            <div class="">
                                <img style="width: 30px;padding-right: 5px;" src="assets/img/icon/branch.png" alt="">
                                <span>Location</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled <?php echo $locationShow ?>" id="location" data-parent="#accordionExample">
                            <li class="<?php echo $country ?>">
                                <a href="country.php">country</a>
                            </li>
                            <li class="<?php echo $state ?>">
                                <a href="state.php">state</a>
                            </li>
                            <li class="<?php echo $district ?>">
                                <a href="district.php">district</a>
                            </li>
                            <li class="<?php echo $city ?>">
                                <a href="city.php">city</a>
                            </li>
                        </ul>
                    </li>

                    <!-- <li class="menu <?php echo $setting ?>">
                        <?php
                            if($settingBoolean != 'true'){
                                $settingBoolean = 'false';
                            }
                        ?>
                        <a href="#setting" data-toggle="collapse" aria-expanded="<?php echo $settingBoolean ?>" class="dropdown-toggle">
                            <div class="">
                                <img style="width: 30px;padding-right: 5px;" src="assets/img/icon/setting.png" alt="">
                                <span>Settings</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled <?php echo $settingShow ?>" id="setting" data-parent="#accordionExample">
                            <li class="<?php echo $control ?>">
                                <a href="control.php"> App Controls </a>
                            </li>
                            <li class="<?php echo $paymentMode ?>">
                                <a href="payment.php"> Payment Modes </a>
                            </li>
                        </ul>
                    </li> -->

                    <!-- <li class="menu <?php echo $report ?>">
                        <?php
                            if($reportBoolean != 'true'){
                                $reportBoolean = 'false';
                            }
                        ?>
                        <a href="#report" data-toggle="collapse" aria-expanded="<?php echo $reportBoolean ?>" class="dropdown-toggle">
                            <div class="">
                                <img style="width: 30px;padding-right: 5px;" src="assets/img/icon/report.png" alt="">
                                <span>Reports</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled <?php echo $reportShow ?>" id="report" data-parent="#accordionExample">
                            <li class="<?php echo $orderReport ?>">
                                <a href="order-report.php"> Trip </a>
                            </li>
                            <li class="<?php echo $ambulanceDriverReport ?>">
                                <a href="ambulanceDriverReport.php"> Ambulance Driver </a>
                            </li>
                            <li class="<?php echo $triptimeReport ?>">
                                <a href="triptiming.php"> Trip Timing </a>
                            </li>
                            <li class="<?php echo $donoruserReport ?>">
                                <a href="donorreportlist.php"> Donor list </a>
                            </li>
                            <li class="<?php echo $requestuserReport ?>">
                                <a href="requestreportlist.php"> Request list </a>
                            </li>
                        </ul>
                    </li> -->
                    
                    <!-- <li class="menu <?php echo $bloodreport ?>">
                        <?php
                            if($bloodreportBoolean != 'true'){
                                $bloodreportBoolean = 'false';
                            }
                        ?>
                        <a href="#bloodreport" data-toggle="collapse" aria-expanded="<?php echo $bloodreportBoolean ?>" class="dropdown-toggle">
                            <div class="">
                                <img style="width: 30px;padding-right: 5px;" src="assets/img/icon/report.png" alt="">
                                <span>Blood Reports</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled <?php echo $bloodreportShow ?>" id="bloodreport" data-parent="#accordionExample">
                            <li class="<?php echo $donoruserReport ?>">
                                <a href="donorreportlist.php"> Donor list </a>
                            </li>
                            <li class="<?php echo $requestuserReport ?>">
                                <a href="requestreportlist.php"> Request list </a>
                            </li>
                        </ul>
                    </li> -->
            <?php
                } else{
            ?>
                    <li class="menu <?php echo $dashboard ?>">
                        <?php
                            if($dashboardBoolean != 'true'){
                                $dashboardBoolean = 'false';
                            }
                        ?>
                        <a href="dashboard.php" aria-expanded="<?php echo $dashboardBoolean ?>" class="dropdown-toggle">
                            <div class="">
                                <img style="width: 30px;padding-right: 5px;" src="assets/img/icon/dashboard.png" alt="">
                                <span>Dashboard</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu <?php echo $menu ?>">
                        <?php
                            if($menuBoolean != 'true'){
                                $menuBoolean = 'false';
                            }
                        ?>
                        <a href="#dashboard" data-toggle="collapse" aria-expanded="<?php echo $menuBoolean ?>" class="dropdown-toggle">
                            <div class="">
                                <img style="width: 30px;padding-right: 5px;" src="assets/img/icon/deliveryPartner.png" alt="">
                                <span>Ambulance</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled <?php echo $menuShow ?>" id="dashboard" data-parent="#accordionExample">
                            <li class="<?php echo $ambulanceDriver ?>">
                                <a href="ambulanceDriver.php"> Driver </a>
                            </li>
                            <li class="<?php echo $ambulanceDriverRequest ?>">
                                <a href="ambulanceDriverRequest.php"> Driver Request </a>
                            </li>
                        </ul>
                    </li>
                    <!-- <li class="menu <?php echo $order ?>">
                        <?php
                            if($orderBoolean != 'true'){
                                $orderBoolean = 'false';
                            }
                        ?>
                        <a href="#order" data-toggle="collapse" aria-expanded="<?php echo $orderBoolean ?>" class="dropdown-toggle">
                            <div class="">
                                <img style="width: 30px;padding-right: 5px;" src="assets/img/icon/order.png" alt="">
                                <span>Emergency Trips</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled <?php echo $orderShow ?>" id="order" data-parent="#accordionExample">
                            <li class="<?php echo $newOrder ?>">
                                <a href="newOrder.php"> Active Trips </a>
                            </li>
                            <li class="<?php echo $allOrder ?>">
                                <a href="allOrder.php"> All Trips </a>
                            </li>
                            <li class="<?php echo $deliveredOrder ?>">
                                <a href="deliveredOrder.php"> Delivered Trips </a>
                            </li>
                            <li class="<?php echo $cancelledOrder ?>">
                                <a href="cancelledOrder.php"> Cancelled Trips </a>
                            </li>
                            <li class="<?php echo $pendingOrder ?>">
                                <a href="pendingOrder.php"> Pending Trips </a>
                            </li>
                        </ul>
                    </li> -->
                    <li class="menu <?php echo $instantOrder ?>">
                        <?php
                            if($instantOrderBoolean != 'true'){
                                $instantOrderBoolean = 'false';
                            }
                        ?>
                        <a href="#order1" data-toggle="collapse" aria-expanded="<?php echo $instantOrderBoolean ?>" class="dropdown-toggle">
                            <div class="">
                                <img style="width: 30px;padding-right: 5px;" src="assets/img/icon/order.png" alt="">
                                <!-- <span>Non Emergency Trips</span> -->
                                <span>Trips</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled <?php echo $instantOrderShow ?>" id="order1" data-parent="#accordionExample">
                            <li class="<?php echo $newOrder1 ?>">
                                <a href="newOrder1.php"> Active Trip </a>
                            </li>
                            <li class="<?php echo $allOrder1 ?>">
                                <a href="allOrder1.php"> All Trip </a>
                            </li>
                            <li class="<?php echo $deliveredOrder1 ?>">
                                <a href="deliveredOrder1.php"> Completed Trips </a>
                            </li>
                            <li class="<?php echo $cancelledOrder1 ?>">
                                <a href="cancelledOrder1.php"> Cancelled Trips </a>
                            </li>
                            <!-- <li class="<?php echo $pendingOrder1 ?>">
                                <a href="pendingOrder1.php"> Pending Trips </a>
                            </li> -->
                        </ul>
                    </li>
                    <li class="menu <?php echo $report ?>">
                        <?php
                            if($reportBoolean != 'true'){
                                $reportBoolean = 'false';
                            }
                        ?>
                        <a href="#report" data-toggle="collapse" aria-expanded="<?php echo $reportBoolean ?>" class="dropdown-toggle">
                            <div class="">
                                <img style="width: 30px;padding-right: 5px;" src="assets/img/icon/report.png" alt="">
                                <span>Reports</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled <?php echo $reportShow ?>" id="report" data-parent="#accordionExample">
                            <li class="<?php echo $orderReport ?>">
                                <a href="order-report.php"> Trip </a>
                            </li>
                            <li class="<?php echo $ambulanceDriverReport ?>">
                                <a href="ambulanceDriverReport.php"> Ambulance Driver </a>
                            </li>
                        </ul>
                    </li>
            <?php
                }
            ?>
        </ul>
        
    </nav>

</div>