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
            //pagination
            $per_page = 2;
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = "";
            }

            if ($page == "" || $page == 1) {
                $page_1 = 0;
            } else {
                $page_1 = ($page * $per_page) - $per_page;
            } //pagination end
            

            //role based query to show post
            if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
                $post_query_count = "SELECT * FROM posts";
            } else {
                $post_query_count = "SELECT * FROM posts WHERE post_status = 'published'";
            }
            $find_count = mysqli_query($connection, $post_query_count);
            $count      = mysqli_num_rows($find_count);


            if ($count < 1) {
                echo "<h1 class='text-center'>No posts available</h1>";
            } else {
                $count = ceil($count / $per_page);

                $query                 = "SELECT * FROM posts LIMIT $page_1, $per_page";
                $select_all_post_query = mysqli_query($connection, $query);


                while ($row = mysqli_fetch_assoc($select_all_post_query)) {
                    $post_id      = $row['post_id'];
                    $post_title   = $row['post_title'];
                    $post_author  = $row['post_author'];
                    $post_date    = $row['post_date'];
                    $post_image   = $row['post_image'];
                    $post_content = substr($row['post_content'], 0, 100);
                    ?>

                    <!-- Blog -->
                    <?php showAllBlogPosts($post_id, $post_title, $post_author, $post_date, $post_image, $post_content); ?>

                    <?php
                }

            }
            ?>

            <!-- Pager -->
            <ul class="pager">
                <?php
                for ($i = 1; $i <= $count; $i++) {
                    if ($i == $page) {
                        echo "<li>
                    <a class='active_link' href='index.php?page={$i}'>{$i}</a>
                </li>";
                    } else {
                        echo "<li>
                    <a href='index.php?page={$i}'>{$i}</a>
                </li>";
                    }

                }
                ?>
            </ul><!-- Pager -->

        </div> <!-- Blog Column End -->

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