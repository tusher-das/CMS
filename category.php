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

                if (isAdmin($_SESSION['username'])) {
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
                    <h2>
                        <a href="post.php?p_id=<?php echo $post_id; ?>">
                            <?php echo $post_title; ?>
                        </a>
                    </h2>
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
                        <img class="img-responsive" width="800" height="200" src="/cms/images/<?php echo $post_image; ?>"
                            alt="">
                    </a>
                    <hr>
                    <p>
                        <?php
                        $post_content = substr($post_content, 0, 100);
                        echo $post_content;
                        ?>
                    </p>
                    <a class="btn" href="/cms/post.php?p_id=<?php echo $post_id; ?>">continue reading <span
                            class="glyphicon glyphicon-chevron-right"></span></a>
                    <button class="btn heart-btn" title="Add to Favorite"><i class="fa-regular fa-heart"></i></button>

                    <hr><!-- ./Blog Post -->

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