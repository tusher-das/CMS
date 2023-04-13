<table class="table table-hover table-bordered">
    <thead>
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query        = "SELECT * FROM users";
        $select_users = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($select_users)) {
            $user_id        = $row['user_id'];
            $user_name      = $row['username'];
            $user_password  = $row['user_password'];
            $user_firstname = $row['user_firstname'];
            $user_lastname  = $row['user_lastname'];
            $user_email     = $row['user_email'];
            $user_image     = $row['user_image'];
            $user_role      = $row['user_role'];

            echo "<tr>";
            echo "<td>{$user_id}</td>";
            echo "<td>{$user_name}</td>";
            echo "<td>{$user_firstname}</td>";
            echo "<td>{$user_lastname}</td>";
            echo "<td>{$user_email}</td>";
            echo "<td>{$user_role}</td>";
            echo "<td><a href='users.php?change_to_admin=$user_id' class='btn btn-success'>ADMIN</a></td>";
            echo "<td><a href='users.php?change_to_sub=$user_id' class='btn btn-info'>SUBSCRIBER</a></td>";
            echo "<td><a href='users.php?source=edit_user&edit_user=$user_id' class='btn btn-warning'>EDIT</a></td>";
            echo "<td><a href='users.php?delete=$user_id' class='btn btn-danger'>DELETE</a></td>";
            echo "</tr>";
        }
        ?>

    </tbody>
</table>

<?php

if (isset($_GET['change_to_admin'])) {
    $the_user_id           = $_GET['change_to_admin'];
    $query                 = "UPDATE users SET user_role = 'admin' WHERE user_id = $the_user_id";
    $make_admin_user_query = mysqli_query($connection, $query);
    confirm_query($make_admin_user_query);
    $_SESSION['user_role'] = 'admin';
    header("Location: users.php");
}


if (isset($_GET['change_to_sub'])) {
    $the_user_id         = $_GET['change_to_sub'];
    $query               = "UPDATE users SET user_role = 'subscriber' WHERE user_id = $the_user_id";
    $make_sub_user_query = mysqli_query($connection, $query);
    confirm_query($make_sub_user_query);
    $_SESSION['user_role'] = 'subscriber';
    header("Location: users.php");
}


if (isset($_GET['delete'])) {
    if (isset($_SESSION['user_role'])) {
        if ($_SESSION['user_role'] == 'admin') {
            $the_user_id       = mysqli_real_escape_string($connection, $_GET['delete']);
            $query             = "DELETE FROM users WHERE user_id = $the_user_id";
            $delete_user_query = mysqli_query($connection, $query);
            confirm_query($delete_user_query);
            header("Location: users.php");
        } else {
            echo "YOU are not an Admin!";
        }
    } else {
        echo "Not working";
    }

}
?>