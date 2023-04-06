<?php include("includes/admin_header.php"); ?>

<?php

if (!isAdmin($_SESSION['username'])) {
    header("Location: index.php");
}

?>

<div id="wrapper">

    <!-- Navigation -->
    <?php include("includes/admin_navigation.php"); ?>

    <div id="page-wrapper">
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <?php include("includes/admin_heading.php"); ?>

                <?php
                if (isset($_GET['source'])) {
                    $source = $_GET['source'];
                } else {
                    $source = "";
                }

                switch ($source) {
                    case 'add_user':
                        include("includes/add_user.php");
                        break;
                    case 'edit_user':
                        include("includes/edit_user.php");
                        break;
                    case '200':
                        echo "NICE 200";
                        break;
                    default:
                        include("includes/view_all_users.php");
                        break;
                }

                ?>

            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<?php include("includes/admin_footer.php") ?>