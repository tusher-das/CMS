<?php
if (ifItIsMethod('post')) {
    if (isset($_POST['login'])) {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            loginUser($_POST['username'], $_POST['password']);
        } else {
            redirect('index');
        }
    }
}
?>

<div class="col-md-4">

    <!-- Login -->
    <div class="well">
        <?php if (isset($_SESSION['user_role'])): ?>

            <h4>Logged in as
                <?php echo $_SESSION['username']; ?>
            </h4>
            <a href="includes/logout.php" class="btn btn-custom">Logout <i class="fa-solid fa-right-from-bracket"></i></a>

        <?php else: ?>
            <h4>Login</h4>
            <form method="post">
                <div class="form-group">
                    <input type="text" name="username" placeholder="Enter Username" class="form-control">
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Enter Password" class="form-control">
                    <span class="input-group-btn">
                        <button class="btn btn-custom" name="login" type="submit">Login</button></span>
                </div>
                <br>
                <a href="forgot_password.php?forgot=<?php echo uniqid(true); ?>">Forgot
                    Password</a>
            </form><!--Login form-->

        <?php endif; ?>
    </div>

    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <?php
                    $query                = "SELECT * FROM categories";
                    $all_categories_query = mysqli_query($connection, $query);

                    while ($row = mysqli_fetch_assoc($all_categories_query)) {
                        $cat_id    = $row['cat_id'];
                        $cat_title = $row['cat_title'];
                        echo "<li><a href='/cms/category/$cat_id'>{$cat_title}</a></li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <?php include("widget.php"); ?>

</div>