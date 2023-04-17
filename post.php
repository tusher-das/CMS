<!-- Database connection -->
<?php include('includes/db.php'); ?>

<!-- HTML header -->
<?php include('includes/header.php'); ?>

<!-- Navigation -->
<?php include('includes/navigation.php'); ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <?php
            if (isset($_GET['p_id'])) {
                $the_post_id = $_GET['p_id'];

                //query to increase view count
                $view_query = "UPDATE posts SET post_views_count = post_views_count+1 WHERE post_id = $the_post_id";
                $send_query = mysqli_query($connection, $view_query);
                if (!$send_query) {
                    die("Query Failed " . mysqli_error($connection));
                }

                if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
                    $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
                } else {
                    $query = "SELECT * FROM posts WHERE post_id = $the_post_id AND post_status = 'published'";
                }

                $select_a_post_query = mysqli_query($connection, $query);

                if (mysqli_num_rows($select_a_post_query) < 1) {
                    echo "<h1 class='text-center'>This post is not published yet!</h1>";
                } else {
                    while ($row = mysqli_fetch_assoc($select_a_post_query)) {

                        $post_title   = $row['post_title'];
                        $post_author  = $row['post_author'];
                        $post_date    = $row['post_date'];
                        $post_image   = $row['post_image'];
                        $post_content = $row['post_content'];

                        //    Blog Post
                        showSingleBlogPost($post_title, $the_post_id, $post_author, $post_image, $post_date, $post_content);

                    }

                    // <!-- Blog Comments form -->
                    createCommentForm();
                    // <!-- Posted Comments -->
                    showPostComments($the_post_id);
                }

            } else {
                header("Location: index.php");
            }
            ?>


        </div>

        <!-- Sidebar Widgets Column -->
        <?php include('includes/sidebar.php'); ?>

    </div>
    <!-- /.row -->

    <!-- Footer -->
    <?php include('includes/footer.php'); ?>

    <!-- Favorite list add & remove -->
    <?php
    if (isset($_POST['add_favorite'])) {
        $the_post_id    = $_POST['post_id'];
        $the_post_title = $_POST['post_title'];
        $the_user_id    = $_SESSION['user_id'];
        if (!empty($the_post_id) && !empty($the_post_title) && !empty($the_user_id)) {
            $query              = "INSERT INTO `favorites` (`favorite_id`, `user_id`, `post_id`, `post_title`) VALUES (NULL, '{$the_user_id}', '{$the_post_id}', '{$the_post_title}')";
            $add_favorite_query = mysqli_query($connection, $query);
            confirm_query($add_favorite_query);
            header("Refresh:0");
        }

    }

    if (isset($_POST['remove_favorite'])) {
        $the_post_id           = $_POST['post_id'];
        $remove_faborite_query = "DELETE FROM favorites WHERE post_id = $the_post_id";
        $remove_faborite       = mysqli_query($connection, $remove_faborite_query);
        confirm_query($remove_faborite);
        header("Refresh:0");
    }
    ?>