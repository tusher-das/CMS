<?php

function redirect($location)
{
    header("Location: " . $location);
    // exit;
}

function confirm_query($result)
{
    global $connection;
    if (!$result) {
        die("Query Failed " . mysqli_error($connection));
    }
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


//category related functions
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
//categories functions end

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


// Login & registration function
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
            $_SESSION['user_id']   = $db_user_id;

            redirect("/cms/admin");
        } else {
            return false;
        }
    }
    return true;
}
// Login & registration function end


function showAllBlogPosts($post_id, $post_title, $post_author, $post_date, $post_image, $post_content)
{
    global $connection
    ?>
    <div class="post-title">
        <h2><a href="/cms/post.php?p_id=<?php echo $post_id; ?>"> <?php echo $post_title; ?> </a></h2>

        <!-- show add to favorite list button when user is logged in -->
        <?php if (isLoggedIn()): ?>
            <form action="" method="post">
                <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                <input type="hidden" name="post_title" value="<?php echo $post_title; ?>">
                <!-- Condition to check post already in favorite list or not -->
                <?php
                $select_isFavorite_query = "SELECT * FROM favorites WHERE post_id = '{$post_id}' AND user_id = '{$_SESSION['user_id']}'";
                $isFavorite              = mysqli_query($connection, $select_isFavorite_query);
                if (mysqli_num_rows($isFavorite) > 0) {
                    echo "<button type='submit' title='add to favorite list' name='remove_favorite' class='btn heart-btn'><i class='fa-solid fa-heart'></i></button>";
                } else {
                    echo "<button type='submit' title='add to favorite list' name='add_favorite' class='btn heart-btn'><i class='fa-regular fa-heart'></i></button>";

                }
                ?>
            </form>
        <?php endif; ?>
        <!-- ./ -->
    </div>

    <p class="lead">
        by <a href="/cms/author_post.php?author=<?php echo $post_author; ?>&p_id=<?php echo $post_id; ?>">
            <?php echo $post_author; ?>
        </a>
    </p>
    <p><span class="glyphicon glyphicon-time"></span>
        <?php echo $post_date; ?>
    </p>
    <hr>
    <a href="post.php?p_id=<?php echo $post_id; ?>">
        <img class="img-responsive" width="800" height="200" src="/cms/images/<?php echo $post_image; ?>" alt="">
    </a>
    <hr>
    <p>
        <?php
        $post_content = substr($post_content, 0, 100);
        echo $post_content . '...';
        ?>
        <a class="btn" href="/cms/post.php?p_id=<?php echo $post_id; ?>">continue reading <span
                class="glyphicon glyphicon-chevron-right"></span></a>
    </p>

    <hr><!-- Blog End -->
    <?php
}

function showSingleBlogPost($post_title, $the_post_id, $post_author, $post_image, $post_date, $post_content)
{
    global $connection;
    ?>
    <div class="post-title">
        <h2>
            <?php echo $post_title; ?>
        </h2>
        <!-- show add to favorite list button when user is logged in -->
        <?php if (isLoggedIn()): ?>
            <form action="" method="post">
                <input type="hidden" name="post_id" value="<?php echo $the_post_id; ?>">
                <input type="hidden" name="post_title" value="<?php echo $post_title; ?>">
                <!-- Condition to check post already in favorite list or not -->
                <?php
                $select_isFavorite_query = "SELECT * FROM favorites WHERE post_id = '{$the_post_id}' AND user_id = '{$_SESSION['user_id']}'";
                $isFavorite              = mysqli_query($connection, $select_isFavorite_query);
                if (mysqli_num_rows($isFavorite) > 0) {
                    echo "<button type='submit' title='add to favorite list' name='remove_favorite' class='btn heart-btn'><i class='fa-solid fa-heart'></i></button>";
                } else {
                    echo "<button type='submit' title='add to favorite list' name='add_favorite' class='btn heart-btn'><i class='fa-regular fa-heart'></i></button>";

                }
                ?>
            </form>
        <?php endif; ?>
        <!-- ./ -->
    </div>
    <p class="lead">
        by <a href="/cms/author_post.php?author=<?php echo $post_author; ?>&p_id=<?php echo $the_post_id; ?>">
            <?php echo $post_author; ?>
        </a>
    </p>
    <p><span class="glyphicon glyphicon-time"></span>
        <?php echo $post_date; ?>
    </p>
    <hr>
    <!-- <a href="post.php?p_id=<?php //echo $the_post_id; ?>"> -->
    <img class="img-responsive" width="800" height="200" src="/cms/images/<?php echo $post_image; ?>" alt="">
    <!-- </a> -->
    <hr>
    <p>
        <?php echo $post_content; ?>
    </p>

    <hr>
    <?php
}

function createCommentForm()
{
    global $connection;
    if (isset($_POST['create_comment'])) {
        $the_post_id = $_GET['p_id'];

        $comment_author  = $_POST['comment_author'];
        $comment_email   = $_POST['comment_email'];
        $comment_content = $_POST['comment_content'];

        if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
            $query                = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date)";
            $query .= "VALUES ($the_post_id, '$comment_author', '$comment_email', '$comment_content', 'unapprove', now())";
            $create_comment_query = mysqli_query($connection, $query);
            if (!$create_comment_query) {
                die("Query Failed " . mysqli_error($connection));
            }

            //query to update post comment count
            $query                       = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";
            $query .= "WHERE post_id = $the_post_id";
            $increase_post_comment_count = mysqli_query($connection, $query);
            confirm_query($increase_post_comment_count);

        } else {
            echo "<script>alert('Fields cannot be empty.')</script>";
        }
    }
    ?>
    <!-- Comments Form -->
    <div class="well">
        <h4>Leave a Comment:</h4>
        <form role="form" action="" method="post">
            <div class="form-group">
                <label for="comment_author">Author</label>
                <input type="text" class="form-control" name="comment_author">
            </div>
            <div class="form-group">
                <label for="comment_email">Email</label>
                <input type="email" class="form-control" name="comment_email">
            </div>
            <div class="form-group">
                <label for="comment">Your Comment</label>
                <textarea class="form-control" name="comment_content" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" name="create_comment">Submit</button>
        </form>
    </div><!-- ./Comments Form -->
    <hr>

    <?php
}

function showPostComments($the_post_id)
{
    global $connection;
    $query = "SELECT * FROM comments WHERE comment_post_id = $the_post_id ";
    $query .= "AND comment_status = 'approved' ";
    $query .= "ORDER BY comment_id DESC ";

    $select_comment_query = mysqli_query($connection, $query);
    confirm_query($select_comment_query);

    while ($row = mysqli_fetch_array($select_comment_query)) {
        $comment_date    = $row['comment_date'];
        $comment_content = $row['comment_content'];
        $comment_author  = $row['comment_author'];
        ?>
        <div class="media">

            <a class="pull-left" href="#">
                <img class="media-object" src="http://placehold.it/64x64" alt="">
            </a>
            <div class="media-body">
                <h4 class="media-heading">
                    <?php echo $comment_author; ?>
                    <small>
                        <?php echo $comment_date; ?>
                    </small>
                </h4>
                <?php echo $comment_content; ?>
            </div>
        </div>
        <?php
    }
}

?>