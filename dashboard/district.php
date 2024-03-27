<?php
    ini_set('display_errors','on');
    include('include/connection.php');
    $location = 'active';
    $locationBoolean = 'true';
    $locationShow = 'show';
	$district = 'active';

    if(isset($_POST['add'])){
        $stateid = $_POST['stateid'];
        $districtname = $_POST['districtname'];
        if($districtname){
            $insertSql = "INSERT INTO district (state_id,district_name) VALUES('$stateid','$districtname')";
            if($conn->query($insertSql) === TRUE){
                header('Location: district.php?msg=district Added !');
            }
        }else{
            header('Location: district.php?msg=Please Enter district !');
        }
    }

    if(isset($_POST['edit'])){
        $district_id = $_POST['district_id'];
        $editstateid = $_POST['editstateid'];
        $editdistrictname = $_POST['editdistrictname'];

        if($editdistrictname){
            $updatesql = "UPDATE district SET state_id = '$editstateid',district_name='$editdistrictname' WHERE did ='$district_id'";
            if($conn->query($updatesql)===TRUE){
                header('Location: district.php?msg=district updated!');
            }
        }else{
            header('Location: district.php?msg=Please Enter district !');
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>District | Salvo Ambulance</title>
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
                                        <h4>All District</h4>
                                    </div>
                                    <div class="col-sm-3">
                                        <button type="button" class="btn btn-outline-secondary float-right m-3" data-toggle="modal" data-target="#exampleModal">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                            Add New
                                        </button>
                                        <div class="modal fade show" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="padding-right: 17px; display: none;" aria-modal="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                <div class="modal-content">
                                                    <form method="post" enctype="multipart/form-data">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="addAdminTitle">Add District</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <label>country Name</label>
                                                                    <select name="countryid" id="countryid" class="form-control" required onchange="country(this)">
                                                                        <option seleted>Please Select country</option>
                                                                        <?php
                                                                        $countrysql = "SELECT * FROM country";
                                                                        $countryResult = $conn->query($countrysql);
                                                                        while($cRow = $countryResult->fetch_assoc()){
                                                                            ?>
                                                                            <option value="<?php echo $cRow['cid']?>"><?php echo $cRow['country_name']?></option>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <label>state Name</label>
                                                                    <select name="stateid" id="stateid" class="form-control" required>
                                                                        <option seleted>Please Select State</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <label>District Name</label>
																	<input type="text" name="districtname" id="districtname" class="form-control" placeholder="District name" required>
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
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <div class="table-responsive">
                                    <table class="table mb-4 convert-data-table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">country Name</th>
                                                <th class="text-center">state Name</th>
                                                <th class="text-center">District Name</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $sql = "SELECT * FROM district a LEFT OUTER JOIN state b ON a.state_id=b.sid LEFT OUTER JOIN country c ON b.country_id=c.cid";
                                                $result = $conn->query($sql);
                                                $count = 0;
                                                while($row = $result->fetch_assoc())
                                                {
                                                    $did = $row['did'];
                                            ?>
                                                <tr>
                                                    <td class="text-center"><?php echo ++$count ?></td>
                                                    <td class="text-center"><b><?php echo $row['country_name'] ?></b></td>
                                                    <td class="text-center"><b><?php echo $row['state_name'] ?></b></td>
                                                    <td class="text-center"><b><?php echo $row['district_name'] ?></b></td>
                                                    <td class="text-center">
                                                        <ul class="table-controls">
                                                            <li>
                                                                <a data-toggle="modal" data-target="#edit<?php echo $count ?>">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                                                </a>
                                                                <div class="modal fade" id="edit<?php echo $count ?>" tabindex="-1" role="dialog" aria-labelledby="addAdminTitle<?php echo $count ?>" style="display: none;" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                                        <div class="modal-content">
                                                                            <form method="post" enctype="multipart/form-data">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="addAdminTitle<?php echo $count ?>">Edit District</h5>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="row">
                                                                                        <div class="col-sm-6">
                                                                                            <label>state Name</label>
                                                                                            <select name="editstateid" id="editstateid<?php echo $count ?>" class="form-control">
                                                                                            <?php
                                                                                            $checkSql = "SELECT * FROM state";
                                                                                            $checkResult = $conn->query($checkSql);
                                                                                            while($checkRow = $checkResult->fetch_assoc()){
                                                                                                ?>
                                                                                                <option value="<?php echo $checkRow['sid'];?>"<?php if($checkRow['sid'] == $row['state_id']){ echo "selected"; }?>><?php echo $checkRow['state_name'];?></option>
                                                                                                <?php
                                                                                            }
                                                                                            ?>
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="col-sm-6">
                                                                                            <label>District Name</label>
                                                                                            <input type="text" name="editdistrictname" id="editdistrictname<?php echo $count ?>" class="form-control" placeholder="District name" value="<?php echo $row['district_name'] ?>">
                                                                                        </div>
                                                                                        
                                                                                    </div>
                                                                                    <input type="hidden" name="district_id" value="<?php echo $did ?>">
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                                                                                    <button type="submit" name="edit" class="btn btn-primary">Save</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </td>
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
<script>
    function country(id){
        var countryid = id.value;
        $.ajax({
            type: "POST",
            url: "ajax/statefind.php",
            data:{'id':countryid},
            success: function(data){
                document.getElementById("stateid").innerHTML = data;
            }
        });
    }
</script>