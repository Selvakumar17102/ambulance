<?php
    ini_set('display_errors','on');
    include('include/connection.php');

    $introBanner = 'active';
    $introBannerBoolean = 'true';

    if(isset($_POST['add'])){
        $image = $_FILES['image']['name'];
        $banner_content = $_POST['banner_content'];

        $sql = "INSERT INTO intro_banner (intro_banner_content) VALUES ('$banner_content')";
        if($conn->query($sql) === TRUE){
            $sql = "SELECT * FROM intro_banner ORDER BY intro_banner_id DESC LIMIT 1";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $intro_banner_id = $row['intro_banner_id'];

            if($image){
                $type=pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
                $randomid = mt_rand(100,99999);
                $path="Images/Category/$randomid$intro_banner_id.$type";
                $allowTypes=array('jpg','JPG','png','PNG','jpeg','JPEG','gif','GIF');
                
                if(in_array($type, $allowTypes)){
                    if(move_uploaded_file($_FILES["image"]["tmp_name"], $path)){
                        $sql2 = "UPDATE intro_banner SET intro_banner_image = '$path' WHERE intro_banner_id='$intro_banner_id'";
                        $conn->query($sql2);
                        header('Location: intro-banners.php?msg=banner added!');
                    } 
                }
            }
            header('Location: intro-banners.php?msg=Banner added!');
        }
    }

    if(isset($_POST['edit'])){
        $intro_banner_id = $_POST['intro_banner_id'];
        $image = $_FILES['image']['name'];
        $banner_content = $_POST['banner_content'];


        $sql = "SELECT * FROM intro_banner WHERE intro_banner_id='$intro_banner_id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $banner_imageS = '';
        if(is_file($row['intro_banner_image'])){ $banner_imageS = $row['intro_banner_image']; } 
        
        $sql = "UPDATE intro_banner SET intro_banner_content='$banner_content' WHERE intro_banner_id='$intro_banner_id'";
        if($conn->query($sql) === TRUE){
            if($image){
                $type=pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
                $randomid = mt_rand(100,99999);
                $path="Images/Category/$randomid$intro_banner_id.$type";
                $allowTypes=array('jpg','JPG','png','PNG','jpeg','JPEG','gif','GIF');
                
                if(in_array($type, $allowTypes)){
                    if(move_uploaded_file($_FILES["image"]["tmp_name"], $path)){
                        unlink($banner_imageS);
                        $sql2 = "UPDATE intro_banner SET intro_banner_image = '$path' WHERE intro_banner_id='$intro_banner_id'";
                        $conn->query($sql2);
                        header('Location: intro-banners.php?msg=banner updated!');
                    } 
                }
            }
            header('Location: intro-banners.php?msg=Banner updated!');
        }
    }

    if(isset($_POST['delete'])){
        $intro_banner_id = $_POST['intro_banner_id'];

        $sql = "SELECT * FROM intro_banner WHERE intro_banner_id='$intro_banner_id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $banner_imageS = '';
        if(is_file($row['intro_banner_image'])){ $banner_imageS = $row['intro_banner_image']; } 

        $sql = "DELETE FROM intro_banner WHERE intro_banner_id='$intro_banner_id'";
        if($conn->query($sql) === TRUE){
            unlink($banner_imageS);
            header('Location: intro-banners.php?msg=Banner deleted!');
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Intro Banners | Salvo Ambulance</title>
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
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-sm-9">
                                        <h4>All Banners</h4>
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
                                                            <h5 class="modal-title" id="addAdminTitle">Add Banner</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                <label>Banner Image( 564 * 564 )</label>
																	 <input type="file" name="image" id="image" class="form-control" >

                                                                    <!-- <input type="text" name="banner_image" id="banner" class="form-control" placeholder="Banner Url" autocomplete="off"> -->
                                                                </div>
                                                                <div class="col-sm-6">
                                                                <label>Banner Content</label>
                                                                <input type="text" name="banner_content" id="banner_content" class="form-control" placeholder="Banner Content" autocomplete="off">
                                                                   
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                                                            <button type="submit" name="add" onclick="return bannerAdd()" class="btn btn-primary">Add</button>
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
                                                <th class="text-center">Banner</th>
                                                <th class="text-center">Content</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $sql = "SELECT * FROM intro_banner";
                                                $result = $conn->query($sql);
                                                $count = 0;
                                                while($row = $result->fetch_assoc()){
                                                    $intro_banner_id = $row['intro_banner_id'];

                                                    $status = '';
                                                    if($row['intro_banner_status'] == 1){
                                                        $status = 'checked';
                                                    }
                                                 
                                            ?>
                                                <tr>
                                                    <td class="text-center"><?php echo ++$count ?></td>
                                                    <td class="text-center"><img style="width: 200px" src="<?php echo $row["intro_banner_image"] ?>"></td>
                                                    <td class="text-center"><?php echo $row["intro_banner_content"] ?></td>
                                                    <td class="text-center">
                                                        <label class="switch s-icons s-outline s-outline-success mr-2" style="margin-bottom: 0px !important">
                                                            <input type="checkbox" id="S<?php echo $intro_banner_id ?>" <?php echo $status ?> onclick="return introBannerStatus(<?php echo  $intro_banner_id ?>)">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
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
                                                                                    <h5 class="modal-title" id="addAdminTitle<?php echo $count ?>">Edit Banner</h5>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="row">
                                                                                        <div class="col-sm-5">
                                                                                        <label>Banner Image( 564 * 564 )</label>
																	                            <input type="file" name="image" id="image<?php echo $count ?>" class="form-control" >
                                                                                            <!-- <input type="text" name="banner_image" id="banner<?php echo $count ?>" class="form-control" placeholder="Banner Url" autocomplete="off" value="<?php echo $row['intro_banner_image'] ?>"> -->
                                                                                        </div>
                                                                                        <div class="col-sm-1 mt-4">
                                                                                            <img style="width: 40px;height:40px" src="<?php echo $row["intro_banner_image"] ?>">
                                                                                         </div>
                                                                                        <div class="col-sm-6">
                                                                                        <label>Banner Content</label>
                                                                                            <input type="text" name="banner_content" id="banner_content<?php echo $count ?>" class="form-control" placeholder="Banner Content" autocomplete="off"  value="<?php echo $row['intro_banner_content'] ?>">
                                                                                        </div>
                                                                                    </div>
                                                                                   
                                                                                    <input type="hidden" name="intro_banner_id" value="<?php echo $intro_banner_id ?>">
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                                                                                    <button type="submit" name="edit" onclick="return bannerEdit(<?php echo $intro_banner_id ?>)" class="btn btn-primary">Save</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <a data-toggle="modal" data-target="#deleteAdmin<?php echo $count ?>">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle text-danger"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                                                                </a>
                                                                <div class="modal fade" id="deleteAdmin<?php echo $count ?>" tabindex="-1" role="dialog" aria-labelledby="addAdminTitle" style="display: none;" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                                        <div class="modal-content">
                                                                            <form method="post">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="addAdminTitle">Delete Banner</h5>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <p class="modal-text">Are you sure to delete this banner!</p>
                                                                                    <input type="hidden" name="intro_banner_id" value="<?php echo $intro_banner_id ?>">
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button class="btn" data-dismiss="modal"> No</button>
                                                                                    <button type="submit" name="delete" class="btn btn-danger">Delete</button>
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