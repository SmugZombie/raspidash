<?php

require('common/config.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $CONFIG['software_name'] . " " . $CONFIG['software_version']; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="./common/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./common/css/simple-sidebar.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper" class='toggled'>

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                        <?php echo $CONFIG['software_name'] . " " . $CONFIG['software_version']; ?>
                    </a>
                </li>
                <li>
                    <a href="./">Dashboard</a>
                </li>
                <li>
                    <a href="./preview">Preview</a>
                </li>
                <li>
                    <a href="./overview">Overview</a>
                </li>
                <li>
                    <a href="./videos">Videos</a>
                </li>
                <li>
                    <a href="./service">Service</a>
                </li>
                <li>
                    <a href="./about">About</a>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <?php

                    $page = $_GET['page'];
                    $pages = ["preview","dashboard","overview","service","about","videos"];

                    if(in_array($page, $pages)){

                            include("$page"."_.php");

                    }
                    elseif($page == ""){
                            include("dashboard"."_.php");
                    }
                    else{
                        ?>

                            <h1><?php echo $CONFIG['software_name']; ?> - 404 Page</h1>
            <p>Uhoh. This page doesn't exist.</p>

                        <?php
                    }


                ?>
                <!-- <a href="#menu-toggle" class="btn btn-secondary" id="menu-toggle">Toggle Menu</a> -->
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Bootstrap core JavaScript -->
    <script src="./common/vendor/jquery/jquery.min.js"></script>
    <script src="./common/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>

</body>

</html>
