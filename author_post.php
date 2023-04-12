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
                    <h2>
                        <a href="post.php?p_id=<?php echo $post_id; ?>">
                            <?php echo $post_title; ?>
                        </a>
                    </h2>
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

                    <button class="btn heart-btn" title="Add to Favorite"><i class="fa-regular fa-heart"></i></button>

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