<?php include("includes/admin_header.php"); ?>
<?php
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $query            = "SELECT * FROM users WHERE username = '{$username}'";
    $select_user_info = mysqli_query($connection, $query);

    confirm_query($select_user_info);

    while ($row = mysqli_fetch_assoc($select_user_info)) {
        $user_id        = $row['user_id'];
        $user_name      = $row['username'];
        $user_password  = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname  = $row['user_lastname'];
        $user_email     = $row['user_email'];
        // $user_image     = $row['user_image'];
        $user_role = $row['user_role'];
    }
}
?>

<?php
if (isset($_POST['update_profile'])) {
    $user_firstname = $_POST['user_firstname'];
    $user_lastname  = $_POST['user_lastname'];
    $user_role      = $_POST['user_role'];
    $user_email     = $_POST['user_email'];
    $user_password  = $_POST['user_password'];

    $query = "UPDATE users SET ";
    $query .= "user_firstname = '{$user_firstname}', ";
    $query .= "user_lastname = '{$user_lastname}', ";
    $query .= "user_role = '{$user_role}', ";
    $query .= "user_email = '{$user_email}', ";
    $query .= "user_password = '{$user_password}' ";
    $query .= "WHERE username = '{$username}'";

    $update_user_query = mysqli_query($connection, $query);
    confirm_query($update_user_query);
    header("Location: users.php");

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

                <div class="col-lg-12">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="user_firstname">Firstname </label>
                            <input type="text" name="user_firstname" class="form-control"
                                value="<?php echo $user_firstname; ?>">
                        </div>
                        <div class="form-group">
                            <label for="user_lastname">Lastname</label>
                            <input type="text" name="user_lastname" class="form-control"
                                value="<?php echo $user_lastname; ?>">
                        </div>
                        <div class=" form-group">
                            <label for="user_role">Role</label>
                            <select name="user_role" class="form-control">
                                <option value="<?php echo $user_role; ?>">
                                    <?php echo $user_role; ?>
                                </option>
                                <?php
                                if ($user_role == 'admin') {
                                    echo "<option value='subscriber'>subscriber</option>";
                                } else {
                                    echo "<option value='admin'>admin</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                        </div>

                        <div class="form-group">
                            <label for="user_email">Email</label>
                            <input type="email" name="user_email" class="form-control"
                                value="<?php echo $user_email; ?>">
                        </div>
                        <div class="form-group">
                            <label for="user_password">Password</label>
                            <input type="password" name="user_password" class="form-control"
                                value="<?php echo $user_password; ?>">
                        </div>

                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" name="update_profile" value="UPDATE PROFILE">
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<?php include("includes/admin_footer.php") ?>