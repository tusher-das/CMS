<!-- Database connection -->
<?php include('includes/db.php'); ?>

<!-- HTML header -->
<?php include('includes/header.php'); ?>

<!-- Navigation -->
<?php include('includes/navigation.php'); ?>

<!-- mail send related work -->
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require './vendor/autoload.php';

?>

<?php

if (!isset($_GET['forgot'])) {
    redirect('index');
}

if (ifItIsMethod('post')) {
    if (isset($_POST['email'])) {
        $email = $_POST['email'];

        $length = 50;
        $token  = bin2hex(openssl_random_pseudo_bytes($length));

        if (isExistsEmail($email)) {
            if ($stmt = mysqli_prepare($connection, "UPDATE users SET token='{$token}' WHERE user_email= ?")) {
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                //cofigure PHPMailer
                $mail = new PHPMailer(true);

                $mail->isSMTP();
                $mail->Host       = Config::SMPT_HOST;
                $mail->Username   = Config::SMTP_USER;
                $mail->Password   = Config::SMTP_PASSWORD;
                $mail->Port       = Config::SMTP_PORT;
                $mail->SMTPSecure = 'tls';
                $mail->SMTPAuth   = true;
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';

                $mail->setFrom('tusherajoy@gmail.com', 'Tusher');
                $mail->addAddress($email);

                $mail->Subject = 'This is test email';
                $mail->Body    = "
                <p>Please click to reset your password
                <a href='http://localhost/cms/reset.php?email=$email&token=$token'>RESET PASSWORD</a>
                </p>";

                if ($mail->send()) {
                    $emailSent = true;
                } else {
                    $emailSent = false;
                }
            } else {
                echo mysqli_error($connection);
            }
        } else {
            echo "Wrong Email! Can not find any account.";
        }
    }
}

?>

<div class="container">

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">

                            <?php if (!isset($emailSent)): ?>

                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">

                                    <form method="post" role="form" id="login-form" autocomplete="off">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa-solid fa-envelope"></i></span>
                                                <input type="text" id="email" name="email" placeholder="email address"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" name="recover-submit" value="RECOVER"
                                                class="btn btn-sm btn-custom">
                                        </div>
                                        <input type="hidden" class="hide" name="token">
                                    </form>

                                </div> <!--Body -->

                            <?php else: ?>

                                <h3>Please check your email</h3>

                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>
    <!-- Footer -->
    <?php include("includes/footer.php"); ?>