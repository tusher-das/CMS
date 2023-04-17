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

            if (isset($_GET['category'])) {
                $post_category_id = $_GET['category'];

                if (isAdmin(isset($_SESSION['username']))) {
                    $stm1 = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_category_id = ?");
                } else {
                    $stm2      = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_category_id = ? AND post_status = ?");
                    $published = 'published';
                }

                if (isset($stm1)) {
                    mysqli_stmt_bind_param($stm1, 'i', $post_category_id);
                    mysqli_stmt_execute($stm1);
                    mysqli_stmt_bind_result($stm1, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);
                    mysqli_stmt_store_result($stm1);
                    $stmt = $stm1;
                } else {
                    mysqli_stmt_bind_param($stm2, 'is', $post_category_id, $published);
                    mysqli_stmt_execute($stm2);
                    mysqli_stmt_bind_result($stm2, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);
                    mysqli_stmt_store_result($stm2);
                    $stmt = $stm2;
                }

                // $select_a_category_all_post_query = mysqli_query($connection, $query);
            
                if (mysqli_stmt_num_rows($stmt) == 0) {
                    echo "<h1 class='text-center'>No posts available</h1>";
                }
                while (mysqli_stmt_fetch($stmt)):
                    ?>

                    <!-- Blog Post -->
                    <?php showAllBlogPosts($post_id, $post_title, $post_author, $post_date, $post_image, $post_content) ?>


                <?php endwhile;
                mysqli_stmt_close($stmt);
            } else {
                header("Locations: index.php");
            }
            ?>

        </div>

        <!-- Sidebar Widgets Column -->
        <?php include('includes/sidebar.php'); ?>

    </div>
    <!-- /.row -->

    <hr>

    <!-- Footer -->
    <?php include('includes/footer.php'); ?>


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