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

        $user_image = $row['user_image'];
        if (empty($user_image)) {
            $user_image = 'noImage.jpg';
        }

        $user_role = $row['user_role'];
    }
}
?>
<?php
if (isset($_POST['update_profile'])) {
    $user_image      = $_FILES['user_image']['name'];
    $user_image_temp = $_FILES['user_image']['tmp_name'];
    move_uploaded_file($user_image_temp, "../images/profile/$user_image");
    if (empty($user_image)) {
        $query              = "SELECT * FROM users WHERE user_id = $user_id";
        $select_image_query = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($select_image_query)) {
            $user_image = $row['user_image'];
        }
    }

    $user_firstname = $_POST['user_firstname'];
    $user_lastname  = $_POST['user_lastname'];
    $user_email     = $_POST['user_email'];
    $username       = $_POST['username'];



    $query = "UPDATE users SET ";
    $query .= "username = '{$username}', ";
    $query .= "user_firstname = '{$user_firstname}', ";
    $query .= "user_lastname = '{$user_lastname}', ";
    $query .= "user_role = '{$user_role}', ";
    $query .= "user_image = '{$user_image}', ";
    $query .= "user_email = '{$user_email}', ";
    $query .= "user_password = '{$user_password}' ";
    $query .= "WHERE user_id = '{$user_id}'";

    $update_user_query = mysqli_query($connection, $query);
    confirm_query($update_user_query);


    $_SESSION['username']  = $username;
    $_SESSION['firstname'] = $user_firstname;
    $_SESSION['lastname']  = $user_lastname;

    header("Location: profile.php");

}
?>

<div class="col-lg-12">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="user_image">User Image</label>
            <img src="../images/profile/<?php echo $user_image; ?>"
                style="width:100px; height:100px; border-radius: 50px;" alt="">
            <div
                style="background: #00B4FF; width:32px; height:32px; line-height:33px; overflow:hidden; text-align:center; border-radius:50%; position:absolute; top:6rem; left:15rem;">
                <input type="file" name="user_image" style="position:absolute; transform:scale(2); opacity:0;">
                <i class="fa fa-camera" style="color:#fff;"></i>
            </div>
        </div>
        <div class="form-group">
            <label for="user_firstname">Firstname </label>
            <input type="text" name="user_firstname" class="form-control" value="<?php echo $user_firstname; ?>">
        </div>
        <div class="form-group">
            <label for="user_lastname">Lastname</label>
            <input type="text" name="user_lastname" class="form-control" value="<?php echo $user_lastname; ?>">
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
        </div>

        <div class="form-group">
            <label for="user_email">Email</label>
            <input type="email" name="user_email" class="form-control" value="<?php echo $user_email; ?>">
        </div>

        <div class="form-group">
            <input class="btn btn-warning" type="submit" name="update_profile" value="UPDATE PROFILE">
        </div>
    </form>
</div>