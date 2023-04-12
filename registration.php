<?php include("includes/db.php"); ?>
<?php include("includes/header.php"); ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    $error = [
        'username' => '',
        'email'    => '',
        'password' => ''
    ];

    // username validation
    if (strlen($username) < 4) {
        $error['username'] = 'Username needs to be longer then 3 character!';
    }
    if ($username == '') {
        $error['username'] = 'Username cannot be empty!';
    }
    if (isExistsUsername($username)) {
        $error['username'] = 'Username already exists, pick another one!';
    }

    // email validation
    if ($email == '') {
        $error['email'] = 'email cannot be empty!';
    }
    if (isExistsEmail($email)) {
        $error['email'] = 'email already exists, <a href="index.php">Login here</a>';
    }

    if ($password == '') {
        $error['password'] = 'Password cannot be empty!';
    }

    foreach ($error as $key => $value) {
        if (empty($value)) {
            unset($error[$key]);
        }
    } //foreach

    //user registration
    if (empty($error)) {
        registerUser($username, $email, $password);
        loginUser($username, $password);
    }
} else {
    $message = "";
}
?>

<!-- Navigation -->
<?php include("includes/navigation.php"); ?>

<!-- page content -->
<div class="container">
    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1 class="text-center">Registration</h1>
                        <form action="registration.php" method="post" role="form" id="login-form" autocomplete="off">
                            <h6 class="text-center">
                            </h6>
                            <div class="form-group">
                                <label for="username" class="sr-only">Username</label>
                                <input type="text" name="username" id="username" class="form-control"
                                    placeholder="Enter Desired Username" autocomplete="on"
                                    value="<?php echo isset($username) ? $username : '' ?>">
                                <p>
                                    <?php echo isset($error['username']) ? $error['username'] : '' ?>
                                </p>
                            </div>

                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="somebody@example.com" autocomplete="on"
                                    value="<?php echo isset($email) ? $email : '' ?>">

                                <p>
                                    <?php echo isset($error['email']) ? $error['email'] : '' ?>
                                </p>
                            </div>

                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" name="password" id="key" class="form-control"
                                    placeholder="Enter Password">
                                <p>
                                    <?php echo isset($error['password']) ? $error['password'] : '' ?>
                                </p>
                            </div>
                            <button class="btn btn-custom btn-lg btn-block" type="submit" name="submit"
                                id="btn-login">Register <i class="fa-solid fa-right-to-bracket"></i></button>
                        </form>
                        <br>
                        <small>Already have an account ? <a href="/cms/login">login now</a></small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr>

    <?php include("includes/footer.php"); ?>