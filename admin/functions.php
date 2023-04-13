<?php

function redirect($location)
{
    header("Location: " . $location);
    // exit;
}

function ifItIsMethod($method = null)
{
    if ($_SERVER['REQUEST_METHOD'] == strtoupper($method)) {
        return true;
    }
    return false;
}

function isLoggedIn()
{
    if (isset($_SESSION['user_role'])) {
        return true;
    }

    return false;
}
function checkIfUserIsLoggedInAndRedirect($redirectLocation = null)
{
    if (isLoggedIn()) {
        redirect($redirectLocation);
    }
}

function users_online()
{
    if (isset($_GET['onlineusers'])) {
        global $connection;
        if (!$connection) {
            session_start();
            include("../includes/db.php");

            $session             = session_id();
            $time                = time();
            $time_out_in_seconds = 30;
            $time_out            = $time - $time_out_in_seconds;

            $query      = "SELECT * FROM users_online WHERE session = '$session'";
            $send_query = mysqli_query($connection, $query);
            $count      = mysqli_num_rows($send_query);

            if ($count == NULL) {
                mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session','$time')");
            } else {
                mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
            }

            $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
            echo $count_user = mysqli_num_rows($users_online_query);

        }

    } //get request isset()

}
users_online();

function confirm_query($result)
{
    global $connection;
    if (!$result) {
        die("Query Failed " . mysqli_error($connection));
    }
}

function insert_categories()
{
    global $connection;

    if (isset($_POST['submit'])) {
        $cat_title = $_POST['cat_title'];
        if ($cat_title == "" || empty($cat_title)) {
            echo "<span class='text-danger'> *Category title is required!</span>";
        } else {
            $stmt = mysqli_prepare($connection, "INSERT INTO categories(cat_title) VALUE(?)");
            mysqli_stmt_bind_param($stmt, 's', $cat_title);
            mysqli_stmt_execute($stmt);
            if (!$stmt) {
                die("Query Failed " . mysqli_error($connection));
            }

            mysqli_stmt_close($stmt);
        }
    }
}

function show_all_categories()
{
    global $connection;
    $query          = "SELECT * FROM categories";
    $all_categories = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($all_categories)) {
        $cat_id    = $row['cat_id'];
        $cat_title = $row['cat_title'];
        echo "<tr>
                <td>{$cat_id}</td>
                <td>{$cat_title}</td>
                <td><a href='categories.php?edit={$cat_id}' class='btn btn-info'><i class='fa-solid fa-pen-to-square'></i></a></td>
                <td><a href='categories.php?delete={$cat_id}' class='btn btn-danger'><i class='fa-solid fa-trash'></i></a></td>
            </tr>";
    }
}

function delete_a_category()
{
    global $connection;
    if (isset($_GET['delete'])) {
        $the_cat_id      = $_GET['delete'];
        $query           = "DELETE FROM categories WHERE cat_id = {$the_cat_id}";
        $delete_category = mysqli_query($connection, $query);
        header("Location: categories.php");
    }
}

function tableCount($table_name)
{
    global $connection;
    $query            = "SELECT * FROM $table_name";
    $select_all_posts = mysqli_query($connection, $query);
    return mysqli_num_rows($select_all_posts);
}

function checkStatus($table, $column, $status)
{
    global $connection;
    $query  = "SELECT * FROM $table WHERE $column = '$status'";
    $result = mysqli_query($connection, $query);
    return mysqli_num_rows($result);

}

function isAdmin($username = '')
{
    global $connection;

    $query  = "SELECT user_role FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);
    confirm_query($result);

    $row = mysqli_fetch_array($result);
    if (mysqli_num_rows($result)) {
        if ($row['user_role'] == 'admin') {
            return true;
        } else {
            return false;
        }
    }
}

function isExistsUsername($username)
{
    global $connection;

    $query  = "SELECT username FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);
    confirm_query($result);

    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}
function isExistsEmail($email)
{
    global $connection;

    $query  = "SELECT user_email FROM users WHERE user_email = '$email'";
    $result = mysqli_query($connection, $query);
    confirm_query($result);

    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function encryptPassword($password)
{
    global $connection;
    // password encryption related work
    $query                 = "SELECT randSalt FROM users";
    $select_randsalt_query = mysqli_query($connection, $query);
    confirm_query($select_randsalt_query);
    $row  = mysqli_fetch_array($select_randsalt_query);
    $salt = $row['randSalt'];

    $password = crypt($password, $salt); //encrypted password

    return $password;
}

function registerUser($username, $email, $password)
{
    global $connection;
    $username = mysqli_real_escape_string($connection, $username);
    $email    = mysqli_real_escape_string($connection, $email);
    $password = mysqli_real_escape_string($connection, $password);

    // password encryption related work
    $query                 = "SELECT randSalt FROM users";
    $select_randsalt_query = mysqli_query($connection, $query);
    confirm_query($select_randsalt_query);
    $row  = mysqli_fetch_array($select_randsalt_query);
    $salt = $row['randSalt'];

    $password = crypt($password, $salt); //encrypted password

    $query               = "INSERT INTO users (username, user_email, user_password, user_role) ";
    $query .= "VALUES('{$username}','{$email}','{$password}','subscriber' )";
    $register_user_query = mysqli_query($connection, $query);

    confirm_query($register_user_query);
}

function loginUser($username, $password)
{
    global $connection;

    $username = trim($username);
    $password = trim($password);

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $query             = "SELECT * FROM users WHERE username = '{$username}' ";
    $select_user_query = mysqli_query($connection, $query);

    confirm_query($select_user_query);

    while ($row = mysqli_fetch_assoc($select_user_query)) {
        $db_user_id        = $row['user_id'];
        $db_username       = $row['username'];
        $db_user_password  = $row['user_password'];
        $db_user_firstname = $row['user_firstname'];
        $db_user_lastname  = $row['user_lastname'];
        $db_user_role      = $row['user_role'];

        $password = crypt($password, $db_user_password);

        if ($username === $db_username && $password === $db_user_password) {

            $_SESSION['username']  = $db_username;
            $_SESSION['firstname'] = $db_user_firstname;
            $_SESSION['lastname']  = $db_user_lastname;
            $_SESSION['user_role'] = $db_user_role;

            redirect("/cms/admin");
        } else {
            return false;
        }
    }
    return true;
}

?>