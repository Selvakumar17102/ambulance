<?php
    ini_set('display_errors','off');
    include('include/connection.php');
    $banner = 'active';
    $bannerBoolean = 'true';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Banner Arrangement | Salvo Ambulance</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"/>

    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />

    <link href="plugins/drag-and-drop/dragula/dragula.css" rel="stylesheet" type="text/css" />
    <link href="plugins/drag-and-drop/dragula/example.css" rel="stylesheet" type="text/css" />
</head>
<body class="sidebar-noneoverflow">
    <?php include('include/header.php') ?>
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="cs-overlay"></div>
        <div class="search-overlay"></div>

        <?php include('include/sidebar.php') ?>

        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <div class="row" id="cancel-row">
                    <div class="col-lg-12 layout-spacing layout-top-spacing">
                        <?php include('include/notification.php') ?>
                        <div class="container">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header">
                                    <div class="row">
                                        <div class="col-xl-10 col-md-10 col-sm-10 col-10">
                                            <h4>Banner Arrangement</h4>
                                        </div>
                                        <div class="col-xl-2 col-md-2 col-sm-2 col-2">
                                            <a href="banners.php" class="btn btn-dark float-right mt-2">Back</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area">

                                    <div class='parent ex-1'>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div id='left-defaultsBanner' class='dragula'>
                                                    <?php
                                                        $sql = "SELECT * FROM banner ORDER BY banner_arrangement ASC";
                                                        $result = $conn->query($sql);
                                                        while($row = $result->fetch_assoc()){
                                                            $category_id = $row['category_id'];

                                                            $sql1 = "SELECT category_name FROM category WHERE category_id='$category_id'";
                                                            $result1 = $conn->query($sql1);
                                                            $row1 = $result1->fetch_assoc();

                                                            $status = 'Top';
                                                            if($row['banner_location'] == 1){
                                                                $status = 'Bottom';
                                                            }
                                                    ?>
                                                            <div class="checking media d-md-flex d-block text-sm-left text-center" id="<?php echo $row['banner_id'] ?>">
                                                                <img alt="avatar" src="<?php echo $row['banner_image'] ?>" class="img-fluid ">
                                                                <div class="media-body">
                                                                    <div class="d-xl-flex d-block justify-content-between">
                                                                        <div class="">
                                                                            <h6 class=""><?php echo $status ?></h6>
                                                                            <p class=""><?php echo $row1['category_name'] ?></p>
                                                                        </div>
                                                                        <div>
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-move"><polyline points="5 9 2 12 5 15"></polyline><polyline points="9 5 12 2 15 5"></polyline><polyline points="15 19 12 22 9 19"></polyline><polyline points="19 9 22 12 19 15"></polyline><line x1="2" y1="12" x2="22" y2="12"></line><line x1="12" y1="2" x2="12" y2="22"></line></svg>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php include('include/footer.php') ?>
    </div>

    <script src="assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="bootstrap/js/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/app.js"></script>
    <script>
        Array.prototype.move = function (from, to) {
            this.splice(to, 0, this.splice(from, 1)[0]);
        };

        var ar = [1,2,3,4,5];
    </script>
    <script>
        $(document).ready(function() {
            App.init();
        });
        function arrangeBanner(banner_id,value){
            console.log(banner_id);
            $.ajax({
                type: "POST",
                url: "ajax/arrangeBanner.php",
                data:{'banner_id':banner_id,'value':value},
                success: function(data){
                    // console.log(data);
                    return data;
                }
            });
        }
    </script>
    <script src="plugins/highlight/highlight.pack.js"></script>
    <script src="assets/js/manual.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="plugins/drag-and-drop/dragula/dragula.min.js"></script>
    <script src="plugins/drag-and-drop/dragula/custom-dragula.js"></script>

</body>
</html>