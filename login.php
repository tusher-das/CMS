<!-- Database connection -->
<?php include('includes/db.php'); ?>

<!-- HTML header -->
<?php include('includes/header.php'); ?>

<!-- Navigation -->
<?php include('includes/navigation.php'); ?>

<?php
checkIfUserIsLoggedInAndRedirect('/cms/admin');
if (ifItIsMethod('post')) {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        loginUser($_POST['username'], $_POST['password']);
    } else {
        redirect('/cms/login.php');
    }
}
?>

<!-- page content -->
<div class="container">

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">

                            <h3><i class="fa fa-user fa-4x"></i></h3>
                            <h2 class="text-center">Login</h2>
                            <div class="panel-body">
                                <form action="" method="post" role="form" id="login-form" autocomplete="off">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa-solid fa-user"></i></span>
                                            <input type="text" name="username" class="form-control"
                                                placeholder="Enter username" id="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa-solid fa-lock"></i></span>
                                            <input type="password" name="password" class="form-control"
                                                placeholder="Enter password" id="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button class="btn btn-custom btn-lg btn-block" type="submit" name="login"
                                            id="btn-login">Login <i class="fa-solid fa-right-to-bracket"></i></button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div> <!-- ./panel -->
            </div>
        </div>
    </div>



    <hr>

    <?php include("includes/footer.php"); ?>