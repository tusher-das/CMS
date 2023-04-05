<?php include("includes/db.php"); ?>
<?php include("includes/header.php"); ?>

<?php

if (isset($_POST['submit'])) {
    $email   = $_POST['email'];
    $subject = wordwrap($_POST['subject'], 70);
    $body    = $_POST['body'];

    $subject = mysqli_real_escape_string($connection, $subject);
    $body    = mysqli_real_escape_string($connection, $body);
    $to      = "tusherajoy@gmail.com";

    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'From: ' . $email . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    mail($to, $subject, $body, $headers);

}
?>

<!-- Navigation -->
<?php include("includes/navigation.php"); ?>

<!-- page content -->
<div class="container">
    <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
            <div class="form-wrap">
                <h1>Contact</h1>
                <form action="" method="post" role="form" id="login-form" autocomplete="off">
                    <div class="form-group">
                        <label for="email" class="sr-only">Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email">
                    </div>
                    <div class="form-group">
                        <label for="subject" class="sr-only">Subject</label>
                        <input type="text" name="subject" id="subject" class="form-control"
                            placeholder="Enter your subject">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="body" id="body" cols="30" rows="10"></textarea>
                    </div>
                    <input type="submit" value="Submit" name="submit" id="btn-login"
                        class="btn btn-custom btn-lg btn-block">
                </form>
            </div>
        </div>
    </div>
</div>

<hr>

<?php include("includes/footer.php"); ?>