<!-- Database connection -->
<?php include('includes/db.php'); ?>

<!-- HTML header -->
<?php include('includes/header.php'); ?>

<!-- Navbar -->
<?php include('includes/navigation.php'); ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <p class="lead">
                All post by
                <strong>
                    <?php echo $_GET['author']; ?>
                </strong>
            </p>

            <?php
            if (isset($_GET['p_id'])) {
                $the_post_id     = $_GET['p_id'];
                $the_post_author = $_GET['author'];

                $query               = "SELECT * FROM posts WHERE post_author = '{$the_post_author}'";
                $select_a_post_query = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($select_a_post_query)) {

                    $post_id      = $row['post_id'];
                    $post_title   = $row['post_title'];
                    $post_author  = $row['post_author'];
                    $post_date    = $row['post_date'];
                    $post_image   = $row['post_image'];
                    $post_content = substr($row['post_content'], 0, 100);
                    ?>

                    <!-- Blog Post -->
                    <div class="post-title">
                        <h2>
                            <a href="post.php?p_id=<?php echo $post_id; ?>">
                                <?php echo $post_title; ?>
                            </a>
                        </h2>
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
                    <p><span class="glyphicon glyphicon-time"></span>
                        <?php echo $post_date; ?>
                    </p>
                    <a href="post.php?p_id=<?php echo $post_id; ?>">
                        <img class="img-responsive" width="800" height="200" src="images/<?php echo $post_image; ?>" alt="">
                    </a>
                    <hr>
                    <p>
                        <?php echo $post_content; ?>
                    </p>
                    <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span
                            class="glyphicon glyphicon-chevron-right"></span></a>

                    <hr><!-- Blog Post end -->

                    <?php
                }
            }
            ?>

        </div>

        <!-- Sidebar Widgets Column -->
        <?php include('includes/sidebar.php'); ?>

    </div><!-- /.row -->

    <hr>

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