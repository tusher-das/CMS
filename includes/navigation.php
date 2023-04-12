<nav class="navbar navbar-default nav-bg  navbar-fixed-top" role="navigation">
    <div class="container">

        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand logo" href="/cms">CodeFlow</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <!-- categories -->
                <?php
                $query                       = "SELECT * FROM categories";
                $select_all_categories_query = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($select_all_categories_query)) {
                    $cat_id    = $row['cat_id'];
                    $cat_title = $row['cat_title'];

                    $category_class     = '';
                    $registration_class = '';
                    $contact_class      = '';

                    $registration = 'registration.php';
                    $contact      = 'contact.php';

                    $pageName = basename($_SERVER['PHP_SELF']);
                    if (isset($_GET['category']) && $_GET['category'] == $cat_id) {
                        $category_class = 'active';
                    } elseif ($pageName == $registration) {
                        $registration_class = 'active';
                    } elseif ($pageName == $contact) {
                        $contact_class = 'active';
                    }
                    echo "<li class='$category_class'><a href='/cms/category/$cat_id'>{$cat_title}</a></li>";
                }
                ?> <!-- ./categories -->

                <li class='<?php echo $contact_class; ?>'>
                    <a href="/cms/contact">Contact</a>
                </li>

                <?php if (isLoggedIn()): ?>
                    <li>
                        <a href="/cms/admin">Admin</a>
                    </li>
                    <li>
                        <a href="/cms/includes/logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="/cms/login">Login</a>
                    </li>
                    <li class='<?php echo $registration_class; ?>'>
                        <a href="/cms/registration">Registration</a>
                    </li>

                <?php endif; ?>
            </ul>

            <!-- Blog Search -->
            <form class="navbar-form navbar-right" action="search.php" method="post">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                        <button name="submit" class="btn btn-default" type="submit">
                            <span class="glyphicon glyphicon-search search-icon"></span>
                        </button>
                    </span>
                </div>
            </form>
        </div>

        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>