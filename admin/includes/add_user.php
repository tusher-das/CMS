<?php
if (isset($_POST['create_user'])) {
    $user_firstname = $_POST['user_firstname'];
    $user_lastname  = $_POST['user_lastname'];
    $user_role      = $_POST['user_role'];

    // $post_image      = $_FILES['post_image']['name'];
    // $post_image_temp = $_FILES['post_image']['tmp_name'];

    $username      = $_POST['username'];
    $user_email    = $_POST['user_email'];
    $user_password = $_POST['user_password'];

    // move_uploaded_file($post_image_temp, "../images/$post_image");


    $password = encryptPassword($user_password);

    $query = "INSERT INTO `users` (`user_id`, `user_firstname`, `user_lastname`, `user_role`, `username`, `user_email`, `user_password`) VALUES (NULL, '{$user_firstname}', '{$user_lastname}', '{$user_role}', '{$username}', '{$user_email}', '{$password}')";

    $create_user_query = mysqli_query($connection, $query);

    confirm_query($create_user_query);
    header("Location: users.php");

}
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="user_firstname">Firstname </label>
        <input type="text" name="user_firstname" class="form-control">
    </div>
    <div class="form-group">
        <label for="user_lastname">Lastname</label>
        <input type="text" name="user_lastname" class="form-control">
    </div>
    <div class="form-group">
        <label for="user_role">Role</label>
        <select name="user_role" class="form-control">
            <option value="subscriber">Select Options</option>
            <option value="admin">Admin</option>
            <option value="subscriber">Subscriber</option>
        </select>
    </div>
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" class="form-control">
    </div>

    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" name="user_email" class="form-control">
    </div>
    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" name="user_password" class="form-control">
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_user" value="ADD USER">
    </div>
</form>