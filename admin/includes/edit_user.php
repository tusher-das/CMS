<?php
if (isset($_GET['edit_user'])) {
    $the_user_id = $_GET['edit_user'];

    $query                = "SELECT * FROM users WHERE user_id = $the_user_id";
    $select_a_users_query = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($select_a_users_query)) {
        $user_id        = $row['user_id'];
        $username       = $row['username'];
        $user_password  = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname  = $row['user_lastname'];
        $user_email     = $row['user_email'];
        $user_image     = $row['user_image'];
        $user_role      = $row['user_role'];
    }

}

if (isset($_POST['edit_user'])) {
    $user_firstname = $_POST['user_firstname'];
    $user_lastname  = $_POST['user_lastname'];
    $user_role      = $_POST['user_role'];
    $username       = $_POST['username'];
    $user_email     = $_POST['user_email'];
    $user_password  = $_POST['user_password'];

    // encrypted password
    $password = encryptPassword($user_password);

    $query = "UPDATE users SET ";
    $query .= "user_firstname = '{$user_firstname}', ";
    $query .= "user_lastname = '{$user_lastname}', ";
    $query .= "user_role = '{$user_role}', ";
    $query .= "username = '{$username}', ";
    $query .= "user_email = '{$user_email}', ";
    $query .= "user_password = '{$password}' ";
    $query .= "WHERE user_id = {$the_user_id}";

    $update_user_query = mysqli_query($connection, $query);
    confirm_query($update_user_query);
    header("Location: users.php");

}
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="user_firstname">Firstname </label>
        <input type="text" name="user_firstname" class="form-control" value="<?php echo $user_firstname; ?>">
    </div>
    <div class="form-group">
        <label for="user_lastname">Lastname</label>
        <input type="text" name="user_lastname" class="form-control" value="<?php echo $user_lastname; ?>">
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
        <input type="email" name="user_email" class="form-control" value="<?php echo $user_email; ?>">
    </div>
    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" name="user_password" class="form-control" value="<?php echo $user_password; ?>">
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="edit_user" value="UPDATE USER">
    </div>
</form>