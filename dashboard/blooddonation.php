<?php
    ini_set('display_errors','on');
    include('include/connection.php');
    $blood = 'active';
    $bloodBoolean = 'true';
    $bloodShow = 'show';
	$blooddonation = 'active';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Blood Donor | Salvo Ambulance</title>
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
                <div class="row layout-top-spacing">
                    <?php include('include/notification.php') ?>
                    <div class="col-sm-12">
                        <!-- <a href="arrangeBanner.php" class="btn btn-outline-secondary float-right m-3">Arrangement</a> -->
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-sm-9">
                                        <h4>Blood Donor List</h4>
                                    </div>
                                    <!-- <div class="col-sm-3">
                                        <button type="button" class="btn btn-outline-secondary float-right m-3" data-toggle="modal" data-target="#exampleModal">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                            Add New
                                        </button>
                                        <div class="modal fade show" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="padding-right: 17px; display: none;" aria-modal="true">
                                            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                                <div class="modal-content">
                                                    <form method="post" enctype="multipart/form-data">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="addAdminTitle">Add Blood Group</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <label>Blood Name</label>
																	<input type="text" name="bloodname" id="bloodname" class="form-control" placeholder="Blood Name">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                                                            <button type="submit" name="add" class="btn btn-primary">Add</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <div class="table-responsive">
                                    <table class="table mb-4 convert-data-table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">Donor Name</th>
                                                <th class="text-center">Blood Gruop</th>
                                                <th class="text-center">Age</th>
                                                <th class="text-center">DOB</th>
                                                <th class="text-center">Gender</th>
                                                <th class="text-center">Phone No</th>
                                                <th class="text-center">Alter Phone No</th>
                                                <th class="text-center">city name</th>
                                                <th class="text-center">Address</th>
                                                <th class="text-center">Height</th>
                                                <th class="text-center">Weight</th>
                                                <th class="text-center">Ever donate blood before</th>
                                                <th class="text-center">Any diseases status</th>
                                                <th class="text-center">Any allergies status</th>
                                                <th class="text-center">Take any medication</th>
                                                <th class="text-center">Bleeding Status</th>
                                                <th class="text-center">Cardiac Status</th>
                                                <th class="text-center">Hiv Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $sql = "SELECT * FROM blood_donation a 
                                                LEFT OUTER JOIN user b ON a.user_id=b.user_id 
                                                LEFT OUTER JOIN city c ON a.donor_city_id=c.city_id
                                                LEFT OUTER JOIN bloodlist d ON a.blood_group = d.blood_id";
                                                $result = $conn->query($sql);
                                                $count = 0;
                                                while($row = $result->fetch_assoc())
                                                {
                                                    $blood_id = $row['blood_donation_id '];

                                                    if($row['ever_donate_blood_before'] == 1){
                                                        $beforeStatus = '<span class="badge outline-badge-success">YES</span>';
                                                    } else{
                                                        $beforeStatus = '<span class="badge outline-badge-danger">NO</span>';
                                                    }

                                                    if($row['any_diseases_status'] == 1){
                                                        $diseasesStatus = '<span class="badge outline-badge-success">YES</span>';
                                                    } else{
                                                        $diseasesStatus = '<span class="badge outline-badge-danger">NO</span>';
                                                    }

                                                    if($row['any_allergies_status'] == 1){
                                                        $allergiesStatus = '<span class="badge outline-badge-success">YES</span>';
                                                    } else{
                                                        $allergiesStatus = '<span class="badge outline-badge-danger">NO</span>';
                                                    }

                                                    if($row['take_any_medication'] == 1){
                                                        $medicationStatus = '<span class="badge outline-badge-success">YES</span>';
                                                    } else{
                                                        $medicationStatus = '<span class="badge outline-badge-danger">NO</span>';
                                                    }

                                                    if($row['bleeding_status'] == 1){
                                                        $bleedingStatus = '<span class="badge outline-badge-success">YES</span>';
                                                    } else{
                                                        $bleedingStatus = '<span class="badge outline-badge-danger">NO</span>';
                                                    }
                                                    if($row['cardiac_status'] == 1){
                                                        $cardiacStatus = '<span class="badge outline-badge-success">YES</span>';
                                                    } else{
                                                        $cardiacStatus = '<span class="badge outline-badge-danger">NO</span>';
                                                    }
                                                    if($row['hiv_status'] == 1){
                                                        $hivStatus = '<span class="badge outline-badge-success">YES</span>';
                                                    } else{
                                                        $hivStatus = '<span class="badge outline-badge-danger">NO</span>';
                                                    }
                                                    
                                            ?>
                                                <tr>
                                                    <td class="text-center"><?php echo ++$count ?></td>
                                                    <td class="text-center"><?php echo $row['blood_donor_name'] ?></td>
                                                    <td class="text-center"><b><?php echo $row['blood_name'] ?></b></td>
                                                    <td class="text-center"><?php echo $row['blood_donor_age'] ?></td>
                                                    <td class="text-center"><?php echo $row['blood_donor_dob'] ?></td>
                                                    <td class="text-center"><?php echo $row['blood_donor_gender'] ?></td>
                                                    <td class="text-center"><?php echo $row['user_phone_number'] ?></td>
                                                    <td class="text-center"><?php echo $row['donor_alter_phone_no'] ?></td>
                                                    <td class="text-center"><?php echo $row['city_name'] ?></td>
                                                    <td class="text-center"><?php echo $row['donor_address'] ?></td>
                                                    <td class="text-center"><?php echo $row['donor_height'] ?></td>
                                                    <td class="text-center"><?php echo $row['donor_weight'] ?></td>
                                                    <td class="text-center">
                                                        <a data-toggle="modal" data-target="#edit<?php echo $count ?>"><?php echo $beforeStatus ?></a>
                                                        <div class="modal fade" id="edit<?php echo $count ?>" tabindex="-1" role="dialog" aria-labelledby="addAdminTitle<?php echo $count ?>" style="display: none;" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="addAdminTitle<?php echo $count ?>">Last time Donated date</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                <label>Last time Donated date</label>
                                                                                <input type="date" id="editbankname<?php echo $count ?>" class="form-control" value="<?php echo $row['last_time_donated_date'] ?>" readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <a data-toggle="modal" data-target="#diseases<?php echo $count ?>"><?php echo $diseasesStatus ?></a>
                                                        <div class="modal fade" id="diseases<?php echo $count ?>" tabindex="-1" role="dialog" aria-labelledby="addAdminTitle<?php echo $count ?>" style="display: none;" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="addAdminTitle<?php echo $count ?>">diseases command</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                <label>diseases command</label>
                                                                                <textarea  id="diseases<?php echo $count ?>" class="form-control" readonly><?php echo $row['diseases_command'] ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <a data-toggle="modal" data-target="#allergies<?php echo $count ?>"><?php echo $allergiesStatus ?></a>
                                                        <div class="modal fade" id="allergies<?php echo $count ?>" tabindex="-1" role="dialog" aria-labelledby="addAdminTitle<?php echo $count ?>" style="display: none;" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="addAdminTitle<?php echo $count ?>">allergies command</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                <label>allergies command</label>
                                                                                <textarea  id="allergies<?php echo $count ?>" class="form-control" readonly><?php echo $row['allergies_command'] ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <a data-toggle="modal" data-target="#medication<?php echo $count ?>"><?php echo $medicationStatus ?></a>
                                                        <div class="modal fade" id="medication<?php echo $count ?>" tabindex="-1" role="dialog" aria-labelledby="addAdminTitle<?php echo $count ?>" style="display: none;" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="addAdminTitle<?php echo $count ?>">medication command</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                <label>medication command</label>
                                                                                <textarea  id="medication<?php echo $count ?>" class="form-control" readonly><?php echo $row['medication_command'] ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center"><?php echo $bleedingStatus ?></td>
                                                    <td class="text-center"><?php echo $cardiacStatus?></td>
                                                    <td class="text-center"><?php echo $hivStatus ?></td>
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
    <script src="assets/js/manual.js"></script>
    <script src="plugins/notification/snackbar/snackbar.min.js"></script>
</body>
</html>