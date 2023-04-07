<?php include("includes/db.php"); ?>
<?php include("includes/header.php"); ?>

<?php

if (!isset($_GET['email']) && !isset($_GET['token'])) {
    redirect('index');
}

$email = $_GET['email'];
$token = $_GET['token'];

if ($stmt = mysqli_prepare($connection, "SELECT username, user_email, token FROM users WHERE token= ?")) {
    mysqli_stmt_bind_param($stmt, "s", $token);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $username, $user_email, $token);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($_GET['token'] !== $token || $_GET['email'] !== $user_email) {
        redirect('index');
    }

    if (isset($_POST['password']) && isset($_POST['confirmPassword'])) {
        if ($_POST['password'] === $_POST['confirmPassword']) {
            $password = $_POST['password'];

            // password encryption related work
            $query                 = "SELECT randSalt FROM users";
            $select_randsalt_query = mysqli_query($connection, $query);
            confirm_query($select_randsalt_query);
            $row  = mysqli_fetch_array($select_randsalt_query);
            $salt = $row['randSalt'];

            $hash_password = crypt($password, $salt); //encrypted password

            if ($stmt = mysqli_prepare($connection, "UPDATE users SET token='', user_password= '{$hash_password}' WHERE user_email = ?")) {
                mysqli_stmt_bind_param($stmt, "s", $_GET['email']);
                mysqli_stmt_execute($stmt);
                if (mysqli_stmt_affected_rows($stmt) >= 1) {
                    redirect('/cms/login.php');
                }
                mysqli_stmt_close($stmt);
            }
        }
    }

}

?>

<!-- Navigation -->
<?php include("includes/navigation.php"); ?>

<div class="container">

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">

                            <h3><i class="fa fa-lock fa-4x"></i></h3>
                            <h2 class="text-center">Reset Password</h2>
                            <p>You can reset your password here.</p>
                            <div class="panel-body">

                                <form method="post" role="form" id="registration-form" autocomplete="off">

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa-solid fa-user"></i></span>
                                            <input type="password" id="password" name="password"
                                                placeholder="Enter password" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa-solid fa-check"></i></span>
                                            <input type="password" id="password" name="confirmPassword"
                                                placeholder="Confirm password" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" name="recover-submit" value="RESET"
                                            class="btn btn-sm btn-primary">
                                    </div>
                                    <input type="hidden" class="hide" name="token">
                                </form>

                            </div> <!--Body -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>
</div>