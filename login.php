<?php include("includes/db.php"); ?>
<?php include("includes/header.php"); ?>

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

<!-- Navigation -->
<?php include("includes/navigation.php"); ?>
<!-- page content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-xs-4 col-md-offset-4">
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
                                        <input type="submit" value="LOGIN" name="login" id="btn-login"
                                            class="form-control btn btn-lg btn-primary">
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div> <!-- panel -->
            </div>
        </div>
    </div>

</div>

<hr>

<?php include("includes/footer.php"); ?>