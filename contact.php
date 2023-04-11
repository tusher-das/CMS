<?php include("includes/db.php"); ?>
<?php include("includes/header.php"); ?>

<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require './vendor/autoload.php';

?>

<?php

if (isset($_POST['submit'])) {
    $name    = $_POST['name'];
    $subject = wordwrap($_POST['subject'], 70);
    $body    = $_POST['body'];

    if (!empty($name) && !empty($subject) && !empty($body)) {
        $subject = mysqli_real_escape_string($connection, $subject);
        $body    = mysqli_real_escape_string($connection, $body);
        $name    = mysqli_real_escape_string($connection, $name);

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

        $mail->setFrom('tusherajoy@gmail.com', $name);
        $mail->addAddress('tusherajoy@gmail.com');

        $mail->Subject = $subject;
        $mail->Body    = $body;

        if ($mail->send()) {
            $emailSent = true;
        } else {
            $emailSent = false;
        }

    }

}
?>

<!-- Navigation -->
<?php include("includes/navigation.php"); ?>

<!-- page content -->
<div class="container">
    <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
            <div class="form-wrap">
                <?php
                if (isset($emailSent)) {
                    if ($emailSent === true) {
                        echo "<div class='alert alert-success'><strong>Well done!</strong> you successfully send the message.</div>";
                    } else {
                        echo "<div class='alert alert-danger'><strong>Oh snap!</strong> Change a few things up and try submitting again.</div>";
                    }
                }
                ?>
                <h1 class="text-center">Contact</h1>
                <form action="" method="post" role="form" id="login-form" autocomplete="off">
                    <div class="form-group">
                        <label for="name" class="sr-only">Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter your name">
                    </div>
                    <div class="form-group">
                        <label for="subject" class="sr-only">Subject</label>
                        <input type="text" name="subject" id="subject" class="form-control"
                            placeholder="Enter your subject">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="body" id="body" cols="30" rows="10"></textarea>
                    </div>
                    <input type="submit" value="SEND" name="submit" id="btn-login"
                        class="btn btn-primary btn-lg btn-block">
                </form>
            </div>
        </div>
    </div>
</div>

<hr>

<?php include("includes/footer.php"); ?>