<!-- Database connection -->
<?php include('includes/db.php'); ?>

<!-- HTML header -->
<?php include('includes/header.php'); ?>

<!-- Navigation -->
<?php include('includes/navigation.php'); ?>

<!-- Email sending related work -->
<?php
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
                <h1 class="text-center">LET'S GET IN TOUCH!</h1>
                <form action="" method="post" role="form" id="login-form" autocomplete="off">
                    <div class="form-group">
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter your name">
                    </div>
                    <div class="form-group">
                        <input type="text" name="subject" id="subject" class="form-control"
                            placeholder="Enter your subject">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="body" id="body" cols="30" rows="10"
                            placeholder="Your message..."></textarea>
                    </div>
                    <!-- <input type="submit" value="SEND" name="submit" id="btn-login"
                        class="btn btn-primary btn-lg btn-block"> -->
                    <button class="btn btn-primary btn-lg btn-block" type="submit" name="submit" id="btn-login">SEND <i
                            class="fa-sharp fa-solid fa-paper-plane"></i></button>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include('includes/footer.php'); ?>